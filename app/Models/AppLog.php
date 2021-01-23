<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    use HasFactory;
    
    protected $table = 'app_logs';
    
    protected $fillable = [
        'ip',
        'user_agent',
        'type',
        'http_referrer',
        'message',
    ];
    
    
}
