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
    
    
    /**
     * User profile belongs to one User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
