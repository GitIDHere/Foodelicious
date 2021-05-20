<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Database\Seeders\UserSeeder;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @var string|null  */
    private $authSessionKey = null;


    protected function setUp(): void
    {
        parent::setUp();

        $this->authSessionKey = 'login_web_'.sha1(SessionGuard::class);
    }


    /** @test */
    public function test_user_is_logged_out()
    {
        $this->seed(UserSeeder::class);

        // Get the first user after seeding the DB
        $user = User::where('id', 1)->first();

        // Login
        $this->json('POST', route('login.submit'), [
            'email' => $user->email,
            'password' => 'qqq'
        ]);

        $loginSessionBag = Session::all();

        // Determine if the user is actually logged in by checking that there is an entry in the Session
        $this->assertTrue(isset($loginSessionBag[$this->authSessionKey]));

        $this->json('GET', route('logout'));

        $logoutSessionBag = Session::all();

        // If the user is logged out, then there shouldn't be an auth entry in session
        $this->assertTrue(isset($logoutSessionBag[$this->authSessionKey]) == false);
    }

}
