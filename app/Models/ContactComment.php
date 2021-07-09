<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactComment extends Model
{
    protected $table = 'contact_comments';

    protected $fillable = [
        'name',
        'email',
        'comment',
    ];

}
