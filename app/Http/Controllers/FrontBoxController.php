<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendaCaixa;
use App\Helpers\StockMove;
use App\Models\ConfigNota;
use App\Models\NaturezaOperacao;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Tributacao;
use App\Models\Usuario;
use App\Models\Certificado;
use App\Models\ListaPreco;
use App\Models\AberturaCaixa;
use App\Models\ProdutoPizza;
use App\Models\Orcamento;
use App\Models\CreditoVenda;
use App\Models\ConfigCaixa;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\PedidoDelete;
use App\Models\ItemPedido;
use App\Models\ComplementoDelivery;
use App\Models\ItemPedidoComplementoLocal;

class FrontBoxController extends Controller
{
	public function __construct(){
        $this->middleware(function ($request, $next) {
            $value = session('user_logged');
            if(!$value){
                return redirect("/login");
            }else{
                if($value['acesso_caixa'] == 0){
                    return redirect("/sempermissao");
                }
            }
            return $next($request);
        });
    }

    public function index($pedidoId = 0){

        $config = ConfigNota::first();
        $naturezas = NaturezaOperacao::all();
        
        $categorias = Categoria::
        orderBy('nome', 'desc')
        ->get();

        $produtos = Produto::
        where('valor_venda', '>', 0)
        ->get();

        $tributacao = Tributacao::first();
        $tiposPagamento = VendaCaixa::tiposPagamento();
        $config = ConfigNota::first();
        $certificado = Certificado::first();
        $usuario = Usuario::find(get_id_user());

        if(count($naturezas) == 0 || count($produtos) == 0 || $config == null || count($categorias) == 0 || $tributacao == null){

            return view("frontBox/alerta")
            ->with('produtos', count($produtos))
            ->with('categorias', count($categorias))
            ->with('naturezas', $naturezas)
            ->with('config', $config)
            ->with('tributacao', $tributacao)
            ->with('title', "Validação para Emitir");
        }else{
            if($config->nat_op_padrao == 0){
                session()->flash('mensagem_erro', 'Informe a natureza de operação para o PDV!');
                return redirect('/configNF');
            }else{
                $tiposPagamentoMulti = VendaCaixa::tiposPagamentoMulti();
                $produtos = Produto::
                where('valor_venda', '>', 0)
                ->orderBy('nome')->get();
                foreach($produtos as $p){
                    $p->listaPreco;
                    if($p->grade){
                        $p->nome .= " $p->str_grade";
                    }
                }
                $categorias = Categoria::orderBy('nome')->get();
                $clientes = Cliente::orderBy('razao_social')->get();

                foreach($clientes as $c){
                    $c->totalEmAberto = 0;
                    $soma = $this->getTotalContaCredito($c);
                    if($soma != null){
                        $c->totalEmAberto = $soma->total;
                    }
                }
                $orcamentos = Orcamento::
                where('estado', 'NOVO')
                ->get();

                $atalhos = ConfigCaixa::
                where('usuario_id', get_id_user())
                ->first();

                $view = 'main';
                if($atalhos != null && $atalhos->modelo_pdv == 1){
                    $view = 'main2';
                }

                $mesas = Mesa::all();

                $adicionais = ComplementoDelivery::all();
                foreach($adicionais as $a){
                    $a->nome = $a->nome();
                }

                $pedido = null;

                if($pedidoId > 0){
                    $pedido = Pedido::
                    where('id', $pedidoId)
                    ->where('desativado', false)
                    ->first();
                }

                $pedidos = Pedido::
                where('desativado', false)
                ->orderBy('comanda')
                ->get();

                return view('frontBox/'.$view)
                ->with('frenteCaixa', true)
                ->with('tiposPagamento', $tiposPagamento)
                ->with('config', $config)
                ->with('pedidos', $pedidos)
                ->with('atalhos', $atalhos)
                ->with('adicionais', $adicionais)
                ->with('mesas', $mesas)
                ->with('pedido', $pedido)
                ->with('orcamentos', $orcamentos)
                ->with('certificado', $certificado)
                ->with('listaPreco', ListaPreco::all())
                ->with('disableFooter', true)
                ->with('usuario', $usuario)
                ->with('produtos', $produtos)
                ->with('clientes', $clientes)
                ->with('categorias', $categorias)
                ->with('tiposPagamentoMulti', $tiposPagamentoMulti)
                ->with('title', 'Frente de Caixa');
            }
        }
    }

    private function getTotalContaCredito($cliente){
        return CreditoVenda::
        selectRaw('sum(vendas.valor_total) as total')
        ->join('vendas', 'vendas.id', '=', 'credito_vendas.venda_id')
        ->where('credito_vendas.cliente_id', $cliente->id)
        ->where('status', 0)
        ->first();
    }

    private function cancelarNFCe($venda){
        $config = ConfigNota::first();

        $cnpj = str_replace(".", "", $config->cnpj);
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace(" ", "", $cnpj);
        $nfe_service = new NFeService([
            "atualizacao" => date('Y-m-d h:i:s'),
            "tpAmb" => 2,
            "razaosocial" => $config->razao_social,
            "siglaUF" => $config->UF,
            "cnpj" => $cnpj,
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "XTZOH6COASX5DYLKBUZXG5TABFG7ZFTQVSA2",
            "CSCid" => "000001"
        ], 65);

        $nfce = $nfe_service->cancelarNFCe($venda->id, "Troca de produtos requisitada pelo cliente");
        return is_array($nfce);
    }

    public function deleteVenda($id){
        $venda = VendaCaixa
        ::where('id', $id)
        ->first();


        $stockMove = new StockMove();

        foreach($venda->itens as $i){
            if($i->produto->receita){
                $receita = $i->produto->receita;
                foreach($receita->itens as $rec){

                    if($i->itemPedido != NULL && $i->itemPedido->tamanho != NULL){
                        $totalSabores = count($i->itemPedido->sabores);
                        $produtoPizza = ProdutoPizza::
                        where('produto_id', $i->produto->delivery->id)
                        ->where('tamanho_id', $i->itemPedido->tamanho->id)
                        ->first();

                        $stockMove->pluStock(
                            $rec->produto_id, $i->quantidade 
                      * 
                            ((($rec->quantidade/$totalSabores)/$receita->pedacos)*$produtoPizza->tamanho->pedacos)/$receita->rendimento
                        );

                    }else{
                        $stockMove->pluStock($rec->produto_id, 
                            $i->quantidade);
                    }
                }
            }else{
                $stockMove->pluStock($i->produto_id, 
                        $i->quantidade); // -50 na altera valor compra
            }
        }

        if($venda->delete()){
            session()->flash("mensagem_sucesso", "Venda removida com sucesso!");
        }else{
            session()->flash('mensagem_erro', 'Erro ao remover venda!');
        }
        return redirect('/frenteCaixa/devolucao');

    }

    public function list(){
        // $vendas = VendaCaixa::
        // orderBy('id', 'desc')
        // ->get();

        $vendas = VendaCaixa::filtroData(
            $this->parseDate(date("Y-m-d")),
            $this->parseDate(date("Y-m-d"), true)
        );


        $somaTiposPagamento = $this->somaTiposPagamento($vendas);
        return view('frontBox/list')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('somaTiposPagamento', $somaTiposPagamento)
        ->with('info', "Lista de vendas de Hoje: " . date("d/m/Y") )
        ->with('title', 'Lista de Vendas na Frente de Caixa');
    }

    private function somaTiposPagamento($vendas){
        $tipos = $this->preparaTipos();

        foreach($vendas as $v){
            if(isset($tipos[$v->tipo_pagamento])){
                $tipos[$v->tipo_pagamento] += $v->valor_total;
            }
        }
        return $tipos;

    }

    private function preparaTipos(){
        $temp = [];
        foreach(VendaCaixa::tiposPagamento() as $key => $tp){
            $temp[$key] = 0;
        }
        return $temp;
    }

    public function devolucao(){
        $vendas = VendaCaixa::
        orderBy('id', 'desc')
        ->limit(20)
        ->get();
        return view('frontBox/devolucao')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('nome', '')
        ->with('nfce', '')
        ->with('valor', '')
        ->with('info', "Lista das ultimas 20 vendas")

        ->with('title', 'Devolução');
    }

