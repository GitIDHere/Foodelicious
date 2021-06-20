<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path'
    ];


    /**
     * @var array
     */
    protected $appends = [
        'public_path',
        'thumbnail_path'
    ];


    /**
     * @return string
     */
    public function getPublicPathAttribute()
    {
        return 'storage/'.$this->path;
    }

    /**
     * @return string
     */
    public function getThumbnailPathAttribute()
    {
       return 'storage/thumb/'.$this->path;
    }

    /**
     * @return bool
     */
    public function isAttachedToRelation()
    {
        $isAttached = false;

        switch (true) {
            case $this->userProfile()->exists():
            case $this->recipe()->exists():
                $isAttached = true;
                break;
        }

        return $isAttached;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function recipe()
    {
        return $this->hasOneThrough(
            Recipe::class,
            RecipeImages::class,
            'file_id',
            'id',
            '',
            'recipe_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function userProfile()
    {
        return $this->hasOneThrough(
            UserProfile::class,
            UserProfileImages::class,
            'file_id',
            'id',
            '',
            'user_profile_id'
        );
    }

}
