<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Mesa;
use App\Models\CategoriaProdutoDelivery;
use App\Models\ProdutoDelivery;
use App\Models\ItemPedidoDelivery;
use App\Models\DeliveryConfig;
use App\Models\TamanhoPizza;
use App\Models\ItemPedido;
use App\Models\ComplementoDelivery;
use App\Models\ItemPedidoComplementoLocal;
use App\Models\CategoriaAdicional;

class AutoatendimentoController extends Controller
{
	protected $config = null;

	public function __construct(){
		
		$this->config = DeliveryConfig::first();
		if($this->config == null){
			echo "Configure o formulário de delivery/config";
			die();
		}
		$delivery = getenv("DELIVERY");

	}

	public function iniciar(Request $request){

		$nome = $request->nome;
		$comanda = $request->comanda;

		if(!$comanda){
			$comanda = rand(1000000, 9999999);
		}

		$result = Pedido::create([
			'comanda' => $comanda,
			'mesa_id' => NULL,
			'status' => false,
			'observacao' => '',
			'desativado' => false,
			'rua' => '',
			'numero' => '',
			'bairro_id' => null,
			'referencia' => '',
			'telefone' => '', 
			'nome' => $nome,
			'fechar_mesa' => false,
			'referencia_cliete' => md5(date('d-m-Y H:i')),
			'mesa_ativa' => getenv("MESA_ATIVA_QRCODE"),
			'finalizado_atendimeto' => false
		]);

		$session = [
			'nome' => $nome,
			'comanda' => $comanda
		];
		session(['comanda' => $session]);
		session()->flash("message_sucesso", "Atendimneto iniciado com sucesso!!");
		session()->flash("message_sucesso_swal", "Atendimneto iniciado faça seu pedido :)");
		return redirect('/atendimento');

	}

	public function index(){
		session()->forget('tamanho_pizza');
		session()->forget('sabores');
		// session()->forget('comanda');

		$comanda = session('comanda');
		if(!$comanda){
			return view('auto_atendimento/abrir')
			->with('config', $this->config)
			->with('title', 'INICIAR COMANDA');
		}


		$categorias = CategoriaProdutoDelivery::all();
		$destaques = ProdutoDelivery::
		where('destaque', true)
		->where('status', true)
		->get();

		$dataHoje = date('Y-m-d');

		foreach($destaques as $d){

			$itens = ItemPedidoDelivery::
			selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as data, quantidade')
			->where('produto_id', $d->id)
			->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") = "' . $dataHoje . '"')
			->get();

			$soma = 0;
			foreach($itens as $i){

				$soma += 2;
			}

			if($d->limite_diario <= $soma){
				$d->block = true;
			}
		}

		return view('auto_atendimento/index')
		->with('categorias', $categorias)
		->with('destaques', $destaques)
		->with('config', $this->config)
		->with('tokenJs', true)
		->with('title', 'INICIO');
	}

	public function cardapio($id){
		$categoria = CategoriaProdutoDelivery::find($id);

		if(strpos(strtolower($categoria->nome), 'izza') !== false){

			$tamanhos = TamanhoPizza::all();
			return view('auto_atendimento/tipoPizza')
			->with('tamanhos', $tamanhos)
			->with('config', $this->config)
			->with('categoria', $categoria)
			->with('title', 'TIPO DA PIZZA'); 

		}else{
			return view('auto_atendimento/produtos')
			->with('produtos', $categoria->produtos)
			->with('categoria', $categoria)
			->with('config', $this->config)
			->with('title', 'PRODUTOS'); 
		}
	}

	public function adicionais($id){
		$produto = ProdutoDelivery::where('id', $id)
		->first();

		$categorias = $this->preparaCategorias($produto->adicionais);

		$adicionaisTemp = [];
		foreach($produto->adicionais as $p){
			array_push($adicionaisTemp, $p->complemento_id);
			$p->complemento->categoria;
		}

		return view('auto_atendimento/acompanhamentos')
		->with('produto', $produto)
		->with('categorias', $categorias)
		->with('adicionaisTemp', $adicionaisTemp)
		->with('acompanhamento', true)
		->with('historico', true)
		->with('adicionais', $produto->adicionais)
		->with('config', $this->config)
		->with('title', 'ACOMPANHAMENTO/ADICIONAIS');

	}


