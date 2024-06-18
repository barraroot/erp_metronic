<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\ProdutoDelivery;
use App\Models\ItemPedido;
use App\Models\ItemPizzaPedidoLocal;
use App\Models\ItemPedidoComplementoLocal;
use App\Models\ComplementoDelivery;
use App\Models\Mesa;
use App\Models\Usuario;
use App\Models\ConfigNota;
use App\Models\VendaCaixa;
use App\Helpers\StockMove;
use App\Models\ItemVendaCaixa;
use App\Models\ProdutoPizza;

class PedidoRestController extends Controller
{
    // APP

	private function duplicidadeComanda($comanda){
		$c = Pedido::
		where('comanda', $comanda)
		->where('desativado', false)
		->where('status', false)
		->first();
		return $c;
	}

	public function emAberto(){
		$pedidos = ItemPedido::where('status', false)
		->get();

        // echo json_encode(count($pedidos));
		return response()->json(count($pedidos), 200);
	}

	public function comandasAberta(){
		$pedidos = Pedido::
		where('status', false)
		->where('desativado', false)
		->get();

		return response()->json($this->somaTotal($pedidos), 200);
		// echo json_encode($this->somaTotal($pedidos));
	}

	private function somaTotal($pedidos){
		foreach($pedidos as $p){
			$p->mesa;
			$p['soma'] = $p->somaItems();
		}
		return $pedidos;
	}

	public function abrirComanda(Request $request){
		$duplcidade = $this->duplicidadeComanda($request->cod);
		if($duplcidade == null){
			$result = Pedido::create([
				'comanda' => $request->cod,
				'mesa_id' => $request->mesa > 0 ? $request->mesa : NULL,
				'status' => false,
				'observacao' => '',
				'desativado' => false,
				'rua' => '',
				'numero' => '',
				'bairro_id' => null,
				'referencia' => '',
				'telefone' => '', 
				'nome' => ''

			]);
			// echo json_encode($result);
			return response()->json($result, 200);

		}else{
			// echo json_encode(false);
			return response()->json(false, 200);

		}
	}

	public function senhaParaAcesso(){
		return response()->json(getenv("KEY_APP_GARCOM"), 200);
	}

	public function deleteItem(Request $request){
		$item = ItemPedido
		::where('id', $request->id)
		->first();
		if($item->status == false){
			$result = $item->delete();
			return response()->json($item, 200);
		}else{
			return response()->json(false, 404);
		}
		
		// echo json_encode($item);
	}

	public function addProduto(Request $request){
		$saboresExtras = json_decode($request->saboresExtras);
		$adicionais = json_decode($request->adicionais);
		
		$result;
		$duplcidade = null;
		if($request->nova_comanda > 0){
			$duplcidade = $this->duplicidadeComanda($request->nova_comanda);
		}
		if($duplcidade == null){
			if($request->nova_comanda > 0){
				$result = Pedido::create([
					'comanda' => $request->nova_comanda,
					'status' => false,
					'observacao' => '',
					'desativado' => false,
					'rua' => '',
					'numero' => '',
					'bairro_id' => null,
					'mesa_id' => $request->novaMesa > 0 ? $request->novaMesa : NULL,
					'referencia' => '',
					'telefone' => '', 
					'nome' => ''
				]);
			}else{
				$result = Pedido::where('comanda', $request->comanda)
				->where('status', false)
				->where('desativado', false)
				->first();
			}

			$res = ItemPedido::create([
				'pedido_id' => $result->id,
				'produto_id' => $request->produto,
				'quantidade' => str_replace(",", ".", $request->quantidade),
				'status' => false,
				'observacao' => $request->obs ?? '',
				'tamanho_pizza_id' => $request->tamanho == 'null' ? NULL : $request->tamanho,
				'valor' => str_replace(",", ".", $request->valorFlex),
				'impresso' => false,
				'usuario_id' => $request->usuario_id
			]);

			if($request->tamanho != 'null'){
				$produto = Produto::
				where('id', $request->produto)
				->first();
				if(count($saboresExtras) > 0){

					foreach($saboresExtras as $sab){
						$prod = ProdutoDelivery
						::where('id', $sab->produto_id)
						->first();

						$item = ItemPizzaPedidoLocal::create([
							'item_pedido' => $res->id,
							'sabor_id' => $prod->id,
						]);

					}

				}

				$item = ItemPizzaPedidoLocal::create([
					'item_pedido' => $res->id,
					'sabor_id' => $produto->delivery->id,
				]);
				
			}

			if(count($adicionais) > 0){
				foreach($adicionais as $ad){

					$adicional = ComplementoDelivery
					::where('id', $ad->id)
					->first();


					$item = ItemPedidoComplementoLocal::create([
						'item_pedido' => $res->id,
						'complemento_id' => $adicional->id,
						'quantidade' => str_replace(",", ".", $request->quantidade),
					]);
				}
			}

			// echo json_encode($res);
			return response()->json($res, 200);
		}else{
			// echo json_encode(false);
			return response()->json(false, 200);
		}
	}

	public function apk(){
		return response()->download("app.apk");
	}

	public function mesas(){
		$pedidos = Pedido::
		where('desativado', false)
		->where('mesa_id', '!=', NULL)
		// ->groupBy('mesa_id')
		->get();

		$mesas = [];

		foreach($pedidos as $p){
			// $p->mesa->pedidos;
			$this->somaTotal($p->mesa->pedidos);
			$p->mesa->soma = $p->mesa->somaItens();
			array_push($mesas, $p->mesa);
			
		}

		foreach($mesas as $m){
			$temp = [];
			foreach($m->pedidos as $t){
				if($t->desativado == 0){
					array_push($temp, $t);
				}
			}

			$m->pedidosTemp = $temp;
		}


		return response()->json($mesas, 200);
	}

