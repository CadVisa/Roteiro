<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs'; 

    public $timestamps = false;

    protected $fillable = [
        'log_data',
        'log_ip',
        'log_nivel',
        'log_chave',
        'log_descricao',
        'log_observacoes',
        'user_id',
    ];

    public function log()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
