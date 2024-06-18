<?php

namespace App\Http\Middleware;

use Closure;
use Response;

class AutoAtendimentoAtivo
{

	public function handle($request, Closure $next){

		$modulo = getenv('AUTOATENDIMENTO');
		if($modulo == 1){
			return $next($request);
		} else {
			return redirect('http://google.com');
		}
		
	}

}