<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaProdutoEcommerce extends Model
{
    protected $fillable = [
		'nome', 'img'
	];

	public function produtos(){
        return $this->hasMany('App\Models\ProdutoEcommerce', 'categoria_id', 'id');
    }
}
