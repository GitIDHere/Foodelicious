<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $testUserEmail = '';

    private $testUserPassword = '';

    private $testUser = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testUserEmail = env('TEST_USER_EMAIL', 'test@user.com');
        $this->testUserPassword = env('TEST_USER_PASSWORD', 'password');

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


    public function test_user_is_not_logged_in_when_making_request()
    {
        $user = $this->testUser;

        // Login
        $loginResponse = $this->json('POST', route('login.submit'), [
            'email' => $user->email,
            'password' => $this->testUserPassword
        ]);

        $loginResponse->assertStatus(204);


        /**
         * Login a second time
         */
        $secondLoginResponse = $this->json('POST', route('login.submit'), [
            'email' => $this->testUserEmail,
            'password' => $this->testUserPassword
        ]);

        // If the user is logged in, then they will get redirected to Home
        $secondLoginResponse->assertStatus(403);
    }

    public function test_user_gets_logged_in()
    {
        $resp = $this->json('POST', route('login.submit'), [
            'email' => $this->testUserEmail,
            'password' => $this->testUserPassword
        ]);

        $resp->assertStatus(204);
    }


    public function test_user_email_is_validated()
    {
        $resp = $this->json('POST', route('login.submit'), [
            'email' => '',
            'password' => $this->testUserPassword
        ]);

        $resp
            ->assertStatus(422)
            ->assertJson(function(AssertableJson $json)
            {
                $json
                    ->has('errors.email')
                    ->etc()
                ;
            })
        ;
    }

    public function test_user_email_exists()
    {
        $resp = $this->json('POST', route('login.submit'), [
            'email' => 'not@exists.com',
            'password' => $this->testUserPassword
        ]);

        $resp
            ->assertStatus(422)
            ->assertJson(function(AssertableJson $json)
            {
                $json
                    ->has('errors.email')
                    ->etc()
                ;
            })
        ;
    }

    public function test_user_gets_locked_out_after_n_attempts()
    {
        $maxAttempts = 6;

        for($attempts = 1; $attempts <= $maxAttempts; $attempts++)
        {
            $resp = $this->json('POST', route('login.submit'), [
                'email' => $this->testUserEmail,
                'password' => 'invalid_pass'
            ]);
        }

        // 429 = too many requests
        $resp->assertStatus(429);
    }
}
