<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemPedido;
use App\Models\ItemPedidoDelivery;
use App\Models\TelaPedido;
use NFePHP\DA\NFe\Itens;

class GeraArquivoController extends Controller
{
	public function pedidos(Request $request){
		$this->verificaPastasCriadas();
		
		$itens = ItemPedido::
		join('pedidos', 'pedidos.id', '=', 'item_pedidos.pedido_id')
		->where('pedidos.imprimir', true)
		->where('item_pedidos.impresso', false)
		->get();

		$itensPrint = [];

		foreach($itens as $i){
			$i->produto;
			$tela = null;
			if($i->produto->tela_id != null){
				$tela = TelaPedido::find($i->produto->tela_id);
			}

			$nomeTela = $tela != null ? $tela->nome : 'Geral';

			$temp = [
				'tela' => $nomeTela,
				'value' => $i
			];

			array_push($itensPrint, $temp);

			$i->impresso = true;
			$i->save();

		}

		$telas = TelaPedido::all();
		$tempCria = null;

		$rand = rand(10000000, 99999999);

		$tempCria = $this->agrupaPedidosCriaArquivo($itensPrint, 'Geral');

		// return response()->json($itensPrint, 401);

		if(is_array($tempCria) && sizeof($tempCria) > 0){

			$itensVerifica = $this->verificaMaisDeUmPedido($tempCria);
			if(!$itensVerifica){
				$pathLogo = '';
				$cupom = new Itens($tempCria, $pathLogo);

				$pdf = $cupom->render();

				file_put_contents(public_path('impressao/Geral/pedido_'.$rand.'.pdf'), $pdf);
			}else{
				$pathLogo = '';

				foreach($tempCria as $tp){

					$cupom = new Itens([$tp], $pathLogo);

					$pdf = $cupom->render();

					file_put_contents(public_path('impressao/Geral/pedido_'.$rand.'.pdf'), $pdf);
				}
			}
		}
		foreach($telas as $t){

			$tempCria = $this->agrupaPedidosCriaArquivo($itensPrint, $t->nome);
			if(is_array($tempCria) && sizeof($tempCria) > 0){
				$itensVerifica = $this->verificaMaisDeUmPedido($tempCria);
				
				if(!$itensVerifica){

					$pathLogo = '';
					$cupom = new Itens($tempCria, $pathLogo);

					$pdf = $cupom->render();

					file_put_contents(public_path('impressao/'.$t->nome.'/pedido_'.$rand.'.pdf'), $pdf);
				}else{

					$pathLogo = '';

					foreach($tempCria as $tp){

						$cupom = new Itens([$tp], $pathLogo);

						$pdf = $cupom->render();

						file_put_contents(public_path('impressao/Geral/pedido_'.$rand.'.pdf'), $pdf);
					}
				}
			}
		}

		return response()->json($itensPrint, 200);

	}

	public function pedidosDelivery(Request $request){
		$this->verificaPastasCriadas();
		$itens = ItemPedidoDelivery::
		where('impresso', false)
		->get();

		$itensPrint = [];

		foreach($itens as $i){
			$i->produto;
			$tela = null;
			if($i->produto->tela_id != null){
				$tela = TelaPedido::find($i->produto->produto->tela_id);
			}

			$nomeTela = $tela != null ? $tela->nome : 'Geral';

			if($i->pedido->estado == 'ap'){
				$temp = [
					'tela' => $nomeTela,
					'value' => $i
				];
				array_push($itensPrint, $temp);
			}
		}

		$telas = TelaPedido::all();
		$tempCria = null;
		$rand = rand(10000000, 99999999);

		$tempCria = $this->agrupaPedidosCriaArquivo($itensPrint, 'Geral');
		if(is_array($tempCria) && sizeof($tempCria) > 0){
			$itensVerifica = $this->verificaMaisDeUmPedido($tempCria);

			if(!$itensVerifica){
				$pathLogo = '';
				$cupom = new Itens($tempCria, $pathLogo);

				$pdf = $cupom->render();

				file_put_contents(public_path('impressao/Geral/delivery_'.$rand.'.pdf'), $pdf);
			}else{
				$pathLogo = '';

				foreach($tempCria as $tp){
					$cupom = new Itens([$tp], $pathLogo);

					$pdf = $cupom->render();

					file_put_contents(public_path('impressao/Geral/delivery_'.$rand.'.pdf'), $pdf);
				}
			}
		}

		foreach($telas as $t){
			$tempCria = $this->agrupaPedidosCriaArquivo($itensPrint, $t->nome);
			if(is_array($tempCria) && sizeof($tempCria) > 0){

				$itensVerifica = $this->verificaMaisDeUmPedido($tempCria);
				
				if(!$itensVerifica){
					$pathLogo = '';
					$cupom = new Itens($tempCria, $pathLogo);

					$pdf = $cupom->render();

					file_put_contents(public_path('impressao/'.$t->nome.'/delivery_'.$rand.'.pdf'), $pdf);
				}else{
					$pathLogo = '';

					foreach($tempCria as $tp){

						$cupom = new Itens([$tp], $pathLogo);

						$pdf = $cupom->render();

						file_put_contents(public_path('impressao/Geral/delivery_'.$rand.'.pdf'), $pdf);
					}
				}
			}
		}

		return response()->json($itens, 200);

	}

	private function agrupaPedidosCriaArquivo($array, $tela){
		$tempArr = [];
		foreach($array as $a){
			if($tela == $a['tela']){
				array_push($tempArr, $a['value']);
				$p = $a['value'];
				$p->impresso = true;
				if(getenv("STATUS_IMPRIMIR_ITEM") == 1)
					$p->status = true;
				$p->save();
			}
		}
		return $tempArr;
	}

	private function verificaPastasCriadas(){
		$telas = TelaPedido::all();
		if(!is_dir(public_path('impressao/Geral'))){
			mkdir(public_path('impressao/Geral'), 0777, true);
		}
		foreach($telas as $t){
			if(!is_dir(public_path('impressao/'.$t->nome))){
				mkdir(public_path('impressao/'.$t->nome), 0777, true);
			}
		}
	}

	private function verificaMaisDeUmPedido($itens){
		$isVerifica = false;
		$temp = [];
		$idInit = $itens[0]->pedido_id;
		foreach($itens as $i){
			if($idInit != $i->pedido_id) $isVerifica = true;
		}

		return $isVerifica;
	}
}

