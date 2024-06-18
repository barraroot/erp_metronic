<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ItemCompra;
use App\Models\Produto;
use App\Models\ContaPagar;
use App\Models\ContaReceber;
use App\Models\Estoque;
use App\Models\Usuario;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        
        $tema = null;
        $tema_menu = null;
        $alertas = [];
        $semValidade = $this->verificaItensSemValidade();
        if($semValidade) {
            array_push($alertas, 
                [
                    'msg' => 'Existe itens em estoque sem cadastro de data de validade!',
                    'titulo' => 'Alerta validade',
                    'link' => '/compras/produtosSemValidade'
                ]
            );
        }

        $alertaValidade = $this->verificaValidadeProdutos();
        if($alertaValidade) {
            array_push($alertas, 
                [
                    'msg' => 'Existe Produtos com validade próxima!',
                    'titulo' => 'Validade próxima',
                    'link' => '/compras/validadeAlerta'
                ]
            );
        }

        $somaContas = $this->verificaContasPagar();
        if($somaContas > 0) {
            $dataHoje = date('d/m/Y', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            $dataFutura = date('d/m/Y', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            array_push($alertas, 
                [
                    'msg' => 'Contas a pagar R$'.number_format($somaContas, 2),
                    'titulo' => 'Alerta contas',
                    'link' => '/contasPagar/filtro?fornecedor=&data_inicial='.$dataHoje.'&data_final='.$dataFutura.'&status=todos'
                ]
            );
        }


        $somaContas = $this->verificaContasReceber();
        if($somaContas > 0) {
            $dataHoje = date('d/m/Y', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            $dataFutura = date('d/m/Y', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            array_push($alertas, 
                [
                    'msg' => 'Contas a receber R$'.number_format($somaContas, 2),
                    'titulo' => 'Receber',
                    'link' => '/contasReceber/filtro?cliente=&data_inicial='.$dataHoje.'&data_final='.$dataFutura.'&status=todos'
                ]
            );
        }

        if (\Schema::hasTable('produtos')){

            $produtos = Produto::all();
            $contDesfalque = 0;
            foreach($produtos as $p){
                if($p->estoque_minimo > 0){
                    $estoque = Estoque::where('produto_id', $p->id)->first();
                    $temp = null;
                    if($estoque == null){
                        $contDesfalque++;
                    }else{
                        $contDesfalque++;
                    }

                }
            }

            if($contDesfalque > 0){
                array_push($alertas, 
                    [
                        'msg' => 'Produtos com estoque minimo: ' . $contDesfalque,
                        'titulo' => 'Alerta estoque',
                        'link' => '/relatorios/filtroEstoqueMinimo'
                    ]
                );
            }

            $rotaAtiva = $this->rotaAtiva();
            $value = session('user_logged');

            


            view()->composer('*',function($view) use($alertas, $rotaAtiva, $tema, $tema_menu){

                $value = session('user_logged');
                if($value){

                    $usuario = Usuario::find($value['id']);
                    if($usuario == null){
                        return redirect('/login/logoff');
                    }
                    $tema = $usuario->tema;
                    $tema_menu = $usuario->tema_menu;
                }

                $uri = $_SERVER['REQUEST_URI'];
                $uri = explode("/", $uri);
                $uri = "/".$uri[1];
                $view->with('alertas', $alertas);
                $view->with('uri', $uri);
                $view->with('tema', $tema);
                $view->with('tema_menu', $tema_menu);
                $view->with('rotaAtiva', $rotaAtiva);
            });
        }
    }

    private function rotaAtiva(){
        if (isset($_SERVER['REQUEST_URI'])){ 
            $uri = $_SERVER['REQUEST_URI'];
            $uri = explode("/", $uri);
            $uri = $uri[1];

            $rotaDeCadastros = [
                'categorias', 'produtos', 'clientes', 'fornecedores', 'transportadoras', 
                'funcionarios', 'categoriasServico', 'servicos', 'categoriasConta', 
                'veiculos', 'usuarios', 'marcas'
            ];

            $rotaDeEntradas = [
                'compraFiscal', 'compraManual', 'compras', 'cotacao', 'dfe'
            ];

            $rotaDeEstoque = [
                'estoque'
            ];

            $rotaFinanceiro = [
                'contasPagar', 'contasReceber', 'fluxoCaixa', 'graficos'
            ];

            $rotaConfig = [
                'configNF', 'escritorio', 'naturezaOperacao', 'tributos', 'enviarXml', 'ibpt'
            ];

            $rotaVenda = [
                'caixa', 'vendas', 'frenteCaixa', 'orcamentoVenda', 'ordemServico', 'vendasEmCredito', 'devolucao', 'agendamentos'
            ];

            $rotaCTe = [
                'cte', 'categoriaDespesa'
            ];

            $rotaMDFe = [
                'mdfe'
            ];

            $rotaEvento = [
                'eventos'
            ];

            $rotaLocacao = [
                'locacao'
            ];

            $rotaRelatorio = [
                'relatorios',
                'dre'
            ];

            $rotaDelivery = [
                'deliveryCategoria', 'deliveryProduto', 'deliveryComplemento', 
                'bairrosDelivery','pedidosDelivery', 'configDelivery', 'funcionamentoDelivery',
                'push', 'tamanhosPizza', 'clientesDelivery', 'codigoDesconto'
            ];

            $rotaEcommerce = [
                'categoriaEcommerce', 'produtoEcommerce', 'configEcommerce', 
                'carrosselEcommerce', 'pedidosEcommerce', 'autorPost', 'categoriaPosts',
                'postBlog', 'contatoEcommerce', 'clienteEcommerce', 'informativoEcommerce'
            ];

            if(in_array($uri, $rotaDeCadastros)) return 'Cadastros';
            if(in_array($uri, $rotaDeEntradas)) return 'Entradas';
            if(in_array($uri, $rotaDeEstoque)) return 'Estoque';
            if(in_array($uri, $rotaFinanceiro)) return 'Financeiro';
            if(in_array($uri, $rotaConfig)) return 'Configurações';
            if(in_array($uri, $rotaVenda)) return 'Vendas';
            if(in_array($uri, $rotaCTe)) return 'CT-e';
            if(in_array($uri, $rotaMDFe)) return 'MDF-e';
            if(in_array($uri, $rotaEvento)) return 'Eventos';
            if(in_array($uri, $rotaRelatorio)) return 'Relatórios';
            if(in_array($uri, $rotaLocacao)) return 'Locação';
            if(in_array($uri, $rotaDelivery)) return 'Delivery';
            if(in_array($uri, $rotaEcommerce)) return 'Ecommerce';

        }else{
            return "";
        }
    }

    private function verificaItensSemValidade(){
        if (\Schema::hasTable('produtos')){
            $produtos = Produto::select('id')->where('alerta_vencimento', '>', 0)->get();
            $itensCompra = ItemCompra::where('validade', NULL)
            ->limit(100)->get();


            foreach($itensCompra as $i){
                foreach($produtos as $p){
                    if($p->id == $i->produto_id){
                        return true;
                    }
                }
            }
            return false;
        }
    }

    private function verificaValidadeProdutos(){
        if (\Schema::hasTable('item_compras')){

            $dataHoje = date('Y-m-d', strtotime("-30 days",strtotime(date('Y-m-d'))));
            $dataFutura = date('Y-m-d', strtotime("+30 days",strtotime(date('Y-m-d'))));

            $itens = ItemCompra::
            whereBetween('validade', [$dataHoje, $dataFutura])
            ->limit(300)->get();


            foreach($itens as $i){
                $strValidade = strtotime($i->validade);
                $strHoje = strtotime(date('Y-m-d'));
                $dif = $strValidade - $strHoje;
                $dif = $dif/24/60/60;
                if($dif <= $i->produto->alerta_vencimento) return true;
            }

            return false;
        }
    }

    private function verificaContasPagar(){
        if (\Schema::hasTable('conta_pagars')){
            $dataHoje = date('Y-m-d', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            $dataFutura = date('Y-m-d', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));

            $somaContas = ContaPagar::
            selectRaw('sum(valor_integral) as valor')
            ->whereBetween('data_vencimento', [$dataHoje, $dataFutura])
            ->where('status', 0)
            ->first();

            return $somaContas->valor ?? 0;
        }
    }

    private function verificaContasReceber(){
        if (\Schema::hasTable('conta_recebers')){
            $dataHoje = date('Y-m-d', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            $dataFutura = date('Y-m-d', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));

            $somaContas = ContaReceber::
            selectRaw('sum(valor_integral) as valor')
            ->whereBetween('data_vencimento', [$dataHoje, $dataFutura])
            ->where('status', 0)
            ->first();

            return $somaContas->valor ?? 0;
        }
    }
}
