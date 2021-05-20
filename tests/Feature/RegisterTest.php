<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use Database\Seeders\UserSeeder;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    // Username is required
    public function test_username_is_required()
    {
        $resp = $this->json('POST', route('register.submit'), [
            'username' => '',
            'email' => 'not@exists.com',
            'password' => 'password',
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
            'username' => 'random_user',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
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
            'username' => 'random_user',
            'email' => 'not@exists.com',
            'password' => '',
            'password_confirmation' => 'password',
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
            'email' => 'not@exists.com',
            'password' => 'password',
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


    public function test_email_does_not_exist()
    {
        $this->seed(UserSeeder::class);

        // Get the first user after seeding the DB
        $user = User::where('id', 1)->first();

        $resp = $this->json('POST', route('register.submit'), [
            'username' => 'random_user',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'remember_me' => true
        ]);

        $resp->assertStatus(422);

        $resp->assertJson(function(AssertableJson $json){
            $json
                ->has('errors.email')
                ->etc();
        });
    }


    public function test_user_is_able_to_register()
    {
        $resp = $this->json('POST', route('register.submit'), [
            'username' => 'random_user',
            'email' => 'not@exists.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'remember_me' => true
        ]);

        $resp->assertStatus(302);
    }


    public function test_user_gets_inserted_into_database()
    {
        $testUserEmail = 'not@exists.com';

        $resp = $this->json('POST', route('register.submit'), [
            'username' => 'random_user',
            'email' => $testUserEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
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
            'email' => 'not@exists.com',
            'password' => 'password',
            'password_confirmation' => 'password',
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
            'username' => 'random_user',
            'email' => 'not@exists.com',
            'password' => 'password',
            'password_confirmation' => 'password',
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



















