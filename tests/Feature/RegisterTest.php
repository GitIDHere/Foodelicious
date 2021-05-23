<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use Database\Seeders\UserSeeder;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    private $testUserEmail = '';

    private $testUserPassword = '';

    private $testUsername = '';


    protected function setUp(): void
    {
        parent::setUp();

        $this->testUserEmail = env('TEST_USER_EMAIL', 'test@user.com');
        $this->testUserPassword = env('TEST_USER_PASSWORD', 'password');
        $this->testUsername = env('TEST_USER_USERNAME', 'test_user');
    }

    // Username is required
    public function test_username_is_required()
    {
        $resp = $this->json('POST', route('register.submit'), [
            'username' => '',
            'email' => $this->testUserEmail,
            'password' => $this->testUserPassword,
            'password_confirmation' => 'password',
            'remember_me' => true
        ]);

        $resp->assertStatus(422);

        $resp->assertJson(function(AssertableJson $json){
            $json
                ->has('errors.username')
                ->etc();
        });
    }


    public function test_email_is_required()
    {
        $resp = $this->json('POST', route('register.submit'), [
            'username' => $this->testUsername,
            'email' => '',
            'password' => $this->testUserPassword,
            'password_confirmation' => $this->testUserPassword,
            'remember_me' => true
        ]);

        $resp->assertStatus(422);

        $resp->assertJson(function(AssertableJson $json){
            $json
                ->has('errors.email')
                ->etc();
        });
    }


    public function test_password_is_required()
    {
        $resp = $this->json('POST', route('register.submit'), [
            'username' => $this->testUsername,
            'email' => $this->testUserEmail,
            'password' => '',
            'password_confirmation' => $this->testUserPassword,
            'remember_me' => true
        ]);

        $resp->assertStatus(422);

        $resp->assertJson(function(AssertableJson $json){
            $json
                ->has('errors.password')
                ->etc();
        });
    }

    public function test_username_does_not_exists_in_database()
    {
        $this->seed(UserSeeder::class);

        // Get the first user after seeding the DB
        $user = User::where('id', 1)->first();

        $username = $user->userProfile->username;

        $resp = $this->json('POST', route('register.submit'), [
            'username' => $username,
            'email' => $this->testUserEmail,
            'password' => $this->testUserPassword,
            'password_confirmation' => $this->testUserPassword,
            'remember_me' => true
        ]);

        $resp->assertStatus(422);

        $resp->assertJson(function(AssertableJson $json){
            $json
                ->has('errors.username')
                ->etc();
        });
    }


    public function test_user_email_is_not_already_registered()
    {
        $user = User::factory()->create([
            'email' => $this->testUserEmail,
            'password' => Hash::make($this->testUserPassword),
            'email_verified_at' => now(),
            'is_active' => 1,
        ]);

        $resp = $this->json('POST', route('register.submit'), [
            'username' => $this->testUsername,
            'email' => $user->email,
            'password' => $this->testUserPassword,
            'password_confirmation' => $this->testUserPassword,
            'remember_me' => true
        ]);

        $resp->assertStatus(422);

        $resp->assertJson(function(AssertableJson $json){
            $json
                ->has('errors.email')
                ->etc();
        });
    }


    public function test_user_can_register()
    {
        $resp = $this->json('POST', route('register.submit'), [
            'username' => $this->testUsername,
            'email' => $this->testUserEmail,
            'password' => $this->testUserPassword,
            'password_confirmation' => $this->testUserPassword,
            'remember_me' => true
        ]);

        $resp->assertStatus(302);
    }


    public function test_user_gets_inserted_into_database()
    {
        $testUserEmail = $this->testUserEmail;

        $resp = $this->json('POST', route('register.submit'), [
            'username' => $this->testUsername,
            'email' => $testUserEmail,
            'password' => $this->testUserPassword,
            'password_confirmation' => $this->testUserPassword,
            'remember_me' => true
        ]);

        $resp->assertStatus(302);

        // Check that the user got inserted into the database
        $user = User::where('email', $testUserEmail)->first();

        $this->assertInstanceOf(User::class, $user);
    }


    public function test_user_profile_gets_created_for_user()
    {
        $testUserUsername = 'random_user';

        $resp = $this->json('POST', route('register.submit'), [
            'username' => $testUserUsername,
            'email' => $this->testUserEmail,
            'password' => $this->testUserPassword,
            'password_confirmation' => $this->testUserPassword,
            'remember_me' => true
        ]);

        $resp->assertStatus(302);

        // Check that a user profile gets created for the user
        $userProfile = UserProfile::where('username', $testUserUsername)->first();

        $this->assertInstanceOf(UserProfile::class, $userProfile);
    }


    public function test_user_is_logged_in_after_registering()
    {
        $resp = $this->json('POST', route('register.submit'), [
            'username' => $this->testUsername,
            'email' => $this->testUserEmail,
            'password' => $this->testUserPassword,
            'password_confirmation' => $this->testUserPassword,
            'remember_me' => true
        ]);

        $resp->assertStatus(302);

        $loginSessionBag = Session::all();

        $this->assertTrue(isset($loginSessionBag['login_web_'.sha1(SessionGuard::class)]));
    }


    public function test_user_remember_token_gets_set()
    {
        $resp = $this->json('POST', route('register.submit'), [
            'username' => 'random_user',
            'email' => 'not@exists.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'remember_me' => true
        ]);

        $resp->assertStatus(302);

        $user = User::where('email', 'not@exists.com')->first();

        $this->assertNotNull($user->remember_token);
    }
}




