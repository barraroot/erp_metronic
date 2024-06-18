<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaComplementoDelivery extends Model
{
    protected $fillable = [
		'produto_id', 'complemento_id'
	];

	public function complemento(){
        return $this->belongsTo(ComplementoDelivery::class, 'complemento_id');
    }

    public function produto(){
        return $this->belongsTo(ProdutoDelivery::class, 'produto_id');
    }
}
