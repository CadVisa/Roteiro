<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model
{
    protected $table = 'estabelecimentos'; 

    public $timestamps = false;

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'atualizado_em',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'telefone_1',
        'telefone_2',
        'email',
        'criado_em',
        'criado_por',
        'path_roteiro',
    ];

    protected $casts = [
        'atualizado_em' => 'datetime',
        'criado_em' => 'datetime',
    ];

    public function cnaes()
    {
        return $this->hasMany(EstabCnae::class);
    }
}
