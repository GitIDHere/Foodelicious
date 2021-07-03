<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeFavourites extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_profile_id',
        'recipe_id',
        'is_favourited'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeFavourited($query)
    {
        return $query
            ->where('is_favourited', 1);
    }

}
