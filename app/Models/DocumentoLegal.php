<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoLegal extends Model
{
    protected $table = 'documentos_legais';

    protected $fillable = [
        'termos_uso',
        'politica_privacidade',
        'versao',
    ];

    public function consents()
    {
        return $this->hasMany(Consent::class);
    }
}
