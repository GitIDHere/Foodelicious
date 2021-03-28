<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'username',
        'forename',
        'surname',
        'desc',
    ];
    
    protected $attributes = [
        'full_name'  
    ];
    
    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->forename.' '.$this->surname;
    }
    
    
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
    
}
