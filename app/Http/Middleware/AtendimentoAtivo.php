<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Models\Pedido;

class AtendimentoAtivo
{
	public function handle($request, Closure $next){
		$comanda = session('comanda');
		if(!isset($comanda['comanda'])){
			return response()->json('Atendimento não iniciado!!', 404);
		}else{
			$pedido = Pedido::where('comanda', $comanda['comanda'])->first();
			if($pedido != null){

				return $next($request);
				
			}else{
				session()->forget('comanda');
				return response()->json('Por favor inicie novamente o autoatendimento!!', 404);
			}
		}
		
	}

}