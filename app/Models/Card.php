<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    public $timestamps = false;

    protected $fillable = [
        'card_icone',
        'card_titulo',
        'card_descricao',
        'card_ordem',
        'card_status',
    ];
}
