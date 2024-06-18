<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ClienteDelivery;
use App\Models\Produto;
use App\Models\PedidoDelivery;
use App\Models\Venda;
use App\Models\VendaCaixa;
use App\Models\ContaPagar;
use App\Models\ContaReceber;
use App\Models\Usuario;

class HomeController extends Controller
{
    protected $acesso_financeiro = false;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $value = session('user_logged');
            if(!$value){
                return redirect("/login");
            }else{
                $this->acesso_financeiro = $value['acesso_financeiro'];

            }
            return $next($request);
        });
    }
    
    public function index()
    {
        $totalizacao = $this->totalizacao();

        $dataFinal = date('d/m/Y');
        $dataInicial = date('d/m/Y', strtotime('-6 day'));

        return view('default/grafico')
        ->with('graficoHomeJs', true)
        ->with('totalDeProdutos', $totalizacao['totalDeProdutos'])
        ->with('totalDeClientes', $totalizacao['totalDeClientes'])
        ->with('totalDeVendas', $totalizacao['totalDeVendas'])
        ->with('totalDePedidos', $totalizacao['totalDePedidos'])
        ->with('totalDeContaReceber', $totalizacao['totalDeContaReceber'])
        ->with('totalDeContaPagar', $totalizacao['totalDeContaPagar'])
        ->with('dataInicial', $dataInicial)
        ->with('dataFinal', $dataFinal)
        ->with('title', 'Bem Vindo');
    }

    private function totalizacao(){
        $totalDeProdutos = count(Produto::all());
        $totalDeClientes = count(Cliente::all()) + 
        count(ClienteDelivery::where('ativo', true)->get());

        return [
            'totalDeClientes' => $totalDeClientes,
            'totalDeProdutos' => $totalDeProdutos,
            'totalDeVendas' => $this->totalDeVendasHoje(),
            'totalDePedidos' => $this->totalDePedidosDeDliveryHoje(),
            'totalDeContaReceber' => $this->totalDeContaReceberHoje(),
            'totalDeContaPagar' => $this->totalDeContaPagarHoje(),
        ];
    }

    private function totalDeVendasHoje(){
        $vendas = Venda::
        select(\DB::raw('sum(valor_total) as total'))
        ->whereBetween('created_at', [
            date('Y-m-d', strtotime('-7 days')), 
            date('Y-m-d', strtotime('+1 day'))
        ])
        ->first();

        $vendaCaixas = VendaCaixa::
        select(\DB::raw('sum(valor_total) as total'))
        ->whereBetween('created_at', [
            date('Y-m-d', strtotime('-7 days')), 
            date('Y-m-d', strtotime('+1 day'))
        ])
        ->first();


        return $vendas->total + $vendaCaixas->total;

    }

    private function totalDePedidosDeDliveryHoje(){
        $pedidos = PedidoDelivery::
        select(\DB::raw('count(*) as linhas'))
        ->whereBetween('data_registro', [date("Y-m-d"), 
            date('Y-m-d', strtotime('+1 day'))])
        ->first();
        return $pedidos->linhas;
    }

    private function totalDeContaReceberHoje(){
        $contas = ContaReceber::
        select(\DB::raw('sum(valor_integral) as total'))
        ->whereBetween('data_vencimento', [date("Y-m-d"), 
            date('Y-m-d', strtotime('+1 day'))])
        ->where('status', false)
        ->first(); 
        if($this->acesso_financeiro == 0) return 0;
        return $contas->total ?? 0;
    }

    private function totalDeContaPagarHoje(){
        $contas = ContaPagar::
        select(\DB::raw('sum(valor_integral) as total'))
        ->whereBetween('data_vencimento', [date("Y-m-d"), 
            date('Y-m-d', strtotime('+1 day'))])
        ->where('status', false)
        ->first(); 

        if($this->acesso_financeiro == 0) return 0;
        return $contas->total ?? 0;
    }



    public function faturamentoDosUltimosSeteDias(){

        $arrayVendas = [];
        for($aux = 0; $aux > -7; $aux--){
            $vendas = Venda::
            select(\DB::raw('sum(valor_total) as total'))
            ->whereBetween('created_at', 
                [
                    // date('Y-m-d', strtotime($aux.' day')), 
                    // date('Y-m-d', strtotime(($aux+1).' day'))
                    date('Y-m-d', strtotime($aux.' day')) . ' 00:00:00', 
                    date('Y-m-d', strtotime(($aux).' day')) . ' 23:59:00'
                ]
            )
            ->first();


            $vendaCaixas = VendaCaixa::
            select(\DB::raw('sum(valor_total) as total'))
            ->whereBetween('created_at', 
                [
                    // date('Y-m-d', strtotime($aux.' day')), 
                    // date('Y-m-d', strtotime(($aux+1).' day'))
                    date('Y-m-d', strtotime($aux.' day')) . ' 00:00:00', 
                    date('Y-m-d', strtotime(($aux).' day')) . ' 23:59:00'
                ]
            )
            ->first();
            
            $total = (float)str_replace(",", ".", $vendas->total) + (float)str_replace(",", ".", $vendaCaixas->total);
            $temp = [
                'data' => date('d/m', strtotime(($aux).' day')),
                'total' => number_format($total, 2, ".", "")
            ];
            array_push($arrayVendas, $temp);
        }
        if($this->acesso_financeiro == 0){
            return response()->json(array_reverse([]));
        }
        return response()->json(array_reverse($arrayVendas));
        
    }

    public function faturamentoFiltrado(Request $request){

        $dataInicial = strtotime(str_replace("/", "-", $request->data_inicial));
        $dataFinal = strtotime(str_replace("/", "-", $request->data_final));

        $diferenca = ($dataFinal - $dataInicial)/86400; //86400 segundos do dia

        $arrayVendas = [];
        
        if($diferenca+1 > 30){ //filtrar por mes

            $total = 0;
            for($aux = 0; $aux > (($diferenca+1)*-1); $aux--){
                $vendas = Venda::
                select(\DB::raw('sum(valor_total) as total'))
                ->whereBetween('created_at', 
                    [
                        date('Y-m-d', strtotime($aux.' day')), 
                        date('Y-m-d', strtotime(($aux+1).' day'))
                    ]
                )
                ->first();

                $vendaCaixas = VendaCaixa::
                select(\DB::raw('sum(valor_total) as total'))
                ->whereBetween('created_at', 
                    [
                        date('Y-m-d', strtotime($aux.' day')), 
                        date('Y-m-d', strtotime(($aux+1).' day'))
                    ]
                )
                ->first();

                if($this->confereMesNoArray($arrayVendas, date('m/Y', strtotime(($aux).' day')))){
                    $cont = 0;
                    foreach($arrayVendas as $arr){
                        if($arr['data'] == date('m/Y', strtotime(($aux).' day'))){
                            $arrayVendas[$cont]['total'] += $vendas->total + $vendaCaixas->total;

                        }
                        $cont++;
                    }
                }else{
                    $temp = [
                        'data' => date('m/Y', strtotime(($aux).' day')),
                        'total' => number_format($vendas->total + $vendaCaixas->total, 2, '.', '')
                    ];
                    array_push($arrayVendas, $temp);
                }
                
            }



        }else{ //filtro por dia
            for($aux = 0; $aux > (($diferenca+1)*-1); $aux--){
                $vendas = Venda::
                select(\DB::raw('sum(valor_total) as total'))
                ->whereBetween('created_at', 
                    [
                        date('Y-m-d', strtotime($aux.' day')) . ' 00:00:00', 
                        date('Y-m-d', strtotime(($aux).' day')) . ' 23:59:00'
                    ]
                )
                ->first();


                $vendaCaixas = VendaCaixa::
                select(\DB::raw('sum(valor_total) as total'))
                ->whereBetween('created_at', 
                    [

                        date('Y-m-d', strtotime($aux.' day')) . ' 00:00:00', 
                        date('Y-m-d', strtotime(($aux).' day')) . ' 23:59:00'
                    ]
                )
                ->first();
                $temp = [
                    'data' => date('d/m', strtotime(($aux).' day')),
                    'total' => number_format(($vendas->total + $vendaCaixas->total), 2, '.', '')
                ];
                array_push($arrayVendas, $temp);
            }
        }

        if($this->acesso_financeiro == 0){
            return response()->json(array_reverse([]));
        }
        return response()->json(array_reverse($arrayVendas));
        
    }

    private function confereMesNoArray($arr, $mes){
        foreach($arr as $a){
            if($a['data'] == $mes) return true;
        }
        return false;
    }


}
