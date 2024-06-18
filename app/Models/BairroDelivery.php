<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BairroDelivery extends Model
{
    protected $fillable = [
        'nome', 'valor_entrega', 'valor_repasse'
    ];
}
