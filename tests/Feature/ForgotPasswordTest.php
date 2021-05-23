<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use App\Notifications\PasswordReset;
use App\Services\Auth\PasswordResetService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $testUserEmail = '';

    private $testUserPassword = '';

    private $testUsername = '';

    private $maxAttempts = 5;

    private $testUser = null;


    protected function setUp(): void
    {
        parent::setUp();

        $this->testUserEmail = env('TEST_USER_EMAIL', 'test@user.com');
        $this->testUserPassword = env('TEST_USER_PASSWORD', 'password');
        $this->testUsername = env('TEST_USER_USERNAME', 'test_user');

        $this->testUser = User::factory()
            // Build the relation
            ->has(
                UserProfile::factory()
                    ->count(1)
            )
            ->create([
                'email' => $this->testUserEmail,
                'password' => Hash::make($this->testUserPassword),
                'email_verified_at' => now(),
                'is_active' => 1,
                'remember_token' => Str::random(10)
            ])
        ;
    }

    public function test_user_must_exist()
    {
        $user = $this->testUser;

        $response = $this->json('POST', route('forgot_password.submit'), [
            'email' => $user->email,
        ]);

        $response->assertStatus(204);
    }


    public function test_only_allows_registered_users_to_request_password_reset()
    {
        $response = $this->json('POST', route('forgot_password.submit'), [
            'email' => 'not@exists.com',
        ]);

        $response->assertStatus(422);

        $response->assertJson(function(AssertableJson $json){
            $json
                ->has('errors.email')
                ->etc();
        });
    }


    public function test_allows_maximum_of_n_attempts()
    {
        // We have to go +1 on the attempts to go over the limit, hence <=
        for ($attempt = 0; $attempt <= $this->maxAttempts; $attempt++)
        {
            $response = $this->json('POST', route('forgot_password.submit'), [
                'email' => 'not@exists.com',
            ]);
        }

        $response->assertStatus(429);

        $response->assertJson(function(AssertableJson $json)
        {
            $json
                ->where('exception', ThrottleRequestsException::class)
                ->etc();
        });
    }


    public function test_allow_users_to_reattempt_after_n_minutes()
    {
        // We have to go +1 on the attempts to go over the limit, hence <=
        for ($attempt = 0; $attempt <= $this->maxAttempts; $attempt++)
        {
            $response = $this->json('POST', route('forgot_password.submit'), [
                'email' => 'not@exists.com',
            ]);
        }

        $response->assertStatus(429);

        // We have to travel forwards past 1 minute
        $this->travel(1)->minutes();
        $this->travel(1)->seconds();

        $response = $this->json('POST', route('forgot_password.submit'), [
            'email' => 'not@exists.com',
        ]);

        $response->assertStatus(422);

        $response->assertJson(function(AssertableJson $json){
            $json
                ->has('errors.email')
                ->etc();
        });
    }


    public function test_user_is_not_logged_in_when_making_request()
    {
        $user = $this->testUser;

        // Login
        $loginResponse = $this->json('POST', route('login.submit'), [
            'email' => $user->email,
            'password' => $this->testUserPassword
        ]);

        $loginResponse->assertStatus(204);

        $passwordResetResponse = $this->json('POST', route('forgot_password.submit'), [
            'email' => $user->email,
        ]);

        // If the user is logged in, then they will get redirected to Home
        $passwordResetResponse->assertStatus(302);
        $passwordResetResponse->assertRedirect(route('home'));
    }


    public function test_password_reset_token_gets_set_in_database()
    {
        $user = $this->testUser;
        $passwordResetTokenTable = config('auth.passwords.users.table');

        $response = $this->json('POST', route('forgot_password.submit'), [
            'email' => $user->email,
        ]);

        $this->assertDatabaseHas($passwordResetTokenTable, [
            'email' => $user->email,
            'created_at' => now()
        ]);
    }


    /**
     * https://laracasts.com/discuss/channels/testing/testing-if-email-was-sent-with-out-sending-it
     */
    public function test_password_reset_email_gets_sent_out()
    {
        $user = $this->testUser;

        $emails = $this->app->make('mailer')->getSwiftMailer()->getTransport()->messages();

        // Submit the password request
        $this->json('POST', route('forgot_password.submit'), [
            'email' => $user->email,
        ]);

        $this->assertInstanceOf(Collection::class, $emails);

        $latestEmail = $emails->first();

        $this->assertEquals([$user->email], array_keys($latestEmail->getTo()));
    }


    /** @test */
//    public function test_password_reset_email_token_expires_after_n_minutes()
//    {
//        $user = $this->testUser;
//        $tokenLifespanMinutes = env('PASSWORD_RESET_TOKEN_LIFESPAN');
//        $passwordResetTokenTable = config('auth.passwords.users.table');
//
//        // Set a forgot password request
//        $this->json('POST', route('forgot_password.submit'), [
//            'email' => $user->email,
//        ]);
//
//        // Check that the DB has the token
//        $this->assertDatabaseHas($passwordResetTokenTable, [
//            'email' => $user->email,
//            'created_at' => now()
//        ]);
//
//        $dbPasswordResetEntry = DB::table($passwordResetTokenTable)
//            ->where('email', $user->email)
//            ->first()
//        ;
//
//        // We need to go past the time
//        $this->travel($tokenLifespanMinutes + 1)->minutes();
//
//        //dd($passwordResetService->isTokenValid($token, $dbPasswordResetEntry->email));
//    }

    // You see the password reset form

    // the form/link gets expired

    // password is validated

    // ?? email is sent to confirm when password is reset

    // Check a log entry gets created when password is rest

}
