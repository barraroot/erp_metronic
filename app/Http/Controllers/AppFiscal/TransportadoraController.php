<?php

namespace App\Http\Controllers\AppFiscal;

use Illuminate\Http\Request;
use App\Models\Transportadora;
use App\Models\Cidade;

class TransportadoraController extends Controller
{
	public function index(){
		$transportadoras = Transportadora::all();
		foreach($transportadoras as $c){
			$c->cidade;
		}
		return response()->json($transportadoras, 200);
	}
}