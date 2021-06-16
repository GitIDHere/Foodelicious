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

    /**
     * @param $value
     * @return mixed
     */
    public function getCookingStepsAttribute($value)
    {
        $steps = json_decode($value);
        array_unshift($steps,"");
        unset($steps[0]);
        return $steps;
    }

    public function getUtensilsAttribute($value)
    {
        $utensils = json_decode($value);
        array_unshift($utensils,"");
        unset($utensils[0]);
        return$utensils;
    }

    public function getIngredientsAttribute($value)
    {
        $utensils = json_decode($value);
        array_unshift($utensils,"");
        unset($utensils[0]);
        return$utensils;
    }

    public function scopePublic($query)
    {
        return $query->where('is_published', 1);
    }

}
