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
        'public_path'  
    ];
    
    
    /**
     * @return string
     */
    public function getPublicPathAttribute()
    {
        return 'storage/'.$this->path;
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    
}
