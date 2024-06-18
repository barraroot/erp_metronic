<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/'], function(){
	Route::get('/', 'DeliveryController@index');
	Route::get('/filtroProduto', 'DeliveryController@filtroProduto');
});

Route::get('/rotaEntrega/{id}', 'DeliveryController@rotaEntrega');

Route::group(['prefix' => '/pagseguro'], function(){
	Route::get('/getSessao', 'PagSeguroController@getSessao');
	Route::post('/efetuaPagamento', 'PagSeguroController@efetuaPagamento');
	Route::get('/consultaJS', 'PagSeguroController@consultaJS');
	Route::get('/getFuncionamento', 'PagSeguroController@getFuncionamento');
});

Route::group(['prefix' => '/dfe'], function(){
	Route::get('/', 'DFeController@index');
	Route::get('/get/{id}', 'DFeController@get');
	Route::get('/getDocumentos', 'DFeController@getDocumentos');
	Route::get('/manifestar', 'DFeController@manifestar');
	Route::get('/download/{chave}', 'DFeController@download');
	Route::get('/imprimirDanfe/{chave}', 'DFeController@imprimirDanfe');
	Route::get('/downloadXml/{chave}', 'DFeController@downloadXml');
	Route::get('/salvarFatura', 'DFeController@salvarFatura');
	Route::get('/novaConsulta', 'DFeController@novaConsulta');
	Route::get('/getDocumentosNovos', 'DFeController@getDocumentosNovos');
	Route::get('/filtro', 'DFeController@filtro');

	Route::post('/salvarCompra', 'DFeController@salvarCompra');

});

Route::group(['prefix' => '/ibpt'], function(){
	Route::get('/', 'IbptController@index');
	Route::get('/new', 'IbptController@new');
	Route::post('/new', 'IbptController@importar');
	Route::get('/refresh/{id}', 'IbptController@refresh');
	Route::get('/ver/{id}', 'IbptController@ver');
});

Route::group(['prefix' => '/dre'], function(){
	Route::get('/', 'DreController@index');
	Route::get('/list', 'DreController@list');
	Route::get('/ver/{id}', 'DreController@ver');
	Route::get('/deleteLancamento/{id}', 'DreController@deleteLancamento');
	Route::get('/imprimir/{id}', 'DreController@imprimir');
	Route::post('/save', 'DreController@save');
	Route::post('/novolancamento', 'DreController@novolancamento');
	Route::post('/updatelancamento', 'DreController@updatelancamento');

	Route::get('/delete/{id}', 'DreController@delete');

});

Route::group(['prefix' => '/relatorios'], function(){
	Route::get('/', 'RelatorioController@index');
	Route::get('/filtroVendas', 'RelatorioController@filtroVendas');
	Route::get('/filtroCompras', 'RelatorioController@filtroCompras');
	Route::get('/filtroVendaProdutos', 'RelatorioController@filtroVendaProdutos');
	Route::get('/filtroVendaClientes', 'RelatorioController@filtroVendaClientes');
	Route::get('/filtroEstoqueMinimo', 'RelatorioController@filtroEstoqueMinimo');
	Route::get('/filtroVendaDiaria', 'RelatorioController@filtroVendaDiaria');
	Route::get('/cobrancaPendente', 'RelatorioController@cobrancaPendente');

	Route::get('/filtroLucro', 'RelatorioController@filtroLucro');
	Route::get('/estoqueProduto', 'RelatorioController@estoqueProduto');
	Route::get('/relatorioAtendimento', 'RelatorioController@relatorioAtendimento');
});

Route::group(['prefix' => '/autenticar'], function(){
	Route::get('/', 'DeliveryController@login');
	Route::post('/', 'DeliveryController@autenticar');
	Route::get('/registro', 'DeliveryController@registro');
	Route::get('/logoff', 'DeliveryController@logoff');
	Route::get('/novo', 'DeliveryController@autenticarCliente');
	Route::post('/registro', 'DeliveryController@salvarRegistro');
	Route::get('/esqueceu_a_senha', 'DeliveryController@recuperarSenha');
	Route::post('/esqueceu_a_senha', 'DeliveryController@enviarSenha');
	Route::post('/validaToken', 'DeliveryController@validaToken');
	Route::get('/ativar/{cliente_id}', 'DeliveryController@ativar');
	Route::post('/refreshToken', 'DeliveryController@refreshToken');
	Route::get('/saveTokenWeb', 'DeliveryController@saveTokenWeb');
	Route::get('/cliente/{cod}', 'DeliveryController@autenticarClienteEmail');

});

Route::group(['prefix' => '/cardapio'], function(){
	Route::get('/', 'DeliveryController@cardapio');
	Route::get('/{id}', 'DeliveryController@produtos');
	Route::get('/acompanhamento/{id}', 'DeliveryController@acompanhamento');
	Route::get('/verProduto/{id}', 'DeliveryController@verProduto');

});

Route::group(['prefix' => '/agendamentos'], function(){
	Route::get('/', 'AgendamentoController@index');
	Route::get('/all', 'AgendamentoController@all');
	Route::get('/filtro', 'AgendamentoController@filtro');
	Route::post('/saveCliente', 'AgendamentoController@saveCliente');
	Route::post('/save', 'AgendamentoController@save');
	Route::get('/detalhes/{id}', 'AgendamentoController@detalhes');
	Route::get('/delete/{id}', 'AgendamentoController@delete');
	Route::get('/alterarStatus/{id}', 'AgendamentoController@alterarStatus');
	Route::get('/irParaFrenteCaixa/{id}', 'AgendamentoController@irParaFrenteCaixa');


	Route::get('/comissao', 'AgendamentoController@comissao');
	Route::get('/filtrarComissao', 'AgendamentoController@filtrarComissao');

	Route::get('/servicos', 'AgendamentoController@servicos');
	Route::get('/filtrarServicos', 'AgendamentoController@filtrarServicos');

});

Route::group(['prefix' => '/pizza'], function(){
	Route::get('/escolherSabores', 'DeliveryController@escolherSabores');
	Route::post('/adicionarSabor', 'DeliveryController@adicionarSabor');
	Route::get('/verificaPizzaAdicionada', 'DeliveryController@verificaPizzaAdicionada');
	Route::get('/removeSabor/{id}', 'DeliveryController@removeSabor');
	Route::get('/adicionais', 'DeliveryController@adicionais');
	Route::get('/pesquisa', 'DeliveryController@pesquisa');
	Route::get('/pizzas', 'DeliveryController@pizzas');
});

Route::group(['prefix' => '/info'], function(){
	Route::get('/', 'DeliveryController@infos');
	Route::get('/alterarEndereco/{id}', 'DeliveryController@alterarEndereco');
	Route::post('/atualizarSenha', 'DeliveryController@atualizarSenha');
	Route::post('/updateEndereco', 'DeliveryController@updateEndereco');
	
});

Route::group(['prefix' => 'divisaoGrade'],function(){
	Route::get('/', 'DivisaoGradeController@index');
	Route::get('/delete/{id}', 'DivisaoGradeController@delete');
	Route::get('/edit/{id}', 'DivisaoGradeController@edit');
	Route::get('/new', 'DivisaoGradeController@new');

	Route::post('/save', 'DivisaoGradeController@save');
	Route::post('/update', 'DivisaoGradeController@update');
});

Route::group(['prefix' => '/carrinho'], function(){
	Route::get('/', 'CarrinhoController@carrinho');
	Route::post('/add', 'CarrinhoController@add');
	Route::post('/addPizza', 'CarrinhoController@addPizza');
	Route::get('/removeItem/{id}', 'CarrinhoController@removeItem');
	Route::get('/refreshItem/{id}/{quantidade}', 'CarrinhoController@refreshItem');
	Route::get('/forma_pagamento/{cupom?}', 'CarrinhoController@forma_pagamento');
	Route::post('/finalizarPedido', 'CarrinhoController@finalizarPedido');
	Route::get('/historico', 'CarrinhoController@historico');
	Route::get('/pedir_novamente/{id}', 'CarrinhoController@pedir_novamente');
	Route::get('/finalizado/{id}', 'CarrinhoController@finalizado');
	Route::get('/configDelivery', 'CarrinhoController@configDelivery');
	Route::get('/cupons', 'CarrinhoController@cupons');
	Route::get('/getDadosCalculoEntrega', 'CarrinhoController@getDadosCalculoEntrega');
	Route::get('/cupom/{codigo}', 'CarrinhoController@cupom');
});

Route::group(['prefix' => '/enderecoDelivery'], function(){
	// Route::get('/{id}', 'EnderecoDeliveryController@index');
	Route::post('/save', 'EnderecoDeliveryController@save');
	Route::get('/', 'EnderecoDeliveryController@get');
	Route::get('/getValorBairro', 'EnderecoDeliveryController@getValorBairro');
});

