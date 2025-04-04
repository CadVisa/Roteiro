<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstabPergunta extends Model
{
    protected $table = 'estab_perguntas';

    public $timestamps = false;

    protected $fillable = [
        'estab_cnae_id',
        'pergunta',
        'competencia',
        'grau_sim',
        'grau_nao',
    ];

    public function estabCnae()
    {
        return $this->belongsTo(EstabCnae::class, 'estab_cnae_id');
    }
}
