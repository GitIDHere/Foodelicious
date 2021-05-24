<?php

namespace App\Services\Auth;

use App\Mail\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class PasswordResetService
{
    protected static $passwordResetRoute = 'password_reset.show';


    /**
     * Get the number of minutes the token is valid for
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getTokenActiveLength()
    {
        return config('auth.passwords.' . config('auth.defaults.passwords').'.expire');
    }

    /**
     * @return Carbon
     */
    protected function getExpiryDate()
    {
        $expireMinutes = self::getTokenActiveLength();

        $now = Carbon::now();
        $now->addMinutes($expireMinutes);
        return $now;
    }

    /**
     * @param $token
     * @param $email
     * @return string
     */
    protected function createPasswordResetURL($token, $email)
    {
        return URL::route(self::$passwordResetRoute, [
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * @return string
     */
    public static function getPasswordResetRoute()
    {
        return self::$passwordResetRoute;
    }


    /**
     * Delete the password reset
     * @param $token
     * @param $email
     */
    public function removeToken($token, $email)
    {
        $tokenEntry = $this->getTokenEntry($token, $email);

        if ($tokenEntry)
        {
            /*
             * Can't add `token` as a conditional because they are stored as hashed tokens
             */
            DB::table('password_resets')
                ->where('created_at', '=', $tokenEntry->created_at)
                ->where('email', '=', $email)
                ->delete()
            ;
        }
    }

    /**
     * @param $token
     * @param $email
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    private function getTokenEntry($token, $email)
    {
        $passwordResetEntry = DB::table('password_resets')
            ->where('email', '=', $email)
            ->first();

        if ($passwordResetEntry)
        {
            $dbToken = $passwordResetEntry->token;

            // Check if the supplied token matches
            if (Hash::check($token, $dbToken))
            {
                return $passwordResetEntry;
            }
        }

        return null;
    }

    /**
     * @param string $token
     * @param string $email
     * @return bool
     */
    public function isTokenValid($token, $email)
    {
        $tokenEntry = $this->getTokenEntry($token, $email);
        $tokenActiveLength = self::getTokenActiveLength();

        // Check if the token is still valid
        $created = $tokenEntry->created_at;
        $createdDate = Carbon::make($created);
        $createdDate->addMinutes($tokenActiveLength);

        $now = Carbon::now();

        if ($now->lte($createdDate)) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Get the password reset email
     *
     * @param $token
     * @param $email
     * @param $username
     * @return PasswordReset
     */
    public function getEmail($token, $email, $username)
    {
        $expiryDate = $this->getExpiryDate();
        $url = $this->createPasswordResetURL($token, $email);

        $passwordResetEmail = new PasswordReset($username);

        $passwordResetEmail->setTokens([
            'passwordResetURL' => $url,
            'expirationDateTime' => $expiryDate->format('d/m/Y H:i:s'),
        ]);

        return $passwordResetEmail;
    }

}
