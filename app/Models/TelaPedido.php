<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelaPedido extends Model
{
    protected $fillable = [
        'nome', 'alerta_amarelo', 'alerta_vermelho'
    ];
}
