<?php namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    
    
    /**
     * @param $email
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function register($email, $password)
    {
        $existingUser = User::where('email', '=', $email)->first();
        
        if (empty($existingUser))
        {
            return User::create([
                'email' => $email,
                'password' => Hash::make($password)
            ]);            
        }
        else {
            throw new \Exception('Email is taken');
        }
    }
    
    
}