Route::group(['prefix' => '/pedidosDelivery'], function(){
	Route::get('/', 'PedidoDeliveryController@today');
	Route::get('/verPedido/{id}', 'PedidoDeliveryController@verPedido');
	Route::get('/filtro', 'PedidoDeliveryController@filtro');
	Route::get('/alterarStatus/{id}', 'PedidoDeliveryController@alterarStatus');
	Route::get('/irParaFrenteCaixa/{id}', 'PedidoDeliveryController@irParaFrenteCaixa');
	Route::get('/alterarPedido', 'PedidoDeliveryController@alterarPedido');
	Route::get('/confirmarAlteracao', 'PedidoDeliveryController@confirmarAlteracao');
	Route::get('/print/{id}', 'PedidoDeliveryController@print');
	Route::get('/verCarrinhos', 'PedidoDeliveryController@verCarrinhos');
	Route::get('/verCarrinho/{id}', 'PedidoDeliveryController@verCarrinho');
	Route::get('/push/{id}', 'PedidoDeliveryController@push');
	Route::get('/emAberto', 'PedidoDeliveryController@emAberto');
	Route::post('/sendPush', 'PedidoDeliveryController@sendPush');
	Route::post('/sendPushWeb', 'PedidoDeliveryController@sendPushWeb');
	Route::post('/sendSms', 'PedidoDeliveryController@sendSms');

	//para frente de pedido
	Route::get('/frente', 'PedidoDeliveryController@frente');
	Route::get('/frenteComPedido/{id}', 'PedidoDeliveryController@frenteComPedido');
	Route::get('/clientes', 'PedidoDeliveryController@clientes');
	Route::post('/abrirPedidoCaixa', 'PedidoDeliveryController@abrirPedidoCaixa');
	Route::post('/novoClienteDeliveryCaixa', 'PedidoDeliveryController@novoClienteDeliveryCaixa');
	Route::post('/novoEnderecoClienteCaixa', 'PedidoDeliveryController@novoEnderecoClienteCaixa');
	Route::post('/setEnderecoCaixa', 'PedidoDeliveryController@setEnderecoCaixa');
	Route::post('/getEnderecoCaixa/{cliente_id}', 'PedidoDeliveryController@getEnderecoCaixa');
	Route::post('/saveItemCaixa', 'PedidoDeliveryController@saveItemCaixa');
	Route::get('/produtos', 'PedidoDeliveryController@produtos');
	Route::get('/deleteItem/{id}', 'PedidoDeliveryController@deleteItem');
	Route::get('/getProdutoDelivery/{id}', 'PedidoDeliveryController@getProdutoDelivery');
	Route::get('/frenteComPedidoFinalizar', 'PedidoDeliveryController@frenteComPedidoFinalizar');
	Route::get('/removerCarrinho/{id}', 'PedidoDeliveryController@removerCarrinho');

	Route::get('/mapa', 'PedidoDeliveryController@mapa');

	
});


Route::group(['prefix' => '/configDelivery'], function(){
	Route::get('/', 'ConfigDeliveryController@index');
	Route::post('/save', 'ConfigDeliveryController@save');
});

Route::group(['prefix' => '/configMercado'], function(){
	Route::get('/', 'MercadoConfigController@index');
	Route::post('/save', 'MercadoConfigController@save');
});

Route::group(['prefix' => 'deliveryCategoria'], function(){
	Route::get('/', 'DeliveryConfigCategoriaController@index');
	Route::get('/delete/{id}', 'DeliveryConfigCategoriaController@delete');
	Route::get('/edit/{id}', 'DeliveryConfigCategoriaController@edit');
	Route::get('/additional/{id}', 'DeliveryConfigCategoriaController@additional');
	Route::get('/removeAditional/{id}', 'DeliveryConfigCategoriaController@removeAditional');
	Route::post('/saveAditional', 'DeliveryConfigCategoriaController@saveAditional');
	Route::get('/new', 'DeliveryConfigCategoriaController@new');

	Route::post('/request', 'DeliveryConfigCategoriaController@request');
	Route::post('/save', 'DeliveryConfigCategoriaController@save');
	Route::post('/update', 'DeliveryConfigCategoriaController@update');
});

Route::group(['prefix' => 'deliveryComplemento'], function(){
	Route::get('/', 'DeliveryComplementoController@index');
	Route::get('/delete/{id}', 'DeliveryComplementoController@delete');
	Route::get('/edit/{id}', 'DeliveryComplementoController@edit');
	Route::get('/new', 'DeliveryComplementoController@new');
	Route::get('/all', 'DeliveryComplementoController@all');
	Route::get('/allPedidoLocal', 'DeliveryComplementoController@allPedidoLocal');

	Route::post('/request', 'DeliveryComplementoController@request');
	Route::post('/save', 'DeliveryComplementoController@save');
	Route::post('/update', 'DeliveryComplementoController@update');
});

Route::group(['prefix' => 'categoriasAdicional'],function(){
	Route::get('/', 'CategoriaAdicionalController@index');
	Route::get('/delete/{id}', 'CategoriaAdicionalController@delete');
	Route::get('/edit/{id}', 'CategoriaAdicionalController@edit');
	Route::get('/new', 'CategoriaAdicionalController@new');

	Route::post('/save', 'CategoriaAdicionalController@save');
	Route::post('/update', 'CategoriaAdicionalController@update');
});

Route::group(['prefix' => 'deliveryProduto'], function(){
	Route::get('/', 'DeliveryConfigProdutoController@index');
	Route::get('/delete/{id}', 'DeliveryConfigProdutoController@delete');
	Route::get('/deleteImagem/{id}', 'DeliveryConfigProdutoController@deleteImagem');
	Route::get('/edit/{id}', 'DeliveryConfigProdutoController@edit');
	Route::get('/galeria/{id}', 'DeliveryConfigProdutoController@galeria');
	Route::get('/push/{id}', 'DeliveryConfigProdutoController@push');
	Route::get('/new', 'DeliveryConfigProdutoController@new');

	Route::get('/alterarDestaque/{id}', 'DeliveryConfigProdutoController@alterarDestaque');
	Route::get('/alterarStatus/{id}', 'DeliveryConfigProdutoController@alterarStatus');

	Route::post('/request', 'DeliveryConfigProdutoController@request');
	Route::post('/save', 'DeliveryConfigProdutoController@save');
	Route::post('/saveImagem', 'DeliveryConfigProdutoController@saveImagem');
	Route::post('/update', 'DeliveryConfigProdutoController@update');
	Route::get('/pesquisa', 'DeliveryConfigProdutoController@pesquisa');

	Route::get('/adicionais/{produto_id}', 'DeliveryComplementoController@adicionais');
	Route::post('/saveAdicionais', 'DeliveryComplementoController@saveAdicionais');
	
});


Route::group(['prefix' => 'configNF'], function(){
	Route::get('/', 'ConfigNotaController@index');
	Route::post('/save', 'ConfigNotaController@save');
	Route::get('/certificado', 'ConfigNotaController@certificado');
	Route::get('/download', 'ConfigNotaController@download');
	Route::get('/senha', 'ConfigNotaController@senha');
	Route::post('/certificado', 'ConfigNotaController@saveCertificado');
	Route::get('/teste', 'ConfigNotaController@teste');
	Route::get('/testeEmail', 'ConfigNotaController@testeEmail');
	Route::get('/deleteCertificado', 'ConfigNotaController@deleteCertificado');

});

Route::group(['prefix' => 'escritorio'], function(){
	Route::get('/', 'EscritorioController@index');
	Route::post('/save', 'EscritorioController@save');
});

Route::group(['prefix' => 'aberturaCaixa'], function(){
	Route::get('/verificaHoje', 'AberturaCaixaController@verificaHoje');
	Route::post('/abrir', 'AberturaCaixaController@abrir');
	Route::get('/diaria', 'AberturaCaixaController@diaria');
});

Route::get('/app', 'PedidoRestController@apk');


Route::group(['prefix' => 'pedidos'], function(){
	Route::get('/', 'PedidoController@index');
	Route::post('/abrir', 'PedidoController@abrir');
	Route::get('/ver/{id}', 'PedidoController@ver');
	Route::get('/deleteItem/{id}', 'PedidoController@deleteItem');
	Route::get('/desativar/{id}', 'PedidoController@desativar');
	Route::get('/alterarStatus/{id}', 'PedidoController@alterarStatus');
	Route::get('/finalizar/{id}', 'PedidoController@finalizar');
	Route::get('/itensPendentes', 'PedidoController@itensPendentes');
	Route::post('/saveItem', 'PedidoController@saveItem');

	Route::get('/emAberto', 'PedidoController@emAberto');
	Route::post('/sms', 'PedidoController@sms');
	Route::get('/imprimirPedido/{id}', 'PedidoController@imprimirPedido');
	Route::get('/itensParaFrenteCaixa', 'PedidoController@itensParaFrenteCaixa');
	Route::get('/itensParaFrenteCaixa2', 'PedidoController@itensParaFrenteCaixa2');
	Route::get('/setarEndereco', 'PedidoController@setarEndereco');
	Route::get('/setarBairro', 'PedidoController@setarBairro');
	Route::get('/imprimirItens', 'PedidoController@imprimirItens');
	Route::get('/controleComandas', 'PedidoController@controleComandas');
	Route::get('/verDetalhes/{id}', 'PedidoController@verDetalhes');
	Route::get('/filtroComanda', 'PedidoController@filtroComanda');

	Route::get('/mesas', 'PedidoController@mesas');
	Route::get('/verMesa/{mesa_id}', 'PedidoController@verMesa');
	Route::get('/ativarMesa/{mesa_id}', 'PedidoController@ativarMesa');
	Route::post('/atribuirComanda', 'PedidoController@atribuirComanda');
	Route::post('/atribuirMesa', 'PedidoController@atribuirMesa');


});

Route::group(['prefix' => 'sangriaCaixa'], function(){
	Route::post('/save', 'SangriaCaixaController@save');
	Route::get('/diaria', 'SangriaCaixaController@diaria');
});

Route::group(['prefix' => 'suprimentoCaixa'], function(){
	Route::post('/save', 'SuprimentoCaixaController@save');
	Route::get('/diaria', 'SuprimentoCaixaController@diaria');
});

