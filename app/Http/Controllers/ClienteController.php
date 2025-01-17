<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cidade;
use App\Models\ConfigNota;
use App\Models\CreditoVenda;
use Dompdf\Dompdf;

class ClienteController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $value = session('user_logged');
            if(!$value){
                return redirect("/login");
            }else{
                if($value['acesso_cliente'] == 0){
                    return redirect("/sempermissao");
                }
            }
            return $next($request);
        });
    }

    public function pesquisa(Request $request){
        $pesquisa = $request->input('pesquisa');
        $clientes = Cliente::where('razao_social', 'LIKE', "%$pesquisa%")->get();
        return view('clientes/list')
        ->with('clientes', $clientes)
        ->with('title', 'Filtro Clientes');
    }

    public function index(){
        $clientes = Cliente::paginate(20);

        return view('clientes/list')
        ->with('clientes', $clientes)
        ->with('links', true)
        ->with('title', 'Clientes');
    }

    public function new(){
        $estados = Cliente::estados();
        $cidades = Cidade::all();

        return view('clientes/register')
        ->with('cidadeJs', true)
        ->with('pessoaFisicaOuJuridica', true)
        ->with('estados', $estados)
        ->with('cidades', $cidades)
        ->with('title', 'Cadastrar Cliente');
    }

    public function save(Request $request){

        $cidade = $request->input('cidade');
        $cidade = explode("-", $cidade);
        $cidade = $cidade[0];   

        $cidadeTemp = Cidade::find($cidade);
        if($cidadeTemp == null){
            $request->merge([ 'cidade' => 'a']);
        }

        $cliente = new Cliente();
        $this->_validate($request);

        $limite = $request->limite_venda ? $request->limite_venda : 0;

        $request->merge([ 'limite_venda' => $limite]);
        $request->merge([ 'celular' => $request->celular ?? '']);
        $request->merge([ 'telefone' => $request->telefone ?? '']);
        $request->merge([ 'ie_rg' => $request->ie_rg ? strtoupper($request->ie_rg) :
            'ISENTO']);
        $request->merge([ 'razao_social' => strtoupper($request->razao_social)]);
        $request->merge([ 'nome_fantasia' => strtoupper($request->nome_fantasia)]);
        $request->merge([ 'rua' => strtoupper($request->rua)]);
        $request->merge([ 'numero' => strtoupper($request->numero)]);
        $request->merge([ 'bairro' => strtoupper($request->bairro)]);
        $request->merge([ 'email' => $request->email ?? '']);

        $request->merge([ 'rua_cobranca' => strtoupper($request->rua_cobranca ?? '')]);
        $request->merge([ 'numero_cobranca' => strtoupper($request->numero_cobranca ?? '')]);
        $request->merge([ 'bairro_cobranca' => strtoupper($request->bairro_cobranca ?? '')]);
        $request->merge([ 'cep_cobranca' => strtoupper($request->cep_cobranca ?? '')]);
        $request->merge([ 'cidade_cobranca_id' => NULL]); // inicia NULL

        $cidade = $request->input('cidade');
        $cidade = explode("-", $cidade);
        $cidade = $cidade[0];

        $request->merge([ 'cidade_id' => $cidade]);

        if($request->input('cidade_cobranca')){
            $cidade = $request->input('cidade_cobranca');
            $cidade = explode("-", $cidade);
            $cidade = $cidade[0];
            $request->merge([ 'cidade_cobranca_id' => $cidade]);
        }

        $result = $cliente->create($request->all());

        if($result){
            session()->flash("mensagem_sucesso", "Cliente cadastrado com sucesso!");
        }else{

            session()->flash('mensagem_erro', 'Erro ao cadastrar cliente!');
        }
        
        return redirect('/clientes');
    }

    public function edit($id){
        $cliente = new Cliente(); //Model
        $estados = Cliente::estados();
        $resp = $cliente
        ->where('id', $id)->first();  

        $cidades = Cidade::all();

        return view('clientes/register')
        ->with('pessoaFisicaOuJuridica', true)
        ->with('cidadeJs', true)
        ->with('cliente', $resp)
        ->with('estados', $estados)
        ->with('cidades', $cidades)
        ->with('title', 'Editar Cliente');

    }

    public function update(Request $request){
        $cliente = new Cliente();

        $id = $request->input('id');
        $resp = $cliente
        ->where('id', $id)->first(); 

        $request->merge([ 'ie_rg' => $request->ie_rg ? strtoupper($request->ie_rg) :
            'ISENTO']);
        $request->merge([ 'celular' => $request->celular ?? '']);

        $this->_validate($request);
        $limite = $request->limite_venda;
        // $limite = str_replace(".", "", $limite);
        // $limite = str_replace(",", ".", $limite);

        $cidade = $request->input('cidade');
        $cidade = explode("-", $cidade);
        $cidade = $cidade[0];
        
        $resp->razao_social = strtoupper($request->input('razao_social'));
        $resp->nome_fantasia = strtoupper($request->input('nome_fantasia'));
        $resp->cpf_cnpj = $request->input('cpf_cnpj');
        $resp->ie_rg = $request->input('ie_rg');
        $resp->limite_venda = $limite;
        $resp->cidade_id = $cidade;

        $resp->rua = strtoupper($request->input('rua'));
        $resp->numero = strtoupper($request->input('numero'));
        $resp->bairro = strtoupper($request->input('bairro'));

        $resp->telefone = $request->input('telefone') ?? '';
        $resp->celular = $request->input('celular') ?? '';
        $resp->email = $request->input('email') ?? '';
        $resp->cep = $request->input('cep');
        $resp->consumidor_final = $request->input('consumidor_final');
        $resp->contribuinte = $request->input('contribuinte');


        $resp->rua_cobranca = $request->input('rua_cobranca') ?? '';
        $resp->bairro_cobranca = $request->input('bairro_cobranca') ?? '';
        $resp->numero_cobranca = $request->input('numero_cobranca') ?? '';
        $resp->cep_cobranca = $request->input('cep_cobranca') ?? '';

        if($request->input('cidade_cobranca')){
            $cidade = $request->input('cidade_cobranca');
            $cidade = explode("-", $cidade);
            $cidade = $cidade[0];
            $resp->cidade_cobranca_id = $cidade;
        }


        $result = $resp->save();
        if($result){

            session()->flash('mensagem_sucesso', 'Cliente editado com sucesso!');
        }else{

            session()->flash('mensagem_erro', 'Erro ao editar cliente!');
        }
        
        return redirect('/clientes'); 
    }

    public function delete($id){
        try{
            $delete = Cliente
            ::where('id', $id)
            ->delete();
            if($delete){

                session()->flash('mensagem_sucesso', 'Registro removido!');
            }else{

                session()->flash('mensagem_erro', 'Erro!');
            }
            return redirect('/clientes');
        }catch(\Exception $e){
            return view('errors.sql')
            ->with('title', 'Erro ao deletar cliente')
            ->with('motivo', 'Não é possivel remover clientes, presentes vendas ou pedidos!');
        }
    }

    private function _validate(Request $request){
        $doc = $request->cpf_cnpj;

        $rules = [
            'razao_social' => 'required|max:50',
            'nome_fantasia' => strlen($doc) > 14 ? 'required|max:80' : 'max:80',
            'cpf_cnpj' => strlen($doc) > 14 ? 'required|min:18' : 'required|min:14',
            'rua' => 'required|max:80',
            'numero' => 'required|max:10',
            'bairro' => 'required|max:50',
            'telefone' => 'max:20',
            'celular' => 'max:20',
            'email' => $request->email != "" ? 'email|max:40' : 'max:40',
            'cep' => 'required|min:9',
            'cidade' => 'required',
            'consumidor_final' => 'required',
            'contribuinte' => 'required',
            'rua_cobranca' => 'max:80',
            'numero_cobranca' => 'max:10',
            'bairro_cobranca' => 'max:50',
            'cep_cobranca' => 'max:9'
        ];

        $messages = [
            'razao_social.required' => 'O Razão social/Nome é obrigatório.',
            'razao_social.max' => '50 caracteres maximos permitidos.',
            'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório.',
            'nome_fantasia.max' => '80 caracteres maximos permitidos.',
            'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
            'cpf_cnpj.min' => strlen($doc) > 14 ? 'Informe 14 números para CNPJ.' : 'Informe 14 números para CPF.',
            'rua.required' => 'O campo Rua é obrigatório.',
            'rua.max' => '80 caracteres maximos permitidos.',
            'numero.required' => 'O campo Numero é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.min' => 'CEP inválido.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'numero.max' => '10 caracteres maximos permitidos.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'bairro.max' => '50 caracteres maximos permitidos.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
            'telefone.max' => '20 caracteres maximos permitidos.',
            'consumidor_final.required' => 'O campo Consumidor final é obrigatório.',
            'contribuinte.required' => 'O campo Contribuinte é obrigatório.',
            'celular.max' => '20 caracteres maximos permitidos.',

            'email.required' => 'O campo Email é obrigatório.',
            'email.max' => '40 caracteres maximos permitidos.',
            'email.email' => 'Email inválido.',

            'rua_cobranca.max' => '80 caracteres maximos permitidos.',
            'numero_cobranca.max' => '10 caracteres maximos permitidos.',
            'bairro_cobranca.max' => '30 caracteres maximos permitidos.',
            'cep_cobranca.max' => '9 caracteres maximos permitidos.',

        ];
        $this->validate($request, $rules, $messages);
    }

    public function all(){
        $clientes = Cliente::all();
        $arr = array();
        foreach($clientes as $c){
            $arr[$c->id. ' - ' .$c->razao_social] = null;
                //array_push($arr, $temp);
        }
        echo json_encode($arr);
    }

    public function find($id){
        $cliente = Cliente::
        where('id', $id)
        ->first();
        
        echo json_encode($this->getCidade($cliente));
    }

    public function verificaLimite(Request $request){
        $cliente = Cliente::
        where('id', $request->id)
        ->first();

        $somaVendas = $this->somaVendasCredito($cliente);
        if($somaVendas != null){
            $cliente->soma = $somaVendas->total;
        }else{
            $cliente->soma = 0;
        }
        echo json_encode($cliente);
    }

    private function somaVendasCredito($cliente){
        return CreditoVenda::
        selectRaw('sum(vendas.valor_total) as total')
        ->join('vendas', 'vendas.id', '=', 'credito_vendas.venda_id')
        ->where('credito_vendas.cliente_id', $cliente->id)
        ->where('status', 0)
        ->first();
    }

    private function getCidade($transp){
        $temp = $transp;
        $transp['cidade'] = $transp->cidade;
        return $temp;
    }

    public function cpfCnpjDuplicado(Request $request){
        $cliente = Cliente::
        where('cpf_cnpj', $request->cpf_cnpj)
        ->first();

        echo json_encode($cliente);
    }

    public function imprimir(){
        $emitente = ConfigNota::first();
        $clientes = Cliente::all();
        $v = view('relatorios_tabela/clientes')
        ->with('emitente', $emitente)
        ->with('clientes', $clientes);
        return $v;
        $domPdf = new Dompdf(["enable_remote" => true]);
        $domPdf->loadHtml($v);

        $pdf = ob_get_clean();

        $domPdf->setPaper("A4");
        $domPdf->render();
        $domPdf->stream("tst.pdf");
    }

    public function quickSave(Request $request){
        try{
            $data = $request->data;

            $cli = [
                'razao_social' => $data['razao_social'],
                'nome_fantasia' => $data['razao_social'],
                'bairro' => $data['bairro'] ?? '',
                'numero' => $data['numero'] ?? '',
                'rua' => $data['rua'] ?? '',
                'cpf_cnpj' => $data['cpf_cnpj'] ?? '',
                'telefone' => $data['telefone'] ?? '',
                'celular' => $data['celular'] ?? '',
                'email' => $data['email'] ?? '',
                'cep' => $data['cep'] ?? '',
                'ie_rg' => $data['ie_rg'] ?? '',
                'consumidor_final' => $data['consumidor_final'] ?? 1,
                'limite_venda' => 0,
                'cidade_id' => $data['cidade_id'] ?? 1, 
                'contribuinte' => $data['contribuinte'] ?? 1,
                'rua_cobranca' => '',
                'numero_cobranca' => '',
                'bairro_cobranca' => '',
                'cep_cobranca' => '', 
                'cidade_cobranca_id' => NULL
            ];

            $res = Cliente::create($cli);
            return response()->json($res, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 401);
        }
    }


}