    public function filtro(Request $request){
        $dataInicial = $request->data_inicial;
        $dataFinal = $request->data_final;

        $vendas = VendaCaixa::filtroData(
            $this->parseDate($dataInicial),
            $this->parseDate($dataFinal, true)
        );

        $somaTiposPagamento = $this->somaTiposPagamento($vendas);

        return view('frontBox/list')
        ->with('vendas', $vendas)
        ->with('dataInicial', $dataInicial)
        ->with('somaTiposPagamento', $somaTiposPagamento)
        ->with('info', "Lista de vendas período: $dataInicial até $dataFinal")
        ->with('dataFinal', $dataFinal)
        ->with('frenteCaixa', true)
        ->with('info', "Lista das ultimas 20 vendas")
        ->with('title', 'Filtro de Vendas na Frente de Caixa');
    }


    private function parseDate($date, $plusDay = false){
        if($plusDay == false)
            return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
        else
            return date('Y-m-d', strtotime("+1 day",strtotime(str_replace("/", "-", $date))));
    }



    public function filtroCliente(Request $request){

        $vendas = VendaCaixa::filtroCliente($request->nome);
        return view('frontBox/devolucao')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('valor', '')
        ->with('nome', $request->nome)
        ->with('nfce', '')
        ->with('info', "Filtro cliente: $request->nome")

        ->with('title', 'Filtro por cliente');
    }


    public function filtroNFCe(Request $request){

        $vendas = VendaCaixa::filtroNFCe($request->nfce);
        return view('frontBox/devolucao')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('valor', '')
        ->with('nfce', $request->nfce)
        ->with('nome', '')
        ->with('info', "Filtro NFCE: $request->nfce")
        ->with('title', 'Filtro por NFCe');
    }

    public function filtroValor(Request $request){

        $vendas = VendaCaixa::filtroValor($request->valor);
        return view('frontBox/devolucao')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('nfce', '')
        ->with('valor', $request->valor)
        ->with('nome', '')
        ->with('info', "Filtro valor: $request->valor")

        ->with('title', 'Filtro por Valor');
    }

    public function fechar(){
        $abertura = AberturaCaixa::where('ultima_venda', 0)->orderBy('id', 'desc')->first();
        $ultimaFechada = AberturaCaixa::where('ultima_venda', '>', 0)->orderBy('id', 'desc')->first();

        $ultimaVendaCaixa = VendaCaixa::orderBy('id', 'desc')->first();
        $vendas = [];
        $somaTiposPagamento = [];
        if($ultimaVendaCaixa != null){
            $ultimaVendaCaixa = $ultimaVendaCaixa->id;

            $vendas = VendaCaixa
            ::whereBetween('id', [($ultimaFechada != null ? $ultimaFechada->ultima_venda+1 : 0), 
                $ultimaVendaCaixa])
            ->get();

            $somaTiposPagamento = $this->somaTiposPagamento($vendas);

        }
        if($abertura == null){
            return redirect('/frenteCaixa')->with('erro', 'O caixa esta fechado!!');
        }else{
            return view('frontBox/fechar_caixa')
            ->with('vendas', $vendas)
            ->with('abertura', $abertura)
            ->with('somaTiposPagamento', $somaTiposPagamento)
            ->with('title', 'Fechar caixa');
        }
    }

    public function fecharPost(Request $request){
        $id = $request->abertura_id;
        $abertura = AberturaCaixa::find($id);
        $ultimaVendaCaixa = VendaCaixa::orderBy('id', 'desc')->first();
        $abertura->ultima_venda = $ultimaVendaCaixa->id;
        $abertura->save();
        session()->flash("mensagem_sucesso", "Caixa fechado com sucesso!");
        return redirect('frenteCaixa/list');
    }

    public function fechamentos(){
        $aberturas = AberturaCaixa::where('ultima_venda', '>', 0)->get();
        $arr = [];

        for($i = 0; $i < sizeof($aberturas); $i++){
            $atual = $aberturas[$i]->ultima_venda;
            if($i == 0){
                $anterior = 0;
            }else{
                $anterior = $aberturas[$i-1]->ultima_venda;
            }
            $vendas = VendaCaixa
            ::whereBetween('id', [$anterior+1, 
                $atual])
            ->get();

            $total = 0;
            foreach($vendas as $v){
                $total += $v->valor_total;
            }

            $temp = [
                'inicio' => \Carbon\Carbon::parse($aberturas[$i]->created_at)->format('d/m/Y H:i:s'),
                'fim' => \Carbon\Carbon::parse($aberturas[$i]->updated_at)->format('d/m/Y H:i:s'),
                'total' => $total,
                'id' => $aberturas[$i]->id
            ];

            array_push($arr, $temp);
        }

        usort($arr, function ($a, $b) {
            return ($a['id'] < $b['id']) ? 1 : -1;
        });

        return view('frontBox/fechamentos')
        ->with('fechamentos', $arr)
        ->with('title', 'Lista de Caixas');
    }

