<?php

if (! function_exists('isDev')) 
{
    function isDev()
    {
        $env = strtolower(env('APP_ENV'));
        return ($env == 'dev' || $env == 'local');
    }
}

if (! function_exists('randUsername')) 
{
    function randUsername()
    {
        $username = '';
        if (isDev()) {
            $username = 'user'.rand(0, 999);            
        }
        return $username;
    }
}

if (! function_exists('randEmail')) 
{
    function randEmail()
    {
        $email = '';
        if (isDev()) {
            $email = 'user'.rand(0, 999).'@gmail.com';            
        }
        return $email;
    }
}