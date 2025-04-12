<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cnae extends Model
{
    protected $table = 'base_cnaes';

    public $timestamps = false;

    protected $fillable = [
        'codigo_cnae',
        'codigo_limpo',
        'descricao_cnae',
        'grau_cnae',
        'competencia',
        'notas_s_compreende',
        'notas_n_compreende',
    ];

    public function perguntas()
    {
        return $this->hasMany(Pergunta::class);
    }

    public function movimentos()
    {
        return $this->hasMany(Movimento::class, 'base_cnae_id');
    }
}
