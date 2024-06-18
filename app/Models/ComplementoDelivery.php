<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplementoDelivery extends Model
{
    protected $fillable = [
		'nome', 'valor', 'categoria_id'
	];

	public function nome(){
		$nome = explode('>', $this->nome);
		if(sizeof($nome) > 1) return $nome[1];
		return $this->nome;
	}

	public function categoria(){
        return $this->belongsTo(CategoriaAdicional::class, 'categoria_id');
    }
}
