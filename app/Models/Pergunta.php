<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    protected $table = 'base_perguntas';

    public $timestamps = false;

    protected $fillable = [
        'cnae_id ',
        'pergunta',
        'competencia',
        'grau_sim',
        'grau_nao',
    ];

    public function cnae()
    {
        return $this->belongsTo(Cnae::class);
    }
}


