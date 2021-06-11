<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'description',
    ];

    protected $guarded = [
        'short_description'
    ];

    /**
     * User profile belongs to one User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this
            ->belongsToMany(File::class, 'user_profile_images', 'user_profile_id', 'file_id')
            ->using(UserProfileImages::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipeFavourites()
    {
        return $this->hasMany(RecipeFavourites::class, 'user_profile_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipeComments()
    {
        return $this->hasMany(RecipeComments::class, 'user_profile_id', 'id');
    }

    /**
     * @return string
     */
    public function getShortDescriptionAttribute()
    {
        return Str::substr($this->description, 0, 250).'...';
    }

}
