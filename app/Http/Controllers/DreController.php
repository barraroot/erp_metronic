<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tributacao;
use App\Models\Dre;
use App\Models\DreCategoria;
use App\Models\LancamentoCategoria;

use App\Models\Venda;
use App\Models\VendaCaixa;
use App\Models\Devolucao;
use App\Models\Compra;
use App\Models\ComissaoVenda;
use App\Models\Frete;
use App\Models\Funcionario;
use App\Models\ContaPagar;
use Dompdf\Dompdf;

class DreController extends Controller
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

		$tributacao = Tributacao::first();

		if($tributacao == null){
			session()->flash("mensagem_sucesso", "Informe a tributação!");
			return redirect('/tributos');
		}

		return view('dre/index')
		->with('tributacao', $tributacao)
		->with('title', 'DRE');
	}

	public function save(Request $request){
		$inicio = $request->data_inicio;
		$fim = $request->data_fim;
		$percImposto = $request->perc_imposto;

		try{
			$data = [
				'inicio' => $this->parseDate($inicio),
				'fim' => $this->parseDate($fim),
				'observacao' => $request->observacao ?? '',
				'percentual_imposto' => __replace($percImposto),
				'lucro_prejuizo' => 0
			];

			$dre = Dre::create($data);
			$dre->criaCategoriasPreDefinidas();

			$this->iniciaDre($dre, $inicio, $fim);

			session()->flash("mensagem_sucesso", "Relatório DRE criado!");
			return redirect('/dre/list');

		}catch(\Exception $e){
			echo $e->getMessage();
		}

	}

	public function list(){
		$docs = Dre::
		orderBy('id', 'desc')
		->get();

		return view('dre/list')
		->with('docs', $docs)
		->with('title', 'DRE');
	}

	public function ver($id){
		$dre = Dre::find($id);

		$tributacao = Tributacao::
		first();

		return view('dre/ver')
		->with('dre', $dre)
		->with('dreJs', true)
		->with('tributacao', $tributacao)
		->with('title', 'DRE');
		return redirect('/403');
		
	}

	public function updatelancamento(Request $request){
		$lancamentoId = $request->lancamento_id;
		$lancamento = LancamentoCategoria::find($lancamentoId);

		$lancamento->valor = __replace($request->valor);
		$lancamento->nome = $request->nome;
		$lancamento->save();

		$this->recalcularPercentual($lancamento->categoria->dre_id);
		session()->flash("mensagem_sucesso", "Lançamento alterado com sucesso!");
		return redirect()->back();

	}

	public function novolancamento(Request $request){
		$categoriaId = $request->categoria_id;
		$valor = __replace($request->valor);
		$nome = $request->nome;

		$dataLancamento = [
			'categoria_id' => $categoriaId,
			'nome' => $nome,
			'valor' => $valor,
			'percentual' => 0
		];

		LancamentoCategoria::create($dataLancamento);

		$categoria = DreCategoria::find($categoriaId);
		$this->recalcularPercentual($categoria->dre_id);
		session()->flash("mensagem_sucesso", "Lançamento cadastrado com sucesso!");
		return redirect()->back();

	}


	public function deleteLancamento($id){
		try{
			LancamentoCategoria::find($id)->delete();

			session()->flash("mensagem_sucesso", "Lançamento removido com sucesso!");
		}catch(\Exception $e){
			session()->flash("mensagem_erro", "Erro ao remover lançamento!");

		}

		return redirect()->back();

	}

	private function recalcularPercentual($dreId){

		$dre = Dre::find($dreId);
		$liquido = 0;
		$somaDeducoes = 0;
		foreach($dre->categorias as $key => $c){
			$faturamento = $c->soma();
			if($key > 0){
				foreach($c->lancamentos as $l){
					if($faturamento == 0){
						$l->percentual = 0;
					}else{
						$percentual = number_format((($l->valor/$faturamento) * 100), 2);
						$l->percentual = $percentual;
					}
					$l->save();
				}
			}

			if($key == 2){
				$liquido = $l->valor;
			}

			if($key > 2){
				$somaDeducoes += $l->valor;
			}
		}

		$lucro_prejuizo = $liquido - $somaDeducoes;
		$dre->lucro_prejuizo = $lucro_prejuizo;
		$dre->save();

	}

	public function iniciaDre($dre, $inicio, $fim){
		$somaCustos = 0;

		foreach($dre->categorias as $key => $c){
			if($key == 0){

                //Venda NFE
				$vendas = $this->getVendasPeriodo($this->parseDate($inicio), $this->parseDate($fim, true));

				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Faturamento bruto vendas',
					'valor' => $vendas->soma ?? 0,
					'percentual' => 0
				];

				LancamentoCategoria::create($dataLancamento);

                // PDV
				$vendas = $this->getVendasPdvPeriodo($this->parseDate($inicio), $this->parseDate($fim, true));

				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Faturamento bruto vendas PDV',
					'valor' => $vendas->soma ?? 0,
					'percentual' => 0
				];
				LancamentoCategoria::create($dataLancamento);

                // Outros
				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Faturamento outros',
					'valor' => 0,
					'percentual' => 0
				];
				LancamentoCategoria::create($dataLancamento);
			}

			if($key == 1){

                //Devoluções
				$devolucoes = $this->getDevolucoes($this->parseDate($inicio), $this->parseDate($fim, true));

				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Devoluções',
					'valor' => $devolucoes->soma ?? 0,
					'percentual' => 0
				];
				LancamentoCategoria::create($dataLancamento);

                //Abatimentos
				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Abatimentos/Descontos',
					'valor' => 0,
					'percentual' => 0
				];
				LancamentoCategoria::create($dataLancamento);

                //Imposto
				$calculaImposto = $this->calculaImposto($this->parseDate($inicio), $this->parseDate($fim, true), $dre->percentual_imposto);

				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Impostos',
					'valor' => $calculaImposto,
					'percentual' => 0
				];
				LancamentoCategoria::create($dataLancamento);

			}

			if($key == 2){
                //Faturamento liquido
				$faturamentoLiquido = $this->calculoFaturamentoLiquido($dre);
				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Faturamento Líquido',
					'valor' => $faturamentoLiquido,
					'percentual' => 100
				];
				LancamentoCategoria::create($dataLancamento);

				$valorLiquido = $faturamentoLiquido;
			}



			if($key == 3){
                //Custos de Produção Variáveis
				$compras = $this->getCompras($this->parseDate($inicio), $this->parseDate($fim, true));

				$somaCustos += $compras->soma ?? 0;

				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Matéria prima/compras',
					'valor' => $compras->soma ?? 0,
					'percentual' => 0
				];
				LancamentoCategoria::create($dataLancamento);

				$fretes = $this->getFretes($this->parseDate($inicio), $this->parseDate($fim, true));
				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Despesas com Transportes',
					'valor' => $fretes->soma ?? 0,
					'percentual' => 0
				];
				LancamentoCategoria::create($dataLancamento);

				$somaCustos += $fretes->soma ?? 0;

				$comissoes = $this->getComissaoVendas($this->parseDate($inicio), $this->parseDate($fim, true));
				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Comissões Vendas',
					'valor' => $comissoes->soma ?? 0,
					'percentual' => 0
				];
				LancamentoCategoria::create($dataLancamento);

				$somaCustos += $comissoes->soma ?? 0;

			}

			if($key == 4){
                //Custos Fixos e Despesas

				$salarios = $this->getSalarios($this->parseDate($inicio), $this->parseDate($fim, true));
				$dataLancamento = [
					'categoria_id' => $c->id,
					'nome' => 'Sálario Funcionários',
					'valor' => $salarios->soma ?? 0,
					'percentual' => 0
				];
				LancamentoCategoria::create($dataLancamento);

				$somaCustos += $salarios->soma ?? 0;

				$contas = $this->getContasPagar($this->parseDate($inicio), $this->parseDate($fim, true));

				foreach($contas as $conta){

					$dataLancamento = [
						'categoria_id' => $c->id,
						'nome' => $conta->nome,
						'valor' => $conta->soma ?? 0,
						'percentual' => 0
					];
					LancamentoCategoria::create($dataLancamento);

					$somaCustos += $conta->soma ?? 0;

				}

			}
		}

		echo $valorLiquido;

		$dre->lucro_prejuizo = $valorLiquido - $somaCustos;
		$dre->save();
		$this->recalcularPercentual($dre->id);
	}


	private function parseDate($date, $plusDay = false){
		if($plusDay == false)
			return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
		else
			return date('Y-m-d', strtotime("+1 day",strtotime(str_replace("/", "-", $date))));
	}


	private function getVendasPeriodo($inicio, $fim){
		$vendas = Venda::
		selectRaw('sum(valor_total) as soma')
		->whereBetween('created_at', [
			$inicio, 
			$fim
		])
		->first();

		return $vendas;
	}

	private function getVendasPdvPeriodo($inicio, $fim){
		$vendas = VendaCaixa::
		selectRaw('sum(valor_total) as soma')
		->whereBetween('created_at', [
			$inicio, 
			$fim
		])
		->first();

		return $vendas;
	}

	private function getDevolucoes($inicio, $fim){
		$devolucoes = Devolucao::
		selectRaw('sum(valor_devolvido) as soma')
		->whereBetween('created_at', [
			$inicio, 
			$fim
		])
		->where('tipo', 0)
		->first();

		return $devolucoes;
	}

	private function calculaImposto($inicio, $fim, $percImposto){

		$tributacao = Tributacao::
		first();

		if($tributacao->regime != 1){
			$vendas = Venda::
			selectRaw('sum(valor_total) as soma')
			->whereBetween('created_at', [
				$inicio, 
				$fim
			])
			->where('NfNumero', '>', 0)
			->where('estado', 'APROVADO')
			->first();

			$vendasCaixa = VendaCaixa::
			selectRaw('sum(valor_total) as soma')
			->whereBetween('created_at', [
				$inicio, 
				$fim
			])
			->where('NFcNumero', '>', 0)
			->where('estado', 'APROVADO')
			->first();


			$soma = $vendasCaixa->soma + $vendas->soma;
			$p = $soma*($percImposto/100);

			return $p;
		}else{
			$vendas = Venda::
			whereBetween('created_at', [
				$inicio, 
				$fim
			])
			->where('NfNumero', '>', 0)
			->where('estado', 'APROVADO')
			->get();

			$impostoNFe = $this->extrairImposto($vendas, 'xml_nfe');

			$vendasCaixa = VendaCaixa::
			whereBetween('created_at', [
				$inicio, 
				$fim
			])
			->where('NFcNumero', '>', 0)
			->where('estado', 'APROVADO')
			->get();

			$impostoNFCe = $this->extrairImposto($vendasCaixa, 'xml_nfce');


			return $impostoNFe + $impostoNFCe;
		}

	}

	private function extrairImposto($vendas, $path){

		$somaIcms = 0;
		$somaPis = 0;
		$somaCofins = 0;
		foreach($vendas as $v){
			$file = public_path($path) . "/" . $v->chave . ".xml";
			$xml = simplexml_load_file($file);

			$vIcms = $xml->NFe->infNFe->total->ICMSTot->vICMS;
			$vPis = $xml->NFe->infNFe->total->ICMSTot->vPIS;
			$vCofins = $xml->NFe->infNFe->total->ICMSTot->vCOFINS;

			$somaIcms += $vIcms;
			$somaPis += $vPis;
			$somaCofins += $vCofins;

		}

		return $somaIcms + $somaPis + $somaCofins;
	}

	private function calculoFaturamentoLiquido($dre){
		$somaBruto = 0;
		$somaDeducoes = 0;
		foreach($dre->categorias as $key => $c){
			if($key == 0){
				foreach($c->lancamentos as $l){
					$somaBruto += $l->valor;
				}
			}

			if($key == 1){
				foreach($c->lancamentos as $l){
					$somaDeducoes += $l->valor;
				}
			}
		}
		return $somaBruto - $somaDeducoes;
	}

	private function getCompras($inicio, $fim){
		$compras = Compra::
		selectRaw('sum(valor) as soma')
		->whereBetween('created_at', [
			$inicio, 
			$fim
		])
		->first();

		return $compras;

	}

	private function getComissaoVendas($inicio, $fim){
		$comissoes = ComissaoVenda::
		selectRaw('sum(valor) as soma')
		->whereBetween('created_at', [
			$inicio, 
			$fim
		])
		->first();

		return $comissoes;
	}

	private function getFretes($inicio, $fim){
		$fretes = Frete::
		selectRaw('sum(fretes.valor) as soma')
		->join('vendas', 'vendas.frete_id' , '=', 'fretes.id')
		->whereBetween('fretes.created_at', [
			$inicio, 
			$fim
		])
		->first();

		return $fretes;
	}

	private function getSalarios($inicio, $fim){
		$funcionarios = Funcionario::
		selectRaw('sum(salario) as soma')
		->whereBetween('created_at', [
			$inicio, 
			$fim
		])
		->first();

		return $funcionarios;
	}

	private function getContasPagar($inicio, $fim){
		$contas = ContaPagar::
		selectRaw('categoria_contas.nome as nome, sum(conta_pagars.valor_integral) as soma')
		->join('categoria_contas', 'categoria_contas.id' , '=', 'conta_pagars.categoria_id')
		->whereBetween('conta_pagars.data_vencimento', [
			$inicio, 
			$fim
		])
		->where('categoria_contas.nome', '!=', 'Compras')
		->where('categoria_contas.nome', '!=', 'Vendas')
		->groupBy('categoria_contas.id')
		->get();

		return $contas;
	}

	public function imprimir($id){
		$dre = Dre::find($id);

		$tributacao = Tributacao::
		first();

		$p = view('dre/imprimir')
		->with('dre', $dre)
		->with('tributacao', $tributacao)
		->with('title', 'DRE');

            // return $p;
		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

            // $pdf = ob_get_clean();

		$domPdf->setPaper("A4");
		$domPdf->render();
		$domPdf->stream("DRE.pdf");
		
	}

	public function delete($id){
		$dre = Dre::find($id);
		$dre->delete();
		session()->flash("mensagem_sucesso", "Registro removido");
		return redirect()->back();

	}
}