	public function mesasTodas(){
		$mesas = Mesa::all();
		return response()->json($mesas, 200);
	}

	public function autenticaUsuario(Request $request){
		$json = $request->json;
		$arr = json_decode($json);
		$usuario = $arr->usuario;
		$senha = $arr->senha;

		$usuario = Usuario::
		where('login', $usuario)
		->where('senha', md5($senha))
		->first();

		if($usuario != null){
			return response()->json($usuario, 200);
		}else{
			return response()->json(null, 401);
		}

	}

	public function addItens(Request $request){
		$pedido_id = $request->pedido_id;
		$itens = json_decode($request->itens);
		$usuario_id = $request->usuario_id;
		$pedido = Pedido::find($pedido_id);

		foreach($itens as $i){
			$item = ItemPedido::create([
				'pedido_id' => $pedido->id,
				'produto_id' => $i->produto_id,
				'quantidade' => str_replace(",", ".", $i->quantidade),
				'status' => false,
				'observacao' => $i->obs ?? '',
				'tamanho_pizza_id' => $i->tamanho == 'null' ? NULL : $request->tamanho,
				'valor' => str_replace(",", ".", $i->valorFlex),
				'impresso' => false,
				'usuario_id' => $usuario_id
			]);

			$adicionais = $i->adicionaisSelecionados;
			if(count($adicionais) > 0){
				foreach($adicionais as $ad){

					$adicional = ComplementoDelivery
					::where('id', $ad->id)
					->first();

					$item = ItemPedidoComplementoLocal::create([
						'item_pedido' => $item->id,
						'complemento_id' => $adicional->id,
						'quantidade' => str_replace(",", ".", $i->quantidade),
					]);
				}
			}

			if($i->tamanho != null){
				$produto = Produto::
				where('id', $i->produto_id)
				->first();

				if(count($i->saboresExtrasPizza) > 0){

					foreach($i->saboresExtrasPizza as $sab){
						$prod = ProdutoDelivery
						::where('id', $sab->produto_id)
						->first();

						ItemPizzaPedidoLocal::create([
							'item_pedido' => $item->id,
							'sabor_id' => $prod->id,
						]);

					}

				}

				$item = ItemPizzaPedidoLocal::create([
					'item_pedido' => $item->id,
					'sabor_id' => $produto->delivery->id,
				]);
				
			}
		}
		$pedido->imprimir = true;
		$pedido->save();
		return response()->json($itens, 200);

	}

	public function fecharComanda(Request $request){
		$request = json_decode($request->js);

		$pedido_id = $request->pedido_id;
		$pedido = Pedido::find($pedido_id);

		$config = ConfigNota::first();

		$result = VendaCaixa::create([
			'cliente_id' => null,
			'usuario_id' => $request->usuario_id,
			'natureza_id' => $config->nat_op_padrao,
			'valor_total' => $pedido->somaItems(),
			'acrescimo' => 0,
			'troco' => $request->tipo_pagamento == '01' ? $request->dinheiro_recebido - $pedido->somaItems() : 0,
			'dinheiro_recebido' => $request->dinheiro_recebido,
			'forma_pagamento' => " ",
			'tipo_pagamento' => $request->tipo_pagamento,
			'estado' => 'DISPONIVEL',
			'NFcNumero' => 0,
			'chave' => '',
			'path_xml' => '',
			'nome' => '',
			'cpf' => '',
			'observacao' => $request->observacao,
			'desconto' => 0,
			'pedido_delivery_id' => 0,
			'tipo_pagamento_1' => '', 
			'valor_pagamento_1' => 0,
			'tipo_pagamento_2' => '',
			'valor_pagamento_2' => 0,
			'tipo_pagamento_3' => '',
			'valor_pagamento_3' => 0
		]);

		$pedido->status = 1;
		$pedido->desativado = 1;
		$pedido->save();

		$stockMove = new StockMove();

		foreach ($pedido->itens as $i) {

			ItemVendaCaixa::create([
				'venda_caixa_id' => $result->id,
				'produto_id' => $i->produto_id,
				'quantidade' => $i->quantidade,
				'valor' => $i->valor,
				'item_pedido_id' => $i->id,
				'observacao' => $i->observacao
			]);

			$prod = Produto
			::where('id', $i->produto_id)
			->first();

			if(sizeof($i->sabores) > 0){
				$totalSabores = sizeof($i->sabores);

				foreach($i->sabores as $sb){
					$produto = $sb->produto->produto;

					if(!empty($produto->receita)){
						$receita = $produto->receita;
						foreach($receita->itens as $rec){

							$stockMove->downStock(
								$rec->produto_id, 
								$i->quantidade * 
								((($rec->quantidade/$totalSabores)/$receita->pedacos)*$i->tamanho->pedacos)/$receita->rendimento
							);
						}
					}
				}

			}else if(!empty($prod->receita)){


				$receita = $prod->receita; 

				foreach($receita->itens as $rec){


					if(!empty($rec->produto->receita)){ 


						$receita2 = $rec->produto->receita; 

						foreach($receita2->itens as $rec2){
							$stockMove->downStock(
								$rec2->produto_id, 
								$i->quantidade * 
								($rec2->quantidade/$receita2->rendimento)
							);
						}
					}else{


						$stockMove->downStock(
							$rec->produto_id, 
							$i->quantidade * 
							($rec->quantidade/$receita->rendimento)
						);
					}
				}

			}else{
				$stockMove->downStock(
					(int) $i->produto_id, 
					$i->quantiade
				);
			}

		}


		return response()->json($pedido, 200);

	}
}