Route::group(['prefix' => 'cidades'], function(){
	Route::get('/all', 'CidadeController@all');
	Route::get('/find/{id}', 'CidadeController@find');
	Route::get('/findNome/{nome}', 'CidadeController@findNome');
});

Route::group(['prefix' => 'login'],function(){
	Route::get('/', 'UserController@newAccess');
	Route::get('/logoff', 'UserController@logoff');
	Route::post('/request', 'UserController@request')->middleware('control');
});

Route::group(['prefix' => 'usuarios'],function(){
	Route::get('/', 'UsuarioController@lista');
	Route::get('/new', 'UsuarioController@new');
	Route::get('/edit/{id}', 'UsuarioController@edit');
	Route::get('/delete/{id}', 'UsuarioController@delete');
	Route::post('/save', 'UsuarioController@save');
	Route::get('/setTema', 'UsuarioController@setTema');
	Route::post('/update', 'UsuarioController@update');
});
Route::get('/401', function(){
	return view('401');
});
Route::get('/402', function(){
	return view('402');
});


Route::get('/sempermissao', function(){
	return view('sempermissao')->with('title', 'Acesso Bloqueado');
});

Route::group(['prefix' => 'categorias'],function(){
	Route::get('/', 'CategoryController@index');
	Route::get('/delete/{id}', 'CategoryController@delete');
	Route::get('/edit/{id}', 'CategoryController@edit');
	Route::get('/new', 'CategoryController@new');

	Route::post('/request', 'CategoryController@request');
	Route::post('/save', 'CategoryController@save');
	Route::post('/update', 'CategoryController@update');
});

Route::group(['prefix' => 'naturezaOperacao'],function(){
	Route::get('/', 'NaturezaOperacaoController@index');
	Route::get('/delete/{id}', 'NaturezaOperacaoController@delete');
	Route::get('/edit/{id}', 'NaturezaOperacaoController@edit');
	Route::get('/new', 'NaturezaOperacaoController@new');

	Route::post('/request', 'NaturezaOperacaoController@request');
	Route::post('/save', 'NaturezaOperacaoController@save');
	Route::post('/update', 'NaturezaOperacaoController@update');
});

Route::group(['prefix' => 'categoriasServico'],function(){
	Route::get('/', 'CategoriaServicoController@index');
	Route::get('/delete/{id}', 'CategoriaServicoController@delete');
	Route::get('/edit/{id}', 'CategoriaServicoController@edit');
	Route::get('/new', 'CategoriaServicoController@new');

	Route::post('/request', 'CategoriaServicoController@request');
	Route::post('/save', 'CategoriaServicoController@save');
	Route::post('/update', 'CategoriaServicoController@update');
	Route::post('/update', 'CategoriaServicoController@update');
});

Route::group(['prefix' => 'categoriasConta'],function(){
	Route::get('/', 'CategoriaContaController@index');
	Route::get('/delete/{id}', 'CategoriaContaController@delete');
	Route::get('/edit/{id}', 'CategoriaContaController@edit');
	Route::get('/new', 'CategoriaContaController@new');

	Route::post('/request', 'CategoriaContaController@request');
	Route::post('/save', 'CategoriaContaController@save');
	Route::post('/update', 'CategoriaContaController@update');
});


Route::group(['prefix' => 'contasPagar'],function(){
	Route::post('/salvarParcela', 'ContasPagarController@salvarParcela');
	Route::get('/', 'ContasPagarController@index');
	Route::get('/filtro', 'ContasPagarController@filtro');
	Route::get('/new', 'ContasPagarController@new');
	Route::get('/edit/{id}', 'ContasPagarController@edit');
	Route::get('/delete/{id}', 'ContasPagarController@delete');
	Route::get('/pagar/{id}', 'ContasPagarController@pagar');

	Route::post('/save', 'ContasPagarController@save');
	Route::post('/update', 'ContasPagarController@update');
	Route::post('/pagar', 'ContasPagarController@pagarConta');
});

Route::group(['prefix' => 'contasReceber'],function(){
	Route::post('/salvarParcela', 'ContaReceberController@salvarParcela');
	Route::get('/', 'ContaReceberController@index');
	Route::get('/filtro', 'ContaReceberController@filtro');
	Route::get('/new', 'ContaReceberController@new');
	Route::get('/edit/{id}', 'ContaReceberController@edit');
	Route::get('/delete/{id}', 'ContaReceberController@delete');
	Route::get('/receber/{id}', 'ContaReceberController@receber');

	Route::post('/save', 'ContaReceberController@save');
	Route::post('/update', 'ContaReceberController@update');
	Route::post('/receber', 'ContaReceberController@receberConta');


	Route::post('/receberSomente', 'ContaReceberController@receberSomente');
	Route::post('/receberComDivergencia', 'ContaReceberController@receberComDivergencia');
	Route::post('/receberComOutros', 'ContaReceberController@receberComOutros');
	

});


Route::group(['prefix' => 'produtos'],function(){
	Route::get('/', 'ProductController@index');
	Route::get('/delete/{id}', 'ProductController@delete');
	Route::get('/edit/{id}', 'ProductController@edit');
	Route::get('/editGrade/{id}', 'ProductController@editGrade');
	Route::get('/new', 'ProductController@new');
	Route::get('/all', 'ProductController@all');
	Route::get('/composto', 'ProductController@composto');
	Route::get('/naoComposto', 'ProductController@naoComposto');
	Route::get('/getProduto/{id}', 'ProductController@getProduto');
	Route::get('/getProdutoBalanca/{id}', 'ProductController@getProdutoBalanca');

	Route::get('/getProdutoVenda/{id}/{lista_id}', 'ProductController@getProdutoVenda');

	Route::get('/getProdutoCodBarras/{id}', 'ProductController@getProdutoCodBarras');
	Route::get('/receita/{id}', 'ProductController@receita');
	Route::get('/pesquisa', 'ProductController@pesquisa');
	Route::get('/filtroCategoria', 'ProductController@filtroCategoria');
	Route::get('/getUnidadesMedida', 'ProductController@getUnidadesMedida');

	Route::post('/request', 'ProductController@request');
	Route::post('/save', 'ProductController@save');
	Route::post('/update', 'ProductController@update');
	Route::post('/getValue', 'ProductController@getValue');
	Route::post('/salvarProdutoDaNota', 'ProductController@salvarProdutoDaNota');
	Route::post('/salvarProdutoDaNotaComEstoque', 'ProductController@salvarProdutoDaNotaComEstoque');
	Route::post('/setEstoque', 'ProductController@setEstoque');

	Route::get('/relatorio_compra/{id}', 'ProductController@relatorioCompra');
	Route::post('/atualizarGradeCompleta', 'ProductController@atualizarGradeCompleta');
	Route::get('/grade/{id}', 'ProductController@grade');
});


Route::group(['prefix' => 'receita'],function(){
	Route::post('/save', 'ReceitaController@save');
	Route::post('/update', 'ReceitaController@update');
	Route::post('/saveItem', 'ReceitaController@saveItem');
	Route::get('/deleteItem/{id}', 'ReceitaController@deleteItem');

});

Route::group(['prefix' => 'vendasEmCredito'],function(){
	Route::get('/', 'CreditoVendaController@index');
	Route::get('/receber', 'CreditoVendaController@receber');
	Route::get('/receber', 'CreditoVendaController@receber');
	Route::get('/delete/{id}', 'CreditoVendaController@delete');
	Route::get('/somaVendas/{cliente_id}', 'CreditoVendaController@somaVendas');
	
	Route::get('/emitirNFe', 'CreditoVendaController@emitirNFe');
	Route::get('/filtro', 'CreditoVendaController@filtro');
	Route::get('/apenasReceber', 'CreditoVendaController@apenasReceber');

});

Route::group(['prefix' => 'vendasCaixa'],function(){
	Route::post('/save', 'VendaCaixaController@save');
	Route::get('/diaria', 'VendaCaixaController@diaria');
});

Route::group(['prefix' => 'tributos'], function(){
	Route::get('/', 'TributoController@index');
	Route::post('/save', 'TributoController@save');
});

Route::group(['prefix' => 'funcionamentoDelivery'], function(){
	Route::get('/', 'FuncionamentoDeliveryController@index');
	Route::post('/save', 'FuncionamentoDeliveryController@save');
	Route::get('/edit/{id}', 'FuncionamentoDeliveryController@edit');
	Route::get('/alterarStatus/{id}', 'FuncionamentoDeliveryController@alterarStatus');

});


Route::group(['prefix' => 'enviarXml'],function(){
	Route::get('/', 'EnviarXmlController@index');
	Route::get('/filtro', 'EnviarXmlController@filtro');
	Route::get('/download', 'EnviarXmlController@download');
	Route::get('/downloadNfce', 'EnviarXmlController@downloadNfce');
	Route::get('/downloadCte', 'EnviarXmlController@downloadCte');
	Route::get('/downloadMdfe', 'EnviarXmlController@downloadMdfe');
	Route::get('/email/{d1}/{d2}', 'EnviarXmlController@email');
	Route::get('/emailNfce/{d1}/{d2}', 'EnviarXmlController@emailNfce');
	Route::get('/emailCte/{d1}/{d2}', 'EnviarXmlController@emailCte');
	Route::get('/emailMdfe/{d1}/{d2}', 'EnviarXmlController@emailMdfe');
	Route::get('/send', 'EnviarXmlController@send');
});

