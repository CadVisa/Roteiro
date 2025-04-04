<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'configurations';

    public $timestamps = false;

    protected $fillable = [
        'usa_api',
    ];
}
