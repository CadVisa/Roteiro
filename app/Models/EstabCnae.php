<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstabCnae extends Model
{
    protected $table = 'estab_cnaes';

    public $timestamps = false;

    protected $fillable = [
        'estabelecimento_id',
        'codigo_cnae',
        'codigo_limpo',
        'descricao_cnae',
        'grau_cnae',
        'competencia',
        'notas_s_compreende',
        'notas_n_compreende',
    ];

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class);
    }

    public function perguntas()
    {
        return $this->hasMany(EstabPergunta::class, 'estab_cnae_id');
    }

    public function atualizarBaseCnae()
    {
        $baseCnae = Cnae::where('codigo_limpo', $this->codigo_limpo)->first();

        if ($baseCnae) {
            $this->update([
                'grau_cnae' => $baseCnae->grau_cnae,
                'competencia' => $baseCnae->competencia,
                'notas_s_compreende' => $baseCnae->notas_s_compreende,
                'notas_n_compreende' => $baseCnae->notas_n_compreende
            ]);
        }

        return $this;
    }

    public function adicionarPerguntas()
    {
        // Busca o CNAE correspondente na tabela Cnae
        $cnae = Cnae::where('codigo_limpo', $this->codigo_limpo)->first();

        if (!$cnae) {
            return $this;
        }

        // Busca perguntas específicas para este CNAE e perguntas gerais
        $perguntas = Pergunta::where('cnae_id', $cnae->id)
            ->get();

        $perguntasParaInserir = [];
        foreach ($perguntas as $pergunta) {
            $perguntasParaInserir[] = [
                'estab_cnae_id' => $this->id,
                'pergunta' => $pergunta->pergunta,
                'competencia' => $pergunta->competencia,
                'grau_sim' => $pergunta->grau_sim,
                'grau_nao' => $pergunta->grau_nao,
            ];
        }

        // Insere todas de uma vez
        if (!empty($perguntasParaInserir)) {
            EstabPergunta::insert($perguntasParaInserir);
        }

        return $this;
    }
}