Route::group(['prefix' => 'nf'],function(){
	Route::post('/gerarNf', 'NotaFiscalController@gerarNf')->middleware('valid');
	Route::get('/gerarNf/{id}', 'NotaFiscalController@testeGerar');
	Route::get('/xmlTemp/{id}', 'NotaFiscalController@xmlTemp');
	Route::get('/imprimir/{id}', 'NotaFiscalController@imprimir');
	Route::get('/escpos/{id}', 'NotaFiscalController@escpos');
	Route::get('/imprimirCce/{id}', 'NotaFiscalController@imprimirCce');
	Route::get('/imprimirCancela/{id}', 'NotaFiscalController@imprimirCancela');
	Route::get('/consultar_cliente/{id}', 'NotaFiscalController@consultar_cliente');
	Route::post('/cancelar', 'NotaFiscalController@cancelar');
	Route::post('/consultar', 'NotaFiscalController@consultar');
	Route::post('/cartaCorrecao', 'NotaFiscalController@cartaCorrecao');
	Route::get('/teste', 'NotaFiscalController@teste');
	Route::get('/consultaCadastro', 'NotaFiscalController@consultaCadastro');
	Route::post('/inutilizar', 'NotaFiscalController@inutilizar');
	Route::get('/certificado', 'NotaFiscalController@certificado');
	Route::get('/enviarXml', 'NotaFiscalController@enviarXml');

});

Route::group(['prefix' => 'cte'],function(){
	Route::get('/', 'CteController@index');
	Route::get('/nova', 'CteController@nova');
	Route::get('/lista', 'CteController@lista');
	Route::get('/detalhar/{id}', 'CteController@detalhar');

	Route::get('/edit/{id}', 'CteController@edit');

	Route::get('/delete/{id}', 'CteController@delete');
	Route::post('/salvar', 'CteController@salvar');
	Route::post('/update', 'CteController@update');
	Route::get('/filtro', 'CteController@filtro');
	Route::get('/custos/{id}', 'CteController@custos');
	Route::post('/saveReceita', 'CteController@saveReceita');
	Route::post('/saveDespesa', 'CteController@saveDespesa');
	Route::post('/importarXml', 'CteController@importarXml');

	Route::get('/deleteReceita/{id}', 'CteController@deleteReceita');
	Route::get('/deleteDespesa/{id}', 'CteController@deleteDespesa');

	Route::get('/consultaChave', 'EmiteCteController@consultaChave');
	Route::get('/chaveNfeDuplicada', 'CteController@chaveNfeDuplicada');
	
});

Route::group(['prefix' => 'cteSefaz'],function(){
	Route::post('/enviar', 'EmiteCteController@enviar');
	Route::get('/imprimir/{id}', 'EmiteCteController@imprimir');
	Route::get('/imprimirCCe/{id}', 'EmiteCteController@imprimirCCe');
	Route::get('/imprimirCancela/{id}', 'EmiteCteController@imprimirCancela');
	Route::post('/cancelar', 'EmiteCteController@cancelar');
	Route::post('/consultar', 'EmiteCteController@consultar');
	Route::post('/inutilizar', 'EmiteCteController@inutilizar');
	Route::post('/cartaCorrecao', 'EmiteCteController@cartaCorrecao');
	Route::get('/teste/{id}', 'EmiteCteController@teste');
	Route::get('/enviarXml', 'EmiteCteController@enviarXml');
	Route::get('/baixarXml/{id}', 'EmiteCteController@baixarXml');
	Route::get('/xmlTemp/{id}', 'EmiteCteController@xmlTemp');

});


Route::group(['prefix' => 'mdfe'],function(){
	Route::get('/', 'MdfeController@index');
	Route::get('/nova', 'MdfeController@nova');
	Route::get('/lista', 'MdfeController@lista');
	Route::get('/detalhar/{id}', 'MdfeController@detalhar');
	Route::get('/delete/{id}', 'MdfeController@delete');
	Route::get('/edit/{id}', 'MdfeController@edit');
	Route::post('/salvar', 'MdfeController@salvar');
	Route::post('/update', 'MdfeController@update');
	Route::get('/filtro', 'MdfeController@filtro');
	
});

Route::group(['prefix' => 'mdfeSefaz'],function(){
	Route::post('/enviar', 'EmiteMdfeController@enviar');
	Route::get('/imprimir/{id}', 'EmiteMdfeController@imprimir');
	Route::get('/imprimirPorChave/{chave}', 'EmiteMdfeController@imprimirPorChave');
	Route::get('/baixarXml/{id}', 'EmiteMdfeController@baixarXml');
	Route::post('/cancelar', 'EmiteMdfeController@cancelar');
	Route::post('/consultar', 'EmiteMdfeController@consultar');

	Route::get('/naoEncerrados', 'EmiteMdfeController@naoEncerrados');
	Route::post('/encerrar', 'EmiteMdfeController@encerrar');
	Route::get('/enviarXml', 'EmiteMdfeController@enviarXml');
	Route::get('/xmlTemp/{id}', 'EmiteMdfeController@xmlTemp');
});

Route::group(['prefix' => 'nfce'],function(){
	Route::post('/gerar', 'NFCeController@gerar')->middleware('validNFCe');
	Route::get('/xmlTemp/{id}', 'NFCeController@xmlTemp');
	Route::get('/imprimir/{id}', 'NFCeController@imprimir');
	Route::get('/imprimirNaoFiscal/{id}', 'NFCeController@imprimirNaoFiscal');
	Route::get('/imprimirNaoFiscalCredito/{id}', 'NFCeController@imprimirNaoFiscalCredito');
	Route::post('/cancelar', 'NFCeController@cancelar');
	Route::post('/cancelarSubstituicao', 'NFCeController@cancelarSubstituicao');
	Route::get('/deleteVenda/{id}', 'NFCeController@deleteVenda');
	Route::get('/consultar/{id}', 'NFCeController@consultar');
	Route::get('/baixarXml/{id}', 'NFCeController@baixarXml');
	Route::get('/gerarXml/{id}', 'NFCeController@gerarXml');
	Route::get('/gerarArquivo', 'NFCeController@gerarArquivo');
	
	// Route::post('/consultar', 'NotaFiscalController@consultar');
	// Route::get('/teste', 'NotaFiscalController@teste');
});

Route::group(['prefix' => 'clientes'],function(){
	Route::get('/', 'ClienteController@index');
	Route::get('/delete/{id}', 'ClienteController@delete');
	Route::get('/edit/{id}', 'ClienteController@edit');
	Route::get('/new', 'ClienteController@new');
	Route::get('/all', 'ClienteController@all');
	Route::get('/verificaLimite', 'ClienteController@verificaLimite');
	Route::get('/find/{id}', 'ClienteController@find');
	Route::get('/pesquisa', 'ClienteController@pesquisa');
	
	Route::post('/request', 'ClienteController@request');
	Route::post('/save', 'ClienteController@save');
	Route::post('/update', 'ClienteController@update');
	Route::get('/cpfCnpjDuplicado', 'ClienteController@cpfCnpjDuplicado');
	Route::get('/imprimir', 'ClienteController@imprimir');


	Route::post('/quickSave', 'ClienteController@quickSave');


});

Route::group(['prefix' => 'clientesDelivery'],function(){
	Route::get('/', 'ClienteDeliveryController@index');
	Route::get('/edit/{id}', 'ClienteDeliveryController@edit');
	Route::get('/delete/{id}', 'ClienteDeliveryController@delete');
	Route::get('/all', 'ClienteDeliveryController@all');
	Route::post('/update', 'ClienteDeliveryController@update');


	Route::get('/pedidos/{id}', 'ClienteDeliveryController@pedidos');
	Route::get('/enderecos/{id}', 'ClienteDeliveryController@enderecos');
	Route::get('/enderecosEdit/{id}', 'ClienteDeliveryController@enderecoEdit');
	Route::get('/enderecosMap/{id}', 'ClienteDeliveryController@enderecosMap');
	Route::get('/favoritos/{id}', 'ClienteDeliveryController@favoritos');
	Route::get('/push/{id}', 'ClienteDeliveryController@push');
	Route::post('/updateEndereco', 'ClienteDeliveryController@updateEndereco');
	
	Route::get('/pesquisa', 'ClienteDeliveryController@pesquisa');

	Route::get('/alterarStatus/{id}', 'ClienteDeliveryController@alterarStatus');
	Route::get('/alterarSenha/{id}', 'ClienteDeliveryController@alterarSenha');
	Route::post('/alterarSenha', 'ClienteDeliveryController@alterarSenhaStore');
	
});


Route::group(['prefix' => 'transportadoras'],function(){
	Route::get('/', 'TransportadoraController@index');
	Route::get('/delete/{id}', 'TransportadoraController@delete');
	Route::get('/edit/{id}', 'TransportadoraController@edit');
	Route::get('/new', 'TransportadoraController@new');
	Route::get('/all', 'TransportadoraController@all');
	Route::get('/find/{id}', 'TransportadoraController@find');
	
	Route::post('/save', 'TransportadoraController@save');
	Route::post('/update', 'TransportadoraController@update');
});

Route::group(['prefix' => 'fornecedores'],function(){
	Route::get('/', 'ProviderController@index');
	Route::get('/delete/{id}', 'ProviderController@delete');
	Route::get('/edit/{id}', 'ProviderController@edit');
	Route::get('/new', 'ProviderController@new');
	Route::get('/all', 'ProviderController@all');
	Route::get('/find/{id}', 'ProviderController@find');

	Route::post('/request', 'ProviderController@request');
	Route::post('/save', 'ProviderController@save');
	Route::post('/update', 'ProviderController@update');
});

