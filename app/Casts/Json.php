<?php namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Json implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        if (!is_array($value)) {
            return json_decode($value);
        }

        return $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_array($value)) {
            return json_encode($value);
        }

        return $value;
    }
}
