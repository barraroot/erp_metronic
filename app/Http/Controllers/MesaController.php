<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Pedido;
use LaravelQRCode\Facades\QRCode;
use Dompdf\Dompdf;

class MesaController extends Controller
{
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}else{
				if($value['acesso_produto'] == 0){
					return redirect("/sempermissao");
				}
			}
			return $next($request);
		});
	}

	public function index(){
		$mesas = Mesa::all();
		return view('mesas/list')
		->with('mesas', $mesas)
		->with('title', 'Mesas');
	}

	public function emAberto(){
		try{
			$pedidos = Pedido::
			where('desativado', false)
			->where('mesa_id', '!=', NULL)
			->groupBy('mesa_id')
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

		}catch(\Exception $e){
			return response()->json($e->getMessage(), 401);
		}
	}

	private function somaTotal($pedidos){
		foreach($pedidos as $p){
			$p->mesa;
			$p['soma'] = $p->somaItems();
		}
		return $pedidos;
	}

	public function new(){
		return view('mesas/register')
		->with('title', 'Cadastrar Mesa');
	}

	public function save(Request $request){
		$mesa = new Mesa();
		$this->_validate($request);

		$result = $mesa->create($request->all());

		if($result){
			session()->flash("mensagem_sucesso", "Mesa cadastrada com sucesso.");
		}else{
			session()->flash('mensagem_erro', 'Erro ao cadastrar mesa.');
		}

		return redirect('/mesas');
	}

	public function edit($id){
		$mesa = new Mesa(); 

		$resp = $mesa
		->where('id', $id)->first();  

		return view('mesas/register')
		->with('mesa', $resp)
		->with('title', 'Editar Mesa');

	}

	public function update(Request $request){
		$mesa = new Mesa();
		
		$id = $request->input('id');
		$resp = $mesa
		->where('id', $id)->first(); 

		$this->_validate($request);

		$resp->nome = $request->input('nome');

		$result = $resp->save();
		if($result){
			session()->flash('mensagem_sucesso', 'Mesa editada com sucesso!');
		}else{
			session()->flash('mensagem_erro', 'Erro ao editar mesa!');
		}

		return redirect('/mesas'); 
	}

	public function delete($id){

		$delete = Mesa
		::where('id', $id)
		->delete();
		if($delete){
			session()->flash('mensagem_sucesso', 'Registro removido!');
		}else{
			session()->flash('mensagem_erro', 'Erro!');
		}
		return redirect('/mesas');

	}


	private function _validate(Request $request){
		$rules = [
			'nome' => 'required|max:50',
		];

		$messages = [
			'nome.required' => 'O campo nome é obrigatório.',
			'nome.max' => '50 caracteres maximos permitidos.',

		];
		$this->validate($request, $rules, $messages);
	}

	public function gerarQrCode(){
		$mesas = Mesa::all();

		return view('mesas/qrCode')
		->with('mesas', $mesas)
		->with('title', 'Mesas QrCode');
	}

	public function issue($id){
		$path = getenv('PATH_URL');
		return QRCode::url($path . '/pedido/open/'.$id)->png();  
	}

	public function issue2($id){
		$path = getenv('PATH_URL');
		$src = QRCode::url($path . '/pedido/open/'.$id)
		->setSize(getenv("TAMANHO_QRCODE"))
		->setMargin(2)
		->png();  

		return $src;
	}

	public function imprimirQrCode($id){
		return view('mesas/verQrCode')
		->with('id', $id)
		->with('title', 'QrCode');
	}
	
}