Route::group(['prefix' => 'compraFiscal'],function(){
	Route::get('/', 'CompraFiscalController@index');
	Route::post('/new', 'CompraFiscalController@new');
	Route::post('/salvarNfFiscal', 'CompraFiscalController@salvarNfFiscal');
	Route::post('/salvarItem', 'CompraFiscalController@salvarItem');
	Route::get('/read', 'CompraFiscalController@read');
	Route::get('/teste', 'CompraFiscalController@teste');
});

Route::group(['prefix' => 'compraManual'],function(){
	Route::get('/', 'CompraManualController@index');
	Route::post('/salvar', 'CompraManualController@salvar');
	Route::post('/salvarNfFiscal', 'CompraManualController@salvarNfFiscal');
	Route::post('/salvarItem', 'CompraManualController@salvarItem');
	Route::get('/read', 'CompraManualController@read');

	Route::get('/ultimaCompra/{produtoId}', 'CompraManualController@ultimaCompra');
});

Route::group(['prefix' => 'funcionarios'],function(){
	Route::get('/', 'FuncionarioController@index');
	Route::get('/delete/{id}', 'FuncionarioController@delete');
	Route::get('/edit/{id}', 'FuncionarioController@edit');
	Route::get('/new', 'FuncionarioController@new');
	Route::get('/all', 'FuncionarioController@all');
	Route::get('/contatos/{id}', 'FuncionarioController@contatos');
	Route::get('/editContato/{id}', 'FuncionarioController@editContato');
	Route::get('/deleteContato/{id}', 'FuncionarioController@deleteContato');
	Route::post('/saveContato', 'FuncionarioController@saveContato');
	Route::post('/updateContato', 'FuncionarioController@saveContato');

	Route::post('/request', 'FuncionarioController@request');
	Route::post('/save', 'FuncionarioController@save');
	Route::post('/update', 'FuncionarioController@update');


	Route::get('/comissao', 'FuncionarioController@comissao');
	Route::get('/pagarComissao', 'FuncionarioController@pagarComissao');
	Route::get('/comissaoFiltro', 'FuncionarioController@comissaoFiltro');

});

Route::group(['prefix' => 'contatoFuncionario'],function(){
	Route::get('/{funcionaId}', 'FuncionarioController@index');
	Route::get('/delete/{id}', 'FuncionarioController@delete');
	Route::get('/edit/{id}', 'FuncionarioController@edit');
	Route::get('/new/{funcionarioId}', 'FuncionarioController@new');
	Route::post('/save', 'FuncionarioController@save');
	Route::post('/update', 'FuncionarioController@update');
});

Route::group(['prefix' => 'servicos'],function(){
	Route::get('/', 'ServiceController@index');
	Route::get('/delete/{id}', 'ServiceController@delete');
	Route::get('/edit/{id}', 'ServiceController@edit');
	Route::get('/new', 'ServiceController@new');
	Route::get('/all', 'ServiceController@all');

	Route::post('/request', 'ServiceController@request');
	Route::post('/save', 'ServiceController@save');
	Route::post('/update', 'ServiceController@update');
	Route::get('/pesquisa', 'ServiceController@pesquisa');
	Route::post('/getValue', 'ServiceController@getValue');
});

Route::group(['prefix' => 'orcamento'],function(){
	Route::get('/', 'BudgetController@index');
	Route::get('/delete/{id}', 'BudgetController@delete');
	Route::get('/new', 'BudgetController@new');

	Route::get('/searchClient', 'BudgetController@searchClient');
	Route::get('/searchDate', 'BudgetController@searchDate');

	Route::get('/os/{id}', 'BudgetController@os');
	Route::post('/save', 'BudgetController@save');
});

Route::group(['prefix' => 'ordemServico'],function(){
	Route::get('/', 'OrderController@index');
	Route::get('/new', 'OrderController@new');
	Route::get('/servicosordem/{id}', 'OrderController@servicosordem');
	Route::get('/deleteServico/{id}', 'OrderController@deleteServico');
	Route::get('/addRelatorio/{id}', 'OrderController@addRelatorio');
	Route::get('/editRelatorio/{id}', 'OrderController@editRelatorio');
	Route::get('/deleteRelatorio/{id}', 'OrderController@deleteRelatorio');
	Route::get('/alterarEstado/{id}', 'OrderController@alterarEstado');
	Route::post('/alterarEstado', 'OrderController@alterarEstadoPost');
	Route::get('/filtro', 'OrderController@filtro');
	
	Route::post('/addRelatorio', 'OrderController@saveRelatorio');
	Route::post('/updateRelatorio', 'OrderController@updateRelatorio');
	Route::get('/cashFlowFilter', 'OrderController@cashFlowFilter');
	Route::post('/save', 'OrderController@save');
	Route::post('/addServico', 'OrderController@addServico');
	Route::post('/find', 'OrderController@find');

	Route::get('/print/{id}', 'OrderController@print');
	Route::get('/delete/{id}', 'OrderController@delete');

	Route::get('/deleteFuncionario/{id}', 'OrderController@deleteFuncionario');
	Route::post('/saveFuncionario', 'OrderController@saveFuncionario');

	Route::get('/alterarStatusServico/{id}', 'OrderController@alterarStatusServico');
	Route::get('/imprimir/{id}', 'OrderController@imprimir');
	
	Route::post('/setaDesconto', 'OrderController@setaDesconto');
});

Route::group(['prefix' => 'semRegistro'],function(){
	Route::get('/', 'ApplianceNotFounController@index');
	Route::get('/delete/{id}', 'ApplianceNotFounController@delete');
});


Route::group(['prefix' => 'fluxoCaixa'],function(){
	Route::get('/', 'FluxoCaixaController@index');
	Route::get('/filtro', 'FluxoCaixaController@filtro');
	Route::get('/relatorioIndex', 'FluxoCaixaController@relatorioIndex');
	Route::get('/relatorioFiltro/{data1}/{data2}', 'FluxoCaixaController@relatorioFiltro');
});

Route::group(['prefix' => 'orcamentoCliente'],function(){
	Route::get('/', 'ClientTempController@index');
	Route::get('/delete/{id}', 'ClientTempController@delete');
});

Route::group(['prefix' => 'vendas'],function(){
	Route::get('/', 'VendaController@index');
	Route::get('/nova', 'VendaController@nova');
	Route::get('/lista', 'VendaController@lista');
	Route::get('/detalhar/{id}', 'VendaController@detalhar');
	Route::get('/delete/{id}', 'VendaController@delete');
	Route::get('/edit/{id}', 'VendaController@edit');
	Route::post('/salvar', 'VendaController@salvar');
	Route::post('/atualizar', 'VendaController@atualizar');
	Route::post('/salvarCrediario', 'VendaController@salvarCrediario');
	Route::get('/filtro', 'VendaController@filtro');
	Route::get('/rederizarDanfe/{id}', 'VendaController@rederizarDanfe');
	Route::get('/baixarXml/{id}', 'VendaController@baixarXml');
	Route::get('/imprimirPedido/{id}', 'VendaController@imprimirPedido');
	Route::get('/clone/{id}', 'VendaController@clone');
	Route::get('/gerarXml/{id}', 'VendaController@gerarXml');
	Route::post('/clone', 'VendaController@salvarClone');

	Route::get('/calculaFrete', 'VendaController@calculaFrete');
});

Route::group(['prefix' => 'compras'],function(){
	Route::get('/', 'PurchaseController@index');
	Route::get('/filtro', 'PurchaseController@filtro');
	Route::get('/view/{id}', 'PurchaseController@view');
	Route::get('/delete/{id}', 'PurchaseController@delete');
	Route::get('/detalhes/{id}', 'PurchaseController@detalhes');
	Route::get('/pesquisa', 'PurchaseController@pesquisa');
	Route::get('/downloadXml/{id}', 'PurchaseController@downloadXml');
	Route::get('/downloadXmlCancela/{id}', 'PurchaseController@downloadXmlCancela');
	Route::post('/save', 'PurchaseController@save');

	Route::get('/emitirEntrada/{id}', 'PurchaseController@emitirEntrada');
	Route::post('/gerarEntrada', 'PurchaseController@gerarEntrada');
	Route::post('/cancelarEntrada', 'PurchaseController@cancelarEntrada');

	Route::get('/imprimir/{id}', 'PurchaseController@imprimir');

	Route::get('/produtosSemValidade', 'PurchaseController@produtosSemValidade');
	Route::post('/salvarValidade', 'PurchaseController@salvarValidade');
	Route::get('/validadeAlerta', 'PurchaseController@validadeAlerta');
	

});

Route::group(['prefix' => 'estoque'],function(){
	Route::get('/', 'StockController@index');
	Route::get('/view/{id}', 'StockController@view');
	Route::get('/deleteApontamento/{id}', 'StockController@deleteApontamento');
	Route::get('/apontamentoProducao', 'StockController@apontamento');
	Route::get('/todosApontamentos', 'StockController@todosApontamentos');
	Route::get('/apontamentoManual', 'StockController@apontamentoManual');
	Route::get('/filtroApontamentos', 'StockController@filtroApontamentos');
	Route::post('/saveApontamento', 'StockController@saveApontamento');
	Route::post('/saveApontamentoManual', 'StockController@saveApontamentoManual');
	Route::get('/listApontamentos', 'StockController@listApontamentos');
	Route::get('/listApontamentos/delete/{id}', 'StockController@listApontamentosDelte');

});

