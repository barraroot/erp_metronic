<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaAdicional extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome', 'limite_escolha', 'adicional'
    ];

    public function adicionais(){
        return $this->hasMany('App\Models\ComplementoDelivery', 'categoria_id', 'id');
    }
}
