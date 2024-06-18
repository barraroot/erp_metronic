<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaAdicional;

class CategoriaAdicionalController extends Controller
{
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}
			return $next($request);
		});
	}

	public function index(){
		$categorias = CategoriaAdicional::all();

		return view('categoriaAdicional/list')
		->with('categorias', $categorias)
		->with('title', 'Categorias de Adicional');
	}

	public function new(){
		return view('categoriaAdicional/register')
		->with('title', 'Cadastrar Categoria para Adicional');
	}

	public function edit($id){

		$resp = CategoriaAdicional::find($id);  

		return view('categoriaAdicional/register')
		->with('categoria', $resp)
		->with('title', 'Editar Categoria de Adicional');

	}

	public function save(Request $request){

		$this->_validate($request);

		try{
			$request->merge(['adicional' => $request->adicional ? true : false]);
			$res = CategoriaAdicional::create($request->all());
			session()->flash('mensagem_sucesso', 'Categoria adicionada!!');

		}catch(\Exception $e){
			session()->flash('mensagem_erro', 'Erro: ' . $e->getMessage());

		}

		return redirect('/categoriasAdicional');
	}

	public function update(Request $request){


		$this->_validate($request, false);

		$resp = CategoriaAdicional::find($request->id);

		$resp->nome = $request->input('nome');
		$resp->limite_escolha = $request->input('limite_escolha');
		$resp->adicional = $request->adicional ? true : false;

		$result = $resp->save();
		if($result){
			session()->flash('mensagem_sucesso', 'Categoria editada com sucesso!');
		}else{
			session()->flash('mensagem_erro', 'Erro ao editar categoria!');
		}
		return redirect('/categoriasAdicional'); 
	}

	private function _validate(Request $request, $fileExist = true){
		$rules = [
			'nome' => 'required|max:30',
			'limite_escolha' => 'required',

		];

		$messages = [
			'nome.required' => 'O campo nome é obrigatório.',
			'nome.max' => '50 caracteres maximos permitidos.',
			'limite_escolha.required' => 'O campo limite é obrigatório.'
			
		];
		$this->validate($request, $rules, $messages);
	}

	public function delete($id){
		try{
			CategoriaAdicional::find($id)->delete(); 
			session()->flash('mensagem_sucesso', 'Categoria removida com sucesso!');
		}catch(\Exception $e){
			session()->flash('mensagem_erro', 'Erro ao remove: ' . $e->getMessage());
		}
		return redirect('/categoriasAdicional'); 
	}
}
