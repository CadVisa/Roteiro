<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consent extends Model
{
    protected $table = 'consents';

    protected $fillable = [
        'token',
        'ip',
        'user_agent',
        'accepted',
    ];

}