	private function preparaCategorias($adicionais){
		$categorias = [];
		$categoriasAdicional = CategoriaAdicional::all();
		
		foreach($adicionais as $a){
			foreach($categoriasAdicional as $c){

				if($a->complemento->categoria_id == $c->id){
					if(!in_array($c, $categorias))
						array_push($categorias, $c);
				}
			}
		}

		return $categorias;
	}

	public function encerrar(){
		$value = session('comanda');
		$comanda = $value['comanda'];

		$pedido = Pedido::where('comanda', $comanda)->first();
		if($pedido != null){
			$pedido->desativado = 1;
			$pedido->save();
		}
		session()->forget('comanda');
		session()->flash("message_sucesso_swal", "Atendimento encerrado!!");
		session()->flash("message_sucesso", "Atendimento encerrado!!");
		return redirect('atendimento');
	}

	public function addProd(Request $request){
		$adicionais = $request['adicionais'];
		$produto_id = $request['produto_id'];
		$quantidade = $request['quantidade'];
		$observacao = $request['observacao'];
		$valor = $request['valor'];
		$comanda = session('comanda');
		if(isset($comanda['comanda'])){

			$pedido = Pedido::where('comanda', $comanda['comanda'])->first();
			if($pedido != null){

				$produto = ProdutoDelivery::find($produto_id);
				$res = ItemPedido::create([
					'pedido_id' => $pedido->id,
					'produto_id' => $produto->produto->id,
					'quantidade' => $quantidade,
					'status' => false,
					'observacao' => $observacao ?? '',
					'tamanho_pizza_id' => NULL,
					'valor' => str_replace(",", ".", $valor),
					'impresso' => false
				]);

				if(is_array($adicionais) && sizeof($adicionais) > 0){
					foreach($adicionais as $ad){

						$adicional = ComplementoDelivery
						::where('id', $ad['id'])
						->first();


						$item = ItemPedidoComplementoLocal::create([
							'item_pedido' => $res->id,
							'complemento_id' => $adicional->id,
							'quantidade' => str_replace(",", ".", $quantidade),
						]);
					}
				}
				// session()->flash("message_sucesso_swal", "Item Adicionado :)");
				return response()->json($pedido, 200);

			}else{
				session()->forget('tamanho_pizza');
				session()->flash("message_erro", "Inicie novamente o atendimento!!");
				return response()->json('Inicie novamente o atendimento!!', 401);
			}
		}else{
			session()->forget('tamanho_pizza');
			session()->flash("message_erro", "Inicie novamente o atendimento!!");
			return response()->json('Inicie novamente o atendimento!!', 401);
		}
	}

	public function ver(){
		$comanda = session('comanda');
		if(isset($comanda['comanda'])){
			$pedido = Pedido::where('comanda', $comanda['comanda'])->first();

			return view('auto_atendimento/carrinho')
			->with('pedido', $pedido)
			->with('carrinho', true)
			->with('config', $this->config)
			->with('title', 'ITENS');
		}else{
			session()->forget('tamanho_pizza');
			session()->flash("message_erro", "Inicie o atendimento!!");
			return redirect('/atendimento');
		}
	}

	public function finalizar(){
		$comanda = session('comanda');
		if(isset($comanda['comanda'])){
			$pedido = Pedido::where('comanda', $comanda['comanda'])->first();
			// $pedido->fechar_mesa = true;
			$pedido->imprimir = true;
			if($pedido->comanda > 100000){
				// $pedido->comanda = '';
				$pedido->observacao = $comanda['nome'];
			}
			$pedido->finalizado_atendimeto = true;
			$pedido->save();
			session()->forget('comanda');

			return view('auto_atendimento/pedido_finalizado')
			->with('title', 'Pedido Finalizado')
			->with('config', $this->config)
			->with('finalizarJs', true)
			->with('pedido', $pedido);
			
		}else{
			session()->flash("message_erro", "Nenhum atendimento ativo!");
			return redirect('/atendimento');
		}
	}

}