Route::group(['prefix' => 'cotacao'],function(){
	Route::get('/', 'CotacaoController@index');
	Route::get('/new', 'CotacaoController@new');
	Route::post('/salvar', 'CotacaoController@salvar');
	
	Route::get('/deleteItem/{id}', 'CotacaoController@deleteItem');
	Route::get('/delete/{id}', 'CotacaoController@delete');
	Route::get('/edit/{id}', 'CotacaoController@edit');
	Route::get('/alterarStatus/{id}/{status}', 'CotacaoController@alterarStatus');
	Route::post('/saveItem', 'CotacaoController@saveItem');

	Route::get('/view/{id}', 'CotacaoController@view');
	Route::get('/clonar/{id}', 'CotacaoController@clonar');
	Route::post('/clonarSave', 'CotacaoController@clonarSave');


	Route::get('/response/{code}', 'CotacaoController@response');
	Route::get('/filtro', 'CotacaoController@filtro');


	Route::get('/searchProvider', 'CotacaoController@searchProvider');
	Route::get('/searchPiece', 'CotacaoController@searchPiece');


	Route::get('/sendMail/{id}', 'CotacaoController@sendMail');
	Route::get('/listaPorReferencia', 'CotacaoController@listaPorReferencia');
	Route::get('/listaPorReferencia/filtro', 'CotacaoController@listaPorReferenciaFiltro');
	Route::get('/referenciaView/{referencia}', 'CotacaoController@referenciaView');
	Route::get('/escolher/{id}', 'CotacaoController@escolher');
	Route::get('/imprimirMelhorResultado', 'CotacaoController@imprimirMelhorResultado');



});

Route::get('/response/{code}', 'CotacaoResponseController@response');
Route::post('/responseSave', 'CotacaoResponseController@responseSave');


Route::group(['prefix' => 'frenteCaixa'],function(){
	Route::get('/', 'FrontBoxController@index');
	Route::get('/comPedido/{pedido_id}', 'FrontBoxController@index');
	Route::get('/list', 'FrontBoxController@list');
	Route::get('/devolucao', 'FrontBoxController@devolucao');
	Route::get('/filtro', 'FrontBoxController@filtro');

	Route::get('/filtroCliente', 'FrontBoxController@filtroCliente');
	Route::get('/filtroNFCe', 'FrontBoxController@filtroNFCe');
	Route::get('/filtroValor', 'FrontBoxController@filtroValor');
	Route::get('/fechar', 'FrontBoxController@fechar');
	Route::post('/fechar', 'FrontBoxController@fecharPost');
	Route::get('/fechamentos', 'FrontBoxController@fechamentos');
	Route::get('/listaFechamento/{id}', 'FrontBoxController@listaFechamento');

	Route::get('/deleteVenda/{id}', 'FrontBoxController@deleteVenda');

	Route::get('/config', 'FrontBoxController@config');
	Route::post('/configSave', 'FrontBoxController@configSave');
	Route::post('/saveItemPedido', 'FrontBoxController@saveItemPedido');
	Route::get('/deleteItemPedido/{item_id}', 'FrontBoxController@deleteItemPedido');
	Route::get('/deletePedido/{item_id}', 'FrontBoxController@deletePedido');
});


Route::get('/ola', function() {
	return view('default/ola')->with('title', 'Bem vindo ao teste do SlymPDV');
});

Route::group(['prefix' => 'clienteDelivery'],function(){
	Route::get('/all', 'AppUserController@all');

});

Route::group(['prefix' => 'push'],function(){
	Route::get('/', 'PushController@index');
	Route::get('/new', 'PushController@new');
	Route::post('/save', 'PushController@save');
	Route::post('/update', 'PushController@update');

	Route::get('/send/{id}', 'PushController@send');
	Route::get('/edit/{id}', 'PushController@edit');
	Route::get('/delete/{id}', 'PushController@delete');

});

Route::group(['prefix' => 'codigoDesconto'],function(){
	Route::get('/', 'CodigoDescontoController@index');
	Route::get('/new', 'CodigoDescontoController@new');
	Route::post('/save', 'CodigoDescontoController@save');
	Route::post('/update', 'CodigoDescontoController@update');
	Route::get('/edit/{id}', 'CodigoDescontoController@edit');

	Route::get('/delete/{id}', 'CodigoDescontoController@delete');
	Route::get('/push/{id}', 'CodigoDescontoController@push');
	Route::post('/push', 'CodigoDescontoController@savePush');
	Route::get('/sms/{id}', 'CodigoDescontoController@sms');
	Route::post('/sms', 'CodigoDescontoController@saveSms');
	Route::get('/alterarStatus/{id}', 'CodigoDescontoController@alterarStatus');
});

Route::group(['prefix' => 'tamanhosPizza'],function(){
	Route::get('/', 'TamanhoPizzaController@index');
	Route::get('/new', 'TamanhoPizzaController@new');
	Route::post('/save', 'TamanhoPizzaController@save');
	Route::post('/update', 'TamanhoPizzaController@update');
	Route::get('/edit/{id}', 'TamanhoPizzaController@edit');

	Route::get('/delete/{id}', 'TamanhoPizzaController@delete');

});

Route::group(['prefix' => 'categoriaDespesa'],function(){
	Route::get('/', 'CategoriaDespesaController@index');
	Route::get('/new', 'CategoriaDespesaController@new');
	Route::post('/save', 'CategoriaDespesaController@save');
	Route::post('/update', 'CategoriaDespesaController@update');
	Route::get('/edit/{id}', 'CategoriaDespesaController@edit');

	Route::get('/delete/{id}', 'CategoriaDespesaController@delete');

});

Route::group(['prefix' => 'veiculos'],function(){
	Route::get('/', 'VeiculoController@index');
	Route::get('/new', 'VeiculoController@new');
	Route::post('/save', 'VeiculoController@save');
	Route::post('/update', 'VeiculoController@update');
	Route::get('/edit/{id}', 'VeiculoController@edit');
	Route::get('/delete/{id}', 'VeiculoController@delete');
});

Route::group(['prefix' => 'devolucao'],function(){
	Route::get('/', 'DevolucaoController@index');
	Route::get('/nova', 'DevolucaoController@new');
	Route::post('/new', 'DevolucaoController@renderizarXml');
	Route::post('/salvar', 'DevolucaoController@salvar');
	Route::post('/enviarSefaz', 'DevolucaoController@enviarSefaz');
	Route::post('/cancelar', 'DevolucaoController@cancelar');
	Route::get('/ver/{id}', 'DevolucaoController@ver');
	Route::get('/edit/{id}', 'DevolucaoController@edit');
	Route::get('/delete/{id}', 'DevolucaoController@delete');
	Route::get('/imprimir/{id}', 'DevolucaoController@imprimir');
	Route::get('/downloadXmlEntrada/{id}', 'DevolucaoController@downloadXmlEntrada');
	Route::get('/downloadXmlDevolucao/{id}', 'DevolucaoController@downloadXmlDevolucao');
	Route::get('/filtro', 'DevolucaoController@filtro');
	Route::get('/xmltemp/{id}', 'DevolucaoController@xmltemp');

	Route::post('/saveItem', 'DevolucaoController@saveItem');

	
});

Route::group(['prefix' => 'controleCozinha'],function(){
	Route::get('/controle/{tela?}', 'CozinhaController@index');
	Route::get('/selecionar', 'CozinhaController@selecionar');
	Route::get('/buscar', 'CozinhaController@buscar');
	Route::get('/concluido', 'CozinhaController@concluido');
});

Route::group(['prefix' => 'graficos'],function(){
	Route::get('/', 'HomeController@index');
	Route::get('/faturamentoDosUltimosSeteDias', 'HomeController@faturamentoDosUltimosSeteDias');
	Route::get('/faturamentoFiltrado', 'HomeController@faturamentoFiltrado');

});

Route::group(['prefix' => 'bairrosDelivery'],function(){
	Route::get('/', 'BairroDeliveryController@index');
	Route::get('/delete/{id}', 'BairroDeliveryController@delete');
	Route::get('/edit/{id}', 'BairroDeliveryController@edit');
	Route::get('/new', 'BairroDeliveryController@new');

	Route::post('/request', 'BairroDeliveryController@request');
	Route::post('/save', 'BairroDeliveryController@save');
	Route::post('/update', 'BairroDeliveryController@update');
});

Route::group(['prefix' => 'mesas'],function(){
	Route::get('/', 'MesaController@index');
	Route::get('/delete/{id}', 'MesaController@delete');
	Route::get('/edit/{id}', 'MesaController@edit');
	Route::get('/new', 'MesaController@new');

	Route::post('/save', 'MesaController@save');
	Route::post('/update', 'MesaController@update');
	Route::get('/gerarQrCode', 'MesaController@gerarQrCode');
	Route::get('/issue/{id}', 'MesaController@issue');
	Route::get('/issue2/{id}', 'MesaController@issue2');
	Route::get('/imprimirQrCode/{id}', 'MesaController@imprimirQrCode');
	Route::get('/emAberto', 'MesaController@emAberto');

});

Route::group(['prefix' => 'bannerTopo'],function(){
	Route::get('/', 'BannerTopoController@index');
	Route::get('/delete/{id}', 'BannerTopoController@delete');
	Route::get('/edit/{id}', 'BannerTopoController@edit');
	Route::get('/new', 'BannerTopoController@new');

	Route::post('/save', 'BannerTopoController@save');
	Route::post('/update', 'BannerTopoController@update');
});

