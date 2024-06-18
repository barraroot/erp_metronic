<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaPreco extends Model
{
    protected $fillable = [
		'nome', 'percentual_alteracao'
	];

	public function itens(){
        return $this->hasMany('App\Models\ProdutoListaPreco', 'lista_id', 'id');
    }
}
