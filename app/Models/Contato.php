<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'contatos';

    public $timestamps = false;

    protected $fillable = [
        'ip',
        'nome',
        'email',
        'telefone',
        'descricao',
        'observacoes',
        'status',
    ];
}
