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
        'prep_directions',
        'ingredients',
        'visibility'
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

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

}
