<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrosselEcommerce extends Model
{
	protected $fillable = [ 
		'titulo', 'descricao', 'img', 'link_acao', 'nome_botao'
	];
}
