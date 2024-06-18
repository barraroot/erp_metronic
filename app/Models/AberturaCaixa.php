<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AberturaCaixa extends Model
{
    protected $fillable = [
        'usuario_id', 'valor', 'ultima_venda'
    ];
}
