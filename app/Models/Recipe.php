<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'cooking_steps',
        'cook_time',
        'servings',
        'utensils',
        'ingredients'
    ];

    protected $guarded = [
      'cook_time_formatted'
    ];

    protected $casts = [
        'cooking_steps' => 'array',
        'utensils' => 'array',
        'ingredients' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this
            ->belongsToMany(File::class, 'recipe_images', 'recipe_id', 'file_id')
            ->using(RecipeImages::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipeFavourites()
    {
        return $this->hasMany(RecipeFavourites::class, 'recipe_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipeComments()
    {
        return $this->hasMany(RecipeComments::class, 'recipe_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function recipeMetadata()
    {
        return $this->hasOne(RecipeMetadata::class,'recipe_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getIsPublishedAttribute()
    {
        return $this->recipeMetaData->is_published;
    }

    /**
     * @return mixed
     */
    public function getEnableCommentsAttribute()
    {
        return $this->recipeMetaData->enable_comments;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublic($query)
    {
        return $query
            ->join('recipe_metadata', 'recipe_id', '=', 'recipes.id')
            ->where('is_published', 1);
    }

    /**
     * @return string
     */
    public function getCookTimeFormattedAttribute()
    {
        $formattedCookTimes = [];
        $cookTimeParts = explode(':', $this->cook_time);

        if ($cookTimeParts[0] != 0) {
            $formattedCookTimes[] = ltrim($cookTimeParts[0], '0') . ' hour';
        }

        $formattedCookTimes[] = $cookTimeParts[1] . ' minutes';

        return implode(' ', $formattedCookTimes);
    }

}