    public function listaFechamento($id){
        $aberturas = AberturaCaixa::all();
        $abertura = null;
        $inicio = 0;
        $fim = 0;

        for($i = 0; $i < sizeof($aberturas); $i++){
            if($aberturas[$i]->id == $id){
                $abertura = $aberturas[$i];
                if($i > 0){
                    $inicio = $aberturas[$i-1]->ultima_venda +1;
                }

                $fim = $aberturas[$i]->ultima_venda;
            }
        }

        $vendas = [];
        $somaTiposPagamento = [];


        $vendas = VendaCaixa
        ::whereBetween('id', [$inicio, 
            $fim])
        ->get();

        $somaTiposPagamento = $this->somaTiposPagamento($vendas);

        return view('frontBox/lista_fecha_caixa')
        ->with('vendas', $vendas)
        ->with('abertura', $abertura)
        ->with('somaTiposPagamento', $somaTiposPagamento)
        ->with('title', 'Detalhe fecha caixa');
    }

    public function config(){

        $config = ConfigCaixa::
        where('usuario_id', get_id_user())
        ->first();

        return view('frontBox/config')
        ->with('config', $config)
        ->with('title', 'Configuração Caixa');
    }

    public function configSave(Request $request){
        // $usuario = Usuario::find(get_id_user());
        $config = ConfigCaixa::
        where('usuario_id', get_id_user())
        ->first();

        if($config == null){
            $data = [
                'finalizar' => $request->finalizar ?? '',
                'reiniciar' => $request->reiniciar ?? '',
                'editar_desconto' => $request->editar_desconto ?? '',
                'editar_acrescimo' => $request->editar_acrescimo ?? '',
                'editar_observacao' => $request->editar_observacao ?? '', 
                'setar_valor_recebido' => $request->setar_valor_recebido ?? '',
                'forma_pagamento_dinheiro' => $request->forma_pagamento_dinheiro ?? '',
                'forma_pagamento_debito' => $request->forma_pagamento_debito ?? '',
                'forma_pagamento_credito' => $request->forma_pagamento_credito ?? '',
                'forma_pagamento_pix' => $request->forma_pagamento_pix ?? '',
                'setar_leitor' => $request->setar_leitor ?? '',
                'impressora_modelo' => $request->impressora_modelo ?? 80,
                'modelo_pdv' => $request->modelo_pdv,
                'valor_recebido_automatico' => $request->valor_recebido_automatico ? true : false,
                'usuario_id' => get_id_user()
            ];

            ConfigCaixa::create($data);
            session()->flash("mensagem_sucesso", "Configuração salva!");

        }else{
            $config->finalizar = $request->finalizar ?? '';
            $config->reiniciar = $request->reiniciar ?? '';
            $config->editar_desconto = $request->editar_desconto ?? '';
            $config->editar_acrescimo = $request->editar_acrescimo ?? '';
            $config->editar_observacao = $request->editar_observacao ?? '';
            $config->setar_valor_recebido = $request->setar_valor_recebido ?? '';
            $config->forma_pagamento_dinheiro = $request->forma_pagamento_dinheiro ?? '';
            $config->forma_pagamento_debito = $request->forma_pagamento_debito ?? '';
            $config->forma_pagamento_credito = $request->forma_pagamento_credito ?? '';
            $config->forma_pagamento_pix = $request->forma_pagamento_pix ?? '';
            $config->setar_leitor = $request->setar_leitor ?? '';
            $config->valor_recebido_automatico = $request->valor_recebido_automatico ? true : false;
            $config->impressora_modelo = $request->impressora_modelo ?? 80;
            $config->modelo_pdv = $request->modelo_pdv;

            $config->save();
            session()->flash("mensagem_sucesso", "Configuração editada!");

        }

        return redirect()->back();
    }

