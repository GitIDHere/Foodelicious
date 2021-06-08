<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeRatings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_profile_id',
        'recipe_id',
        'rating'
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
}
