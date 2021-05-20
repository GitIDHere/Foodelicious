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