Route::group(['prefix' => 'bannerMaisVendido'],function(){
	Route::get('/', 'BannerMaisVendidoController@index');
	Route::get('/delete/{id}', 'BannerMaisVendidoController@delete');
	Route::get('/edit/{id}', 'BannerMaisVendidoController@edit');
	Route::get('/new', 'BannerMaisVendidoController@new');

	Route::post('/save', 'BannerMaisVendidoController@save');
	Route::post('/update', 'BannerMaisVendidoController@update');
});

Route::group(['prefix' => 'delivery'], function(){

	Route::get('/', 'MercadoController@index');
	Route::get('/categorias', 'MercadoController@categorias');
	Route::get('/produto/{id}', 'MercadoController@produto');
	Route::get('/login', 'MercadoController@login');
	Route::get('/logoff', 'MercadoController@logoff');
	Route::post('/login', 'MercadoController@loginUser');
	Route::get('/cadastrar', 'MercadoController@cadastrar');
	Route::get('/produtos/{categoria_id}', 'MercadoController@produtos');
	Route::post('/salvarRegistro', 'MercadoController@salvarRegistro');
	Route::post('/validaToken', 'MercadoController@validaToken');
	Route::get('/carrinho', 'MercadoController@carrinho');
	Route::post('/finalizar', 'MercadoController@finalizar');
	Route::post('/finalizarPedido', 'MercadoController@finalizarPedido');
	Route::get('/finalizado/{id}', 'MercadoController@finalizado');
	Route::get('/pedidoPendente', 'MercadoController@pedidoPendente');
	Route::get('/meusPedidos', 'MercadoController@meusPedidos');
	Route::get('/detalhePedido/{id}', 'MercadoController@detalhePedido');
	Route::get('/pedir_novamente/{id}', 'MercadoController@pedir_novamente');
	Route::get('/pesquisaProduto', 'MercadoController@pesquisaProduto');

	Route::get('/esqueci-senha', 'MercadoController@recuperarSenha');
	Route::post('/esqueci-senha', 'MercadoController@enviarSenha');

});

Route::group(['prefix' => 'deliveryProduto'], function(){
	Route::post('/addProduto', 'MercadoProdutoController@addProduto');
	Route::get('/addProduto/{id}', 'MercadoProdutoController@adicionarProduto');
	Route::post('/downProduto', 'MercadoProdutoController@downProduto');
	Route::get('/novo_cliente', 'MercadoProdutoController@novoCliente');
	Route::get('/carrinho', 'MercadoProdutoController@carrinho');
	Route::post('/alterCart', 'MercadoProdutoController@alterCart');
});

Route::group(['prefix' => 'orcamentoVenda'], function(){
	Route::get('/', 'OrcamentoController@index');
	Route::post('/salvar', 'OrcamentoController@salvar');
	Route::get('/detalhar/{id}', 'OrcamentoController@detalhar');
	Route::get('/delete/{id}', 'OrcamentoController@delete');
	Route::get('/imprimir/{id}', 'OrcamentoController@imprimir');
	Route::get('/imprimirCompleto/{id}', 'OrcamentoController@imprimirCompleto');
	Route::get('/rederizarDanfe/{id}', 'OrcamentoController@rederizarDanfe');
	Route::get('/enviarEmail', 'OrcamentoController@enviarEmail');
	Route::get('/deleteItem/{id}', 'OrcamentoController@deleteItem');
	Route::post('/addItem', 'OrcamentoController@addItem');
	Route::post('/gerarVenda', 'OrcamentoController@gerarVenda');
	Route::post('/setValidade', 'OrcamentoController@setValidade');
	Route::post('/addPag', 'OrcamentoController@addPag');
	Route::get('/deleteParcela/{id}', 'OrcamentoController@deleteParcela');
	Route::get('/filtro', 'OrcamentoController@filtro');
	Route::get('/reprovar/{id}', 'OrcamentoController@reprovar');

	Route::get('/relatorioItens/{data1}/{data2}', 'OrcamentoController@relatorioItens');

	Route::get('/find/{id}', 'OrcamentoController@find');

});

Route::group(['prefix' => 'listaDePrecos'], function(){
	Route::get('/', 'ListaPrecoController@index');
	Route::get('/delete/{id}', 'ListaPrecoController@delete');
	Route::get('/edit/{id}', 'ListaPrecoController@edit');
	Route::get('/new', 'ListaPrecoController@new');

	Route::post('/save', 'ListaPrecoController@save');
	Route::post('/update', 'ListaPrecoController@update');

	Route::get('/ver/{id}', 'ListaPrecoController@ver');
	Route::get('/gerar/{id}', 'ListaPrecoController@gerar');
	Route::get('/editValor/{id}', 'ListaPrecoController@editValor');

	Route::post('/salvarPreco', 'ListaPrecoController@salvarPreco');
	
	Route::get('/pesquisa', 'ListaPrecoController@pesquisa');
	Route::get('/filtro', 'ListaPrecoController@filtro');

});


Route::group(['prefix' => 'atendimento', 'middleware' => ['autoAtendimentoAtivo']], function(){
	Route::get('/', 'AutoatendimentoController@index');
	Route::post('/iniciar', 'AutoatendimentoController@iniciar');
	Route::get('/erro', 'AutoatendimentoController@erro');
	Route::get('/cardapio/{id}', 'AutoatendimentoController@cardapio');
	Route::get('/encerrar', 'AutoatendimentoController@encerrar');

	Route::get('/escolherSabores', 'AutoatendimentoController@escolherSabores');
	Route::post('/adicionarSabor', 'AutoatendimentoController@adicionarSabor');
	Route::get('/verificaPizzaAdicionada', 'AutoatendimentoController@verificaPizzaAdicionada');
	Route::get('/removeSabor/{id}', 'AutoatendimentoController@removeSabor');
	Route::get('/adicionais/{id}', 'AutoatendimentoController@adicionais');
	Route::get('/adicionaisPizza', 'AutoatendimentoController@adicionaisPizza');
	Route::get('/pesquisa', 'AutoatendimentoController@pesquisa');
	Route::get('/pizzas', 'AutoatendimentoController@pizzas');

	Route::get('/ver', 'AutoatendimentoController@ver');

	Route::post('/addPizza', 'AutoatendimentoController@addPizza')->middleware('atendimentoAtivo');
	Route::post('/addProd', 'AutoatendimentoController@addProd')->middleware('atendimentoAtivo');

	Route::get('/refreshItem/{id}/{quantidade}', 'AutoatendimentoController@refreshItem');
	Route::get('/removeItem/{id}', 'AutoatendimentoController@removeItem');
	Route::get('/finalizar', 'AutoatendimentoController@finalizar');
});

Route::group(['prefix' => 'pedido', 'middleware' => ['pedidoAtivo']], function(){
	Route::get('/', 'PedidoQrCodeController@index');
	Route::get('/open/{id}', 'PedidoQrCodeController@open');
	Route::get('/erro', 'PedidoQrCodeController@erro');
	Route::get('/cardapio/{id}', 'PedidoQrCodeController@cardapio');


	Route::get('/escolherSabores', 'PedidoQrCodeController@escolherSabores');
	Route::post('/adicionarSabor', 'PedidoQrCodeController@adicionarSabor');
	Route::get('/verificaPizzaAdicionada', 'PedidoQrCodeController@verificaPizzaAdicionada');
	Route::get('/removeSabor/{id}', 'PedidoQrCodeController@removeSabor');
	Route::get('/adicionais/{id}', 'PedidoQrCodeController@adicionais');
	Route::get('/adicionaisPizza', 'PedidoQrCodeController@adicionaisPizza');
	Route::get('/pesquisa', 'PedidoQrCodeController@pesquisa');
	Route::get('/pizzas', 'DeliveryController@pizzas');

	Route::get('/ver', 'PedidoQrCodeController@ver');

	Route::post('/addPizza', 'PedidoQrCodeController@addPizza')->middleware('mesaAtiva');
	Route::post('/addProd', 'PedidoQrCodeController@addProd')->middleware('mesaAtiva');

	Route::get('/refreshItem/{id}/{quantidade}', 'PedidoQrCodeController@refreshItem');
	Route::get('/removeItem/{id}', 'PedidoQrCodeController@removeItem');
	Route::get('/finalizar', 'PedidoQrCodeController@finalizar');
});

Route::group(['prefix' => 'motoboys'], function(){
	Route::get('/', 'MotoboyController@index');
	Route::get('/new', 'MotoboyController@new');
	Route::post('/save', 'MotoboyController@save');
	Route::post('/update', 'MotoboyController@update');
	Route::get('/edit/{id}', 'MotoboyController@edit');

	Route::get('/deleteEntrega/{id}', 'MotoboyController@deleteEntrega');
	Route::get('/entregas', 'MotoboyController@entregas');
	Route::get('/filtro', 'MotoboyController@filtro');
	Route::get('/pagar', 'MotoboyController@pagar');

	Route::get('/novoPedido', 'MotoboyController@novoPedido');
	Route::post('/savePedido', 'MotoboyController@savePedido');

});

Route::group(['prefix' => 'boleto'], function(){
	Route::get('/', 'BoletoController@index');

});


Route::group(['prefix' => 'telasPedido'], function(){
	Route::get('/', 'TelaPedidoController@index');
	Route::get('/new', 'TelaPedidoController@new');
	Route::post('/save', 'TelaPedidoController@save');
	Route::post('/update', 'TelaPedidoController@update');
	Route::get('/edit/{id}', 'TelaPedidoController@edit');
	Route::get('/delete/{id}', 'TelaPedidoController@delete');
});

