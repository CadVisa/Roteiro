<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstabelecimentoAcesso extends Model
{
    protected $table = 'estabelecimento_acessos'; 

    public $timestamps = false;

    protected $fillable = ['ip', 'data'];
}
