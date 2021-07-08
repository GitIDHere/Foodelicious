<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeMetadata extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'recipe_id';

    protected $fillable = [
        'recipe_id',
        'is_published',
        'enable_comments'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
