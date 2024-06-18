<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemIBTE;

class IBPT extends Model
{
	protected $table = 'i_b_p_t_s';
	protected $fillable = [
		'uf', 'versao'
	];

	public function itens(){
		return $this->hasMany('App\Models\ItemIBTE', 'ibte_id', 'id');
	}

	public static function estados(){
		return [
			"AC",
			"AL",
			"AM",
			"AP",
			"BA",
			"CE",
			"DF",
			"ES",
			"GO",
			"MA",
			"MG",
			"MS",
			"MT",
			"PA",
			"PB",
			"PE",
			"PI",
			"PR",
			"RJ",
			"RN",
			"RS",
			"RO",
			"RR",
			"SC",
			"SE",
			"SP",
			"TO",
			
		];
	}

	public static function getIBPT($uf, $codigo){
		$trib = ItemIBTE::
		join('i_b_p_t_s', 'i_b_p_t_s.id' , '=', 'item_i_b_t_e_s.ibte_id')
		->where('i_b_p_t_s.uf', $uf)
		->where('item_i_b_t_e_s.codigo', $codigo)
		->first();

		return $trib;
	}
}
