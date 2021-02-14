<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    
    const IS_PUBLIC = 'public';
    
    const IS_PRIVATE = 'private';
    
    /**
     * @var array 
     */
    protected $fillable = [
        'title',
        'description',
        'directions',
        'cook_time',
        'servings',
        'utensils',
        'prep_directions',
        'ingredients',
        'is_public'
    ];
    
    /**
     * @var array 
     */
    protected $casts = [
        'is_public' => 'boolean'  
    ];
    
    
    /**
     * If $visibility is string then compare it with self::IS_PUBLIC to see if it is set to public.
     * @param $visibility
     */
    public function setIsPublicAttribute($visibility)
    {
        if (is_string($visibility)) {
            $this->attributes['is_public'] = ($visibility === self::IS_PUBLIC);
        }
        else {
            $this->attributes['is_public'] = $visibility;    
        }
    }
    
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
    
}
