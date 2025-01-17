<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DFeService;
use App\Models\ConfigNota;
use App\Models\ManifestaDfe;
use NFePHP\NFe\Common\Standardize;
use App\Models\Cidade;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Certificado;
use App\Models\Fornecedor;
use App\Models\Compra;
use App\Models\ContaPagar;
use NFePHP\DA\NFe\Danfe;
use App\Models\ItemDfe;

use App\Models\ItemCompra;


class DFeController extends Controller
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

	public function index(){

		$config = ConfigNota::first();

		if($config == null){

			session()->flash('mensagem_sucesso', 'Configure o Emitente');
			return redirect('configNF');
		}

		$certificado = Certificado::first();
		if($certificado == null){

			session()->flash('mensagem_erro', 'Configure o Certificado');
			return redirect('configNF');
		}


		$data_inicial = date('d/m/Y', strtotime("-90 day",strtotime(date("Y-m-d"))));
		$data_final = date('d/m/Y');

		$docs = ManifestaDfe::orderBy('id', 'desc')->get();
		$arrayDocs = [];
		foreach($docs as $d){
			$dIni = str_replace("/", "-", $data_inicial);
			$dFim = str_replace("/", "-", $data_final);

			$dIni = \Carbon\Carbon::parse($dIni)->format('Y-m-d');
			$dFim = \Carbon\Carbon::parse($dFim)->format('Y-m-d');
			$data_dfe = \Carbon\Carbon::parse($d->data_emissao)->format('Y-m-d');

			if(strtotime($data_dfe) >= strtotime($dIni) && strtotime($data_dfe) <= strtotime($dFim)){
				array_push($arrayDocs, $d);
			}
		}

		return view('dfe/index')
		->with('docs', $arrayDocs)
		->with('dfeJS', $arrayDocs)
		->with('data_final', $data_final)
		->with('data_inicial', $data_inicial)
		->with('title', 'DF-e');
	}

	public function filtro(Request $request){

		$tipo = $request->tipo;
		$dataInicial = $request->data_inicial;
		$dataFinal = $request->data_final;

		$config = ConfigNota::first();

		if($config == null){

			session()->flash('mensagem_sucesso', 'Configure o Emitente');
			return redirect('configNF');
		}

		$certificado = Certificado::first();
		if($certificado == null){

			session()->flash('mensagem_erro', 'Configure o Certificado');
			return redirect('configNF');
		}


		$docs = ManifestaDfe::orderBy('id', 'desc')->get();  
		$arrayDocs = [];

		foreach($docs as $d){
			$dIni = str_replace("/", "-", $dataInicial);
			$dFim = str_replace("/", "-", $dataFinal);

			$dIni = \Carbon\Carbon::parse($dIni)->format('Y-m-d');
			$dFim = \Carbon\Carbon::parse($dFim)->format('Y-m-d');
			$data_dfe = \Carbon\Carbon::parse($d->data_emissao)->format('Y-m-d');
			if($tipo != '--'){
				if(strtotime($data_dfe) >= strtotime($dIni) && strtotime($data_dfe) <= strtotime($dFim)){
					if($d->tipo == $tipo){
						array_push($arrayDocs, $d);
					}
				}
			}else{
				if(strtotime($data_dfe) >= strtotime($dIni) && strtotime($data_dfe) <= strtotime($dFim)){
					array_push($arrayDocs, $d);
				}
			}
		}

		return view('dfe/index')
		->with('docs', $arrayDocs)
		->with('dfeJS', $arrayDocs)
		->with('data_final', $dataFinal)
		->with('data_inicial', $dataInicial)
		->with('title', 'DF-e');
	}

	public function getDocumentos(Request $request){
		$config = ConfigNota::first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$data_inicial = str_replace("/", "-", $request->data_inicial);
		$data_final = str_replace("/", "-", $request->data_final);

		$dfe_service = new DFeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => 1,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_009_V4",
			"versao" => "4.00",
			"tokenIBPT" => "AAAAAAA",
			"CSC" => $config->csc,
			"CSCid" => $config->csc_id
		], 55);

		$docs = $this->validaDocsIncluidos($dfe_service->consulta(
			\Carbon\Carbon::parse($data_inicial)->format('Y-m-d'),
			\Carbon\Carbon::parse($data_final)->format('Y-m-d')
		));

		usort($docs, function ($a, $b) {
			return \Carbon\Carbon::parse($a['data_emissao'])->format('Y-m-d') <
			\Carbon\Carbon::parse($b['data_emissao'])->format('Y-m-d');
		});

		for($aux = 0; $aux < count($docs); $aux++){
			$docs[$aux]['data_emissao'] = \Carbon\Carbon::parse($docs[$aux]['data_emissao'])->format('d/m/Y H:i:s');
		}

		return response()->json($docs, 200);
	}



	private function validaDocsIncluidos($docs){
		for($aux = 0; $aux < count($docs); $aux++){
			if($docs[$aux]){
				$manifesta = ManifestaDfe::where('chave', $docs[$aux]['chave'])->first();
				if($manifesta != null){
					$docs[$aux]['incluso'] = true;
					$docs[$aux]['tipo'] = $manifesta->tipo;
				}
			}
		}
		return $docs;
	}

	public function manifestar(Request $request){

		$config = ConfigNota::first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$dfe_service = new DFeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => 1,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_009_V4",
			"versao" => "4.00",
			"tokenIBPT" => "AAAAAAA",
			"CSC" => $config->csc,
			"CSCid" => $config->csc_id
		], 55);
		$evento = $request->evento;

		$manifestaAnterior = $this->verificaAnterior($request->chave);

		if($evento == 1){
			$res = $dfe_service->manifesta($request->chave,	 
				$manifestaAnterior != null ? ($manifestaAnterior->sequencia_evento + 1) : 1);
		}else if($evento == 2){
			$res = $dfe_service->confirmacao($request->chave,	 
				$manifestaAnterior != null ? ($manifestaAnterior->sequencia_evento + 1) : 1);
		}else if($evento == 3){
			$res = $dfe_service->desconhecimento($request->chave,	 
				$manifestaAnterior != null ? ($manifestaAnterior->sequencia_evento + 1) : 1, $request->justificativa);
		}else if($evento == 4){
			$res = $dfe_service->operacaoNaoRealizada($request->chave,	 
				$manifestaAnterior != null ? ($manifestaAnterior->sequencia_evento + 1) : 1, $request->justificativa);
		}

		// echo $res['retEvento']['infEvento']['cStat'];
		if($res['retEvento']['infEvento']['cStat'] == '135'){ //sucesso
			// $manifesta = [
			// 	'chave' => $request->chave,
			// 	'nome' => $request->nome,
			// 	'documento' => $request->cnpj,
			// 	'valor' => $request->valor,
			// 	'num_prot' => $request->num_prot,
			// 	'data_emissao' => $request->data_emissao,
			// 	'sequencia_evento' => 1, 
			// 	'fatura_salva' => false,	 
			// 	'tipo' => $evento
			// ];

			$manifesto = ManifestaDfe::where('chave', $request->chave)
			->first();
			$manifesto->tipo = $evento;
			$manifesto->save();

			// ManifestaDfe::create($manifesta);
			session()->flash('mensagem_sucesso', 'XML ' . $request->chave . ' manifestado!');
			return redirect('/dfe');
		}else{

			// $manifesta = [
			// 	'chave' => $request->chave,
			// 	'nome' => $request->nome,
			// 	'documento' => $request->cnpj,
			// 	'valor' => $request->valor,
			// 	'num_prot' => $request->num_prot,
			// 	'data_emissao' => $request->data_emissao,
			// 	'sequencia_evento' => 1, 
			// 	'fatura_salva' => false,	
			// 	'tipo' => $evento 
			// ];

			$manifesto = ManifestaDfe::where('chave', $request->chave)
			->first();
			$manifesto->tipo = $evento;
			$manifesto->save();

			// ManifestaDfe::create($manifesta);

			session()->flash('mensagem_erro', 'Já esta manifestado a chave ' . $request->chave);
			return redirect('/dfe');
		}
		
	}

	private function verificaAnterior($chave){
		return ManifestaDfe::where('chave', $chave)->first();
	}

	public function download($chave){
		$config = ConfigNota::first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$dfe_service = new DFeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => 1,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_009_V4",
			"versao" => "4.00",
			"tokenIBPT" => "AAAAAAA",
			"CSC" => $config->csc,
			"CSCid" => $config->csc_id
		], 55);
		try{
			$response = $dfe_service->download($chave);
		// print_r($response);
			
			$stz = new Standardize($response);
			$std = $stz->toStd();
			if ($std->cStat != 138) {
				echo "Documento não retornado. [$std->cStat] $std->xMotivo" . ", aguarde alguns instantes e atualize a pagina!";  
				die();
			}    
			$zip = $std->loteDistDFeInt->docZip;
			$xml = gzdecode(base64_decode($zip));

			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';

			file_put_contents($public.'xml_dfe/'.$chave.'.xml',$xml);
			$nfe = simplexml_load_string($xml);
			if(!$nfe) {
				echo "Erro ao ler XML";
			}else{

				$fornecedor = $this->getFornecedorXML($nfe);
				$itens = $this->getItensDaNFe($nfe);
				$infos = $this->getInfosDaNFe($nfe);
				$fatura = $this->getFaturaDaNFe($nfe);
				// echo "<pre>";
				// print_r($fornecedor);
				// echo "</pre>";

			//caregar view

				$categorias = Categoria::all();
				$unidadesDeMedida = Produto::unidadesMedida();

				$listaCSTCSOSN = Produto::listaCSTCSOSN();
				$listaCST_PIS_COFINS = Produto::listaCST_PIS_COFINS();
				$listaCST_IPI = Produto::listaCST_IPI();
				$config = ConfigNota::first();

				$manifesto = ManifestaDfe::where('chave', $chave)->first();

				$compra = Compra::
				where('chave', $chave)
				->first();

				$dfe = ManifestaDfe::where('chave', $chave)->first();

				$compraAdicionada = Compra::
				where('dfe_id', $manifesto->id)
				->exists();

				return view('dfe/view')
				->with('fornecedor', $fornecedor)
				->with('itens', $itens)
				->with('dfe', $dfe)
				->with('infos', $infos)
				->with('dfeJS', true)
				->with('compraAdicionada', $compraAdicionada)
				->with('compraFiscal', $compra != null ? true : false)
				->with('fatura', $fatura)
				->with('listaCSTCSOSN', $listaCSTCSOSN)
				->with('listaCST_PIS_COFINS', $listaCST_PIS_COFINS)
				->with('listaCST_IPI', $listaCST_IPI)
				->with('categorias', $categorias)
				->with('config', $config)
				->with('fatura_salva', $manifesto == null ? false : $manifesto->fatura_salva)
				->with('unidadesDeMedida', $unidadesDeMedida)
				->with('title', 'Visualizando XML');
			}
		}catch(\Exception $e){
			echo "Erro de soap:<br>";
			echo $e->getMessage();
		}

	}

	public function imprimirDanfe($chave){
		$config = ConfigNota::first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$dfe_service = new DFeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => 1,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_009_V4",
			"versao" => "4.00",
			"tokenIBPT" => "AAAAAAA",
			"CSC" => $config->csc,
			"CSCid" => $config->csc_id
		], 55);

		$response = $dfe_service->download($chave);
		// print_r($response);
		try {
			$stz = new Standardize($response);
			$std = $stz->toStd();
			if ($std->cStat != 138) {
				echo "Documento não retornado. [$std->cStat] $std->xMotivo" . ", aguarde alguns instantes e atualize a pagina!";  
				die;
			}    
			$zip = $std->loteDistDFeInt->docZip;
			$xml = gzdecode(base64_decode($zip));
			
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';

			file_put_contents($public.'xml_dfe/'.$chave.'.xml',$xml);

			
			$danfe = new Danfe($xml);
			// $id = $danfe->monta();
			$pdf = $danfe->render();
			header('Content-Type: application/pdf');
			echo $pdf;
		} catch (InvalidArgumentException $e) {
			echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
		}  
		

	}

	private function getFornecedorXML($xml){

		$cidade = Cidade::getCidadeCod($xml->NFe->infNFe->emit->enderEmit->cMun);
		$fornecedor = [
			'cpf' => $xml->NFe->infNFe->emit->CPF,
			'cnpj' => $xml->NFe->infNFe->emit->CNPJ,  				
			'razaoSocial' => $xml->NFe->infNFe->emit->xNome, 				
			'nomeFantasia' => $xml->NFe->infNFe->emit->xFant ?? $xml->NFe->infNFe->emit->xNome,
			'logradouro' => $xml->NFe->infNFe->emit->enderEmit->xLgr,
			'numero' => $xml->NFe->infNFe->emit->enderEmit->nro,
			'bairro' => $xml->NFe->infNFe->emit->enderEmit->xBairro,
			'cep' => $xml->NFe->infNFe->emit->enderEmit->CEP,
			'fone' => $xml->NFe->infNFe->emit->enderEmit->fone,
			'ie' => $xml->NFe->infNFe->emit->IE,
			'cidade_id' => $cidade->id
		];

		$fornecedorEncontrado = $this->verificaFornecedor($xml->NFe->infNFe->emit->CNPJ);
		if($fornecedorEncontrado){
			$fornecedor['objeto'] = $fornecedorEncontrado;
			$fornecedor['novo_cadastrado'] = false;
		}else{
			$fornecedor['novo_cadastrado'] = true;
			$idFornecedor = $this->cadastrarFornecedor($fornecedor);
			$fornecedor['objeto'] = Fornecedor::find($idFornecedor);
		}

		return $fornecedor;
	}

	private function getItensDaNFe($xml){
		$itens = [];
		foreach($xml->NFe->infNFe->det as $item) {

			$produto = Produto::verificaCadastrado($item->prod->cEAN,
				$item->prod->xProd, $item->prod->cProd);

			$produtoNovo = !$produto ? true : false;

			$tp = null;
			if($produto != null){
				$tp = ItemDfe::
				where('produto_id', $produto->id)
				->where('numero_nfe', $xml->NFe->infNFe->ide->nNF)
				->first();

			}

			$item = [
				'codigo' => $item->prod->cProd,
				'xProd' => $item->prod->xProd,
				'NCM' => $item->prod->NCM,
				'CFOP' => $item->prod->CFOP,
				'uCom' => $item->prod->uCom,
				'vUnCom' => $item->prod->vUnCom,
				'qCom' => $item->prod->qCom,
				'codBarras' => $item->prod->cEAN,
				'produtoNovo' => $produtoNovo,
				'produto_id' => $produtoNovo ? null : $produto->id,
				'produtoSetadoEstoque' => $tp != null ? true : false,
				'produtoId' => $produtoNovo ? '0' : $produto->id,
				'conversao_unitaria' => $produtoNovo ? '' : $produto->conversao_unitaria
			];
			array_push($itens, $item);
		}

		return $itens;
	}

	private function getInfosDaNFe($xml){
		$chave = substr($xml->NFe->infNFe->attributes()->Id, 3, 44);
		$vFrete = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vFrete, 
			2, ",", ".");
		$vDesc = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vDesc, 2, ",", ".");
		return [
			'chave' => $chave,
			'vProd' => $xml->NFe->infNFe->total->ICMSTot->vProd,
			'indPag' => $xml->NFe->infNFe->ide->indPag,
			'nNf' => $xml->NFe->infNFe->ide->nNF,
			'vFrete' => $vFrete,
			'vDesc' => $vDesc
		];
	}

	private function getFaturaDaNFe($xml){
		if (!empty($xml->NFe->infNFe->cobr->dup))
		{	
			$fatura = [];
			$cont = 1;
			foreach($xml->NFe->infNFe->cobr->dup as $dup) {
				$titulo = $dup->nDup;
				$vencimento = $dup->dVenc;
				$vencimento = explode('-', $vencimento);
				$vencimento = $vencimento[2]."/".$vencimento[1]."/".$vencimento[0];
				$vlr_parcela = (double)$dup->vDup;	

				$parcela = [
					'numero' => $titulo,
					'vencimento' => $vencimento,
					'valor_parcela' => $vlr_parcela,
					'referencia' => $xml->NFe->infNFe->ide->nNF . "/" . $cont
				];
				array_push($fatura, $parcela);
				$cont++;
			}
			return $fatura;
		}
		return [];
	}


	private function verificaFornecedor($cnpj){
		$forn = Fornecedor::verificaCadastrado($this->formataCnpj($cnpj));
		return $forn;
	}

	private function cadastrarFornecedor($fornecedor){
		
		$result = Fornecedor::create([
			'razao_social' => $fornecedor['razaoSocial'],
			'nome_fantasia' => $fornecedor['nomeFantasia'],
			'rua' => $fornecedor['logradouro'],
			'numero' => $fornecedor['numero'],
			'bairro' => $fornecedor['bairro'],
			'cep' => $this->formataCep($fornecedor['cep']),
			'cpf_cnpj' => $this->formataCnpj($fornecedor['cnpj']),
			'ie_rg' => $fornecedor['ie'],
			'celular' => '*',
			'telefone' => $this->formataTelefone($fornecedor['fone']),
			'email' => '*',
			'cidade_id' => $fornecedor['cidade_id']
		]);
		return $result->id;
	}

	private function formataCnpj($cnpj){
		$temp = substr($cnpj, 0, 2);
		$temp .= ".".substr($cnpj, 2, 3);
		$temp .= ".".substr($cnpj, 5, 3);
		$temp .= "/".substr($cnpj, 8, 4);
		$temp .= "-".substr($cnpj, 12, 2);
		return $temp;
	}

	private function formataCep($cep){
		$temp = substr($cep, 0, 5);
		$temp .= "-".substr($cep, 5, 3);
		return $temp;
	}

	private function formataTelefone($fone){
		$temp = substr($fone, 0, 2);
		$temp .= " ".substr($fone, 2, 4);
		$temp .= "-".substr($fone, 4, 4);
		return $temp;
	}

	public function salvarFatura(Request $request){
		$chave =  $request->chave;

		$manifesto = ManifestaDfe::where('chave', $chave)->first();
		$manifesto->fatura_salva = true;
		$manifesto->save();

		$fatura = json_decode($request->fatura);
		foreach($fatura as $fat){

			$conta = [
				'compra_id' => NULL,
				'data_vencimento' => \Carbon\Carbon::parse(str_replace("/", "-", $fat->vencimento))->format('Y-m-d'),
				'data_pagamento' => \Carbon\Carbon::parse(str_replace("/", "-", $fat->vencimento))->format('Y-m-d'),
				'valor_integral' => str_replace(",", ".", $fat->valor_parcela),
				'valor_pago' => 0,
				'referencia' => $fat->referencia,
				'categoria_id' => 1,
				'status' => false
			];

			ContaPagar::create($conta);
		}


		session()->flash('mensagem_sucesso', 'Fatura salva!');
		return redirect('/dfe/download/'.$chave);
	}

	public function novaConsulta(){
		return view('dfe/nova_consulta')
		->with('dfeJS', true)
		->with('title', 'Nova Consulta');
	}

	public function getDocumentosNovos(){
		try{
			$config = ConfigNota::first();

			$cnpj = str_replace(".", "", $config->cnpj);
			$cnpj = str_replace("/", "", $cnpj);
			$cnpj = str_replace("-", "", $cnpj);
			$cnpj = str_replace(" ", "", $cnpj);


			$dfe_service = new DFeService([
				"atualizacao" => date('Y-m-d h:i:s'),
				"tpAmb" => 1,
				"razaosocial" => $config->razao_social,
				"siglaUF" => $config->UF,
				"cnpj" => $cnpj,
				"schemes" => "PL_009_V4",
				"versao" => "4.00",
				"tokenIBPT" => "AAAAAAA",
				"CSC" => $config->csc,
				"CSCid" => $config->csc_id
			], 55);

			$manifesto = ManifestaDfe::orderBy('nsu', 'desc')->first();
			if($manifesto == null) $nsu = 0;
			else $nsu = $manifesto->nsu;
			$docs = $dfe_service->novaConsulta($nsu);
			$novos = [];
			foreach($docs as $d) {
				if($this->validaNaoInserido($d['chave'])){
					if($d['valor'] > 0 && $d['nome']){
						ManifestaDfe::create($d);
						array_push($novos, $d);
					}
				}
			}
			return response()->json($novos, 200);

		}catch(Exception $e){
			return response()->json($e->getMessage(), 403);
		}

	}

	private function validaNaoInserido($chave){
		$m = ManifestaDfe::where('chave', $chave)->first();
		if($m == null) return true;
		else return false;
	}

	public function downloadXml($chave){
		$dfe = ManifestaDfe::where('chave', $chave)->first();
		$chave = $dfe->chave; 
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		if(file_exists($public.'xml_dfe/'.$chave.'.xml'))
			return response()->download($public.'xml_dfe/'.$chave.'.xml');
		else echo "Erro ao baixar XML, arquivo não encontrado!";
	}

	public function salvarCompra(Request $request){
		$fornecedor = $request->fornecedor;
		$itens = $request->itens;
		$fatura = $request->fatura;
		$dfe_id = $request->dfe_id;

		try{
			$dfe = ManifestaDfe::find($dfe_id);

			$data = [
				'fornecedor_id' => $fornecedor['id'],
				'usuario_id' => get_id_user(),
				'nf' => 0,
				'observacao' => '',
				'valor' => $dfe->valor,
				'desconto' => 0,
				'xml_path' => '',
				'estado' => 'NOVO',
				'numero_emissao' => 0,
				'chave' => $dfe->chave,
				'dfe_id' => $dfe->id
			];

			$resCompra = Compra::create($data);

			foreach($itens as $i){
				$dataItem = [
					'compra_id' => $resCompra->id,
					'produto_id' => $i['produtoId'],
					'quantidade' =>  str_replace(",", ".", $i['qCom'][0]),
					'valor_unitario' => str_replace(",", ".", $i['vUnCom'][0]),
					'unidade_compra' => $i['uCom'][0],
					'cfop_entrada' => $i['CFOP'][0],
					'codigo_siad' => ''
				];

				$itemRes = ItemCompra::create($dataItem);
			}

			if($fatura){
				foreach($fatura  as $f){
					$dataConta = [
						'compra_id' => NULL,
						'data_vencimento' => \Carbon\Carbon::
						parse(str_replace("/", "-", $f['vencimento']))->format('Y-m-d'),
						'data_pagamento' => \Carbon\Carbon::
						parse(str_replace("/", "-", $f['vencimento']))->format('Y-m-d'),
						'valor_integral' => str_replace(",", ".", $f['valor_parcela']),
						'valor_pago' => 0,
						'referencia' => $f['referencia'],
						'categoria_id' => 1,
						'status' => false
					];

					ContaPagar::create($dataConta);
				}
			}

			return response()->json("ok", 200);
		}catch(\Exception $e){
			return response()->json("Erro: " . $e->getMessage(), 401);
		}

	}

	public function get($id){

		$dfe = ManifestaDfe::find($id);

		return redirect('/dfe/download/'.$dfe->chave);
	}
}
