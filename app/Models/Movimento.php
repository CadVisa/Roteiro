<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    protected $table = 'movimentos'; 

    public $timestamps = false;

    protected $fillable = [
        'base_cnae_id',
        'user_id',
        'tipo_movimento',
        'data_movimento',
        'descricao_movimento',        
    ];

    public function cnae()
    {
        return $this->belongsTo(Cnae::class);
    }
}