Route::group(['prefix' => 'geraArquivo'], function(){
	Route::get('/pedidos', 'GeraArquivoController@pedidos');
	Route::get('/pedidosDelivery', 'GeraArquivoController@pedidosDelivery');
});

Route::group(['prefix' => 'configEcommerce'], function(){
	Route::get('/', 'ConfigEcommerceController@index');
	Route::post('/save', 'ConfigEcommerceController@save');
	Route::get('/verSite', 'ConfigEcommerceController@verSite');
});

Route::group(['prefix' => 'categoriaEcommerce'],function(){
	Route::get('/', 'CategoriaProdutoEcommerceController@index');
	Route::get('/delete/{id}', 'CategoriaProdutoEcommerceController@delete');
	Route::get('/edit/{id}', 'CategoriaProdutoEcommerceController@edit');
	Route::get('/new', 'CategoriaProdutoEcommerceController@new');

	Route::post('/save', 'CategoriaProdutoEcommerceController@save');
	Route::post('/update', 'CategoriaProdutoEcommerceController@update');
});

Route::group(['prefix' => 'clienteEcommerce'],function(){
	Route::get('/', 'ClienteEcommerceController@index');
	Route::get('/delete/{id}', 'ClienteEcommerceController@delete');
	Route::get('/edit/{id}', 'ClienteEcommerceController@edit');
	Route::get('/new', 'ClienteEcommerceController@new');

	Route::post('/save', 'ClienteEcommerceController@save');
	Route::post('/update', 'ClienteEcommerceController@update');
});

Route::group(['prefix' => 'enderecosEcommerce'],function(){
	Route::get('/{cliente_id}', 'EnderecoEcommerceController@index');
	Route::get('/edit/{id}', 'EnderecoEcommerceController@edit');
	Route::post('/update', 'EnderecoEcommerceController@update');

});

Route::group(['prefix' => 'produtoEcommerce'], function(){
	Route::get('/', 'ProdutoEcommerceController@index');
	Route::get('/delete/{id}', 'ProdutoEcommerceController@delete');
	Route::get('/deleteImagem/{id}', 'ProdutoEcommerceController@deleteImagem');
	Route::get('/edit/{id}', 'ProdutoEcommerceController@edit');
	Route::get('/editGrade/{id}', 'ProdutoEcommerceController@editGrade');
	Route::get('/listGrade/{referecia}', 'ProdutoEcommerceController@listGrade');
	Route::get('/galeria/{id}', 'ProdutoEcommerceController@galeria');
	Route::get('/deleteImagem/{id}', 'ProdutoEcommerceController@deleteImagem');
	Route::get('/new', 'ProdutoEcommerceController@new');
	Route::get('/pesquisa', 'ProdutoEcommerceController@pesquisa');

	Route::post('/save', 'ProdutoEcommerceController@save');
	Route::post('/update', 'ProdutoEcommerceController@update');
	Route::post('/saveImagem', 'ProdutoEcommerceController@saveImagem');

	Route::get('/alterarStatus/{id}', 'ProdutoEcommerceController@alterarStatus');
	Route::get('/alterarControlarEstoque/{id}', 
		'ProdutoEcommerceController@alterarControlarEstoque');
	Route::get('/alterarDestaque/{id}', 'ProdutoEcommerceController@alterarDestaque');

});

Route::group(['prefix' => 'pedidosEcommerce'], function(){
	Route::get('/', 'PedidoEcommerceController@index');
	Route::get('/filtro', 'PedidoEcommerceController@filtro');
	Route::get('/detalhar/{id}', 'PedidoEcommerceController@detalhar');
	Route::get('/gerarNFe/{id}', 'PedidoEcommerceController@gerarNFe');
	Route::get('/imprimir/{id}', 'PedidoEcommerceController@imprimir');

	Route::post('/salvarVenda', 'PedidoEcommerceController@salvarVenda');
	Route::get('/delete/{id}', 'PedidoEcommerceController@delete');
	Route::get('/verificaPagamentos', 'PedidoEcommerceController@verificaPagamentos');

	Route::post('/alterarStatus', 'PedidoEcommerceController@alterarStatus');

});

Route::group(['prefix' => 'carrosselEcommerce'],function(){
	Route::get('/', 'CarrosselEcommerceController@index');
	Route::get('/delete/{id}', 'CarrosselEcommerceController@delete');
	Route::get('/edit/{id}', 'CarrosselEcommerceController@edit');
	Route::get('/new', 'CarrosselEcommerceController@new');

	Route::post('/save', 'CarrosselEcommerceController@save');
	Route::post('/update', 'CarrosselEcommerceController@update');
});

Route::group(['prefix' => 'autorPost'],function(){
	Route::get('/', 'AutorPostController@index');
	Route::get('/delete/{id}', 'AutorPostController@delete');
	Route::get('/edit/{id}', 'AutorPostController@edit');
	Route::get('/new', 'AutorPostController@new');

	Route::post('/save', 'AutorPostController@save');
	Route::post('/update', 'AutorPostController@update');
});

Route::group(['prefix' => 'categoriaPosts'],function(){
	Route::get('/', 'CategoriaPostController@index');
	Route::get('/delete/{id}', 'CategoriaPostController@delete');
	Route::get('/edit/{id}', 'CategoriaPostController@edit');
	Route::get('/new', 'CategoriaPostController@new');

	Route::post('/save', 'CategoriaPostController@save');
	Route::post('/update', 'CategoriaPostController@update');
});

Route::group(['prefix' => 'postBlog'],function(){
	Route::get('/', 'PostblogController@index');
	Route::get('/delete/{id}', 'PostblogController@delete');
	Route::get('/edit/{id}', 'PostblogController@edit');
	Route::get('/new', 'PostblogController@new');

	Route::post('/save', 'PostblogController@save');
	Route::post('/update', 'PostblogController@update');
});

Route::group(['prefix' => 'contatoEcommerce'],function(){
	Route::get('/', 'ContatoEcommerceController@index');
	Route::get('/pesquisa', 'ContatoEcommerceController@pesquisa');
	Route::get('/delete/{id}', 'ContatoEcommerceController@delete');
});

Route::group(['prefix' => 'informativoEcommerce'],function(){
	Route::get('/', 'InformativoController@index');
	Route::get('/pesquisa', 'InformativoController@pesquisa');
	Route::get('/delete/{id}', 'InformativoController@delete');
});

Route::group(['prefix' => 'loja'], function(){
	Route::get('', 'EcommerceController@index');
	Route::get('/categorias', 'EcommerceController@categorias');
	Route::get('/{id}/categorias', 'EcommerceController@produtosDaCategoria');

	//blog
	Route::get('/blog', 'EcommerceController@blog');
	Route::get('/contato', 'EcommerceController@contato');
	Route::get('/{id}/verPost', 'EcommerceController@verPost');
	Route::get('/{id}/verProduto', 'EcommerceController@verProduto');

	Route::post('/addProduto', 'EcommerceController@addProduto');
	Route::get('/carrinho', 'EcommerceController@carrinho');
	Route::get('/curtidas', 'EcommerceController@curtidas');
	Route::get('/{id}/deleteItemCarrinho', 'EcommerceController@deleteItemCarrinho');
	Route::get('/{id}/deleteItemCarrinho', 'EcommerceController@deleteItemCarrinho');
	Route::get('/carrinho/atualizaItem', 'EcommerceController@atualizaItem');

	Route::get('/checkout', 'EcommerceController@checkout');
	Route::post('/checkout', 'EcommerceController@checkoutStore');
	Route::get('/logoff', 'EcommerceController@logoff');
	Route::get('/login', 'EcommerceController@login');
	Route::post('/login', 'EcommerceController@loginPost');
	Route::get('/pagamento', 'EcommerceController@pagamento');
	// Route::get('/{link}/pagamento', 'EcommerceController@pagamento');
	Route::get('/endereco', 'EcommerceController@endereco');
	Route::get('/esquecisenha', 'EcommerceController@esquecisenha');
	Route::post('/esquecisenha', 'EcommerceController@esquecisenhaPost');
	Route::get('/{id}/curtirProduto', 'EcommerceController@curtirProduto');

	Route::get('/pedido_detalhe/{id}', 'EcommerceController@pedidoDetalhe');
	Route::get('/pesquisa', 'EcommerceController@pesquisa');


});

Route::post('/ecommerceContato', 'EcommerceController@saveContato');
Route::post('/ecommerceInformativo', 'EcommerceController@saveInformativo');
Route::get('/ecommerceCalculaFrete', 'EcommerceController@calculaFrete');
Route::post('/ecommerceSetaFrete', 'EcommerceController@setaFrete');
Route::post('/ecommerceUpdateCliente', 'EcommerceController@ecommerceUpdateCliente');
Route::post('/ecommerceUpdateSenha', 'EcommerceController@ecommerceUpdateSenha');
Route::post('/ecommerceSaveEndereco', 'EcommerceController@ecommerceSaveEndereco');

Route::group(['prefix' => 'ecommercePay'], function(){
	Route::post('/boleto', 'EcommercePayController@paymentBoleto');
	Route::post('/pix', 'EcommercePayController@paymentPix');
	Route::get('/consulta/{transacao_id}', 'EcommercePayController@consultaPagamento');
	Route::get('/finalizado/{hash}', 'EcommercePayController@finalizado');
});