    public function saveItemPedido(Request $request){
        $this->_validateItem($request);

        $comanda = Pedido::
        where('comanda', $request->id)
        ->where('desativado', false)
        ->first();

        if($comanda == null){
            $res = Pedido::create([
                'comanda' => $request->id,
                'observacao' => $request->observacao ?? '',
                'status' => false,
                'nome' => '',
                'rua' => '',
                'numero' => '',
                'bairro_id' => null,
                'referencia' => '',
                'telefone' => '',
                'fechar_mesa' => false,
                'desativado' => false,
                'mesa_id' => $request->mesa_id != 'null' ? $request->mesa_id : null
            ]);
            if($res) {
                $result = ItemPedido::create([
                    'pedido_id' => $res->id,
                    'produto_id' => $request->produto,
                    'quantidade' => str_replace(",", ".", $request->quantidade),
                    'status' => false,
                    'tamanho_pizza_id' => $request->tamanho_pizza_id ?? NULL,
                    'observacao' => $request->observacao ?? '',
                    'valor' => str_replace(",", ".", $request->valor),
                    'impresso' => 0, 
                    'usuario_id' => get_id_user()
                ]);

                if($request->adicional > 0){
                    $item = ItemPedidoComplementoLocal::create([
                        'item_pedido' => $result->id,
                        'complemento_id' => $request->adicional,
                        'quantidade' => str_replace(",", ".", $request->quantidade),
                    ]);
                }
                session()->flash('mensagem_sucesso', 'Comanda aberta com sucesso!');
                return redirect('/frenteCaixa/comPedido/'.$res->id);

            }
        }else{
            $result = ItemPedido::create([
                'pedido_id' => $comanda->id,
                'produto_id' => $request->produto,
                'quantidade' => str_replace(",", ".", $request->quantidade),
                'status' => false,
                'tamanho_pizza_id' => $request->tamanho_pizza_id ?? NULL,
                'observacao' => $request->observacao ?? '',
                'valor' => str_replace(",", ".", $request->valor),
                'impresso' => 0, 
                'usuario_id' => get_id_user()
            ]);

            if($request->adicional > 0){
                $item = ItemPedidoComplementoLocal::create([
                    'item_pedido' => $result->id,
                    'complemento_id' => $request->adicional,
                    'quantidade' => str_replace(",", ".", $request->quantidade),
                ]);
            }
            // session()->flash('mensagem_erro', 'Esta comanda encontra-se ativa!');
            // return redirect()->back();
            session()->flash('mensagem_sucesso', 'Item adicionado com sucesso!');
            return redirect('/frenteCaixa/comPedido/'.$comanda->id);
        }
    }

    private function _validateItem(Request $request){
        $validaTamanho = false;

        $rules = [
            'id' => 'required',
            'produto' => 'required|numeric|min:1',
            'quantidade' => 'required',
            'valor' => 'required',
        ];

        $messages = [
            'id.required' => 'Campo obrigatório.',
            'produto.required' => 'O campo produto é obrigatório.',
            'produto.numeric' => 'O campo produto é obrigatório.',
            'produto.min' => 'O campo produto é obrigatório.',
            'quantidade.required' => 'O campo quantidade é obrigatório.',
            'valor.required' => 'O campo valor é obrigatório.',
        ];

        $this->validate($request, $rules, $messages);
    }

    public function deleteItemPedido($id){
        $item = ItemPedido::
        where('id', $id)
        ->first();

        PedidoDelete::create(
            [
                'pedido_id' => $item->pedido_id,
                'produto' => $item->nomeDoProduto(),
                'quantidade' => $item->quantidade,
                'valor' => $item->valor,
                'data_insercao' => \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s')
            ]
        );

        if($item->delete()){
            session()->flash('mensagem_sucesso', 'Item removido!');
        }else{
            session()->flash('mensagem_erro', 'Erro');
        }
        return redirect()->back();
    }

    public function deletePedido($id){
        $pedido = Pedido::
        where('id', $id)
        ->first();

        if($pedido->delete()){
            session()->flash('mensagem_sucesso', 'Pedido removido!');
        }else{
            session()->flash('mensagem_erro', 'Erro');
        }
        return redirect('/frenteCaixa');
    }

}
