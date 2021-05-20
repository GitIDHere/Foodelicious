<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $testUserEmail = 'test@user.com';

    private $testUserPassword = 'password';


    protected function setUp(): void
    {
        parent::setUp();

        User::create([
            'email' => $this->testUserEmail,
            'password' => bcrypt($this->testUserPassword)
        ]);
    }


    /** @test */
    public function test_user_gets_logged_in()
    {
        $resp = $this->json('POST', route('login.submit'), [
            'email' => $this->testUserEmail,
            'password' => $this->testUserPassword
        ]);

        $resp->assertStatus(204);
    }


    /** @test */
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

    /** @test */
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

    /** @test */
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
