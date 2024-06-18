<!DOCTYPE html>

<html lang="br">
<!-- begin::Head -->

<head>
	<meta charset="utf-8" />

	<title>{{$title}}</title>
	<meta name="description" content="Updates and statistics">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--begin::Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

	<link href="/metronic/css/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<!-- <link href="/metronic/css/uppy.bundle.css" rel="stylesheet" type="text/css" /> -->
	<link href="/metronic/css/wizard.css" rel="stylesheet" type="text/css" />

	<link href="/css/style.css" rel="stylesheet" type="text/css" />

	<!--end::Page Vendors Styles -->
	@if($tema == 2)
	<link href="/css/escuro.css" rel="stylesheet" type="text/css" />
	@endif

	<!--begin::Global Theme Styles(used by all pages) -->
	<link href="/metronic/css/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />

	<link href="/metronic/css/pricing.css" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles -->

	<!--begin::Layout Skins(used by all pages) -->

	<link href="/metronic/css/light.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/light-menu.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/dark-brand.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/dark-aside.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	
	<script>
		(function(h, o, t, j, a, r) {
			h.hj = h.hj || function() {
				(h.hj.q = h.hj.q || []).push(arguments)
			};
			h._hjSettings = {
				hjid: 1070954,
				hjsv: 6
			};
			a = o.getElementsByTagName('head')[0];
			r = o.createElement('script');
			r.async = 1;
			r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
			a.appendChild(r);
		})(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
	</script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async="async" src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'UA-37564768-1');
	</script>


	<style type="text/css">
		.select2-selection__arrow:before {
			content: "";
			position: absolute;
			right: 7px;
			top: 42%;
			border-top: 5px solid #888;
			border-left: 4px solid transparent;
			border-right: 4px solid transparent;
		}
		.no-padding{
			padding-left: 0 !important;
			padding-right: 0 !important;
		}
		.ativo{
			background-color: #55C6BD;
			color: #fff;
		}
		.desativo{
			background-color: #EBEDF3;
			color: #000;
		}
		.img-prod{
			height: 100px;
			border-radius: 50%;
			margin-top: 5px;
		}
		@media only screen and (max-width: 1000px) {
			#div-categorias{
				display: none;
			}
		}
		@media only screen and (min-width: 1001px) and (max-width: 3000px){
			#div-categorias{
				display: inline
			}
		}
		#atalho_add:hover{
			cursor: pointer;
		}

		.money-cel{
			width: 120px;
			height: 50px;
		}

		.money-moeda{
			width: 80px;
		}

		#focus-codigo:hover{
			cursor: pointer
		}

	</style>
	<style type="text/css">
		.select2-selection__arroww:before {
			content: "";
			position: absolute;
			right: 7px;
			top: 42%;
			border-top: 5px solid #888;
			border-left: 4px solid transparent;
			border-right: 4px solid transparent;
		}
	</style>
</head>


<!-- end::Head -->

<!-- begin::Body -->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

	<input type="hidden" id="produtos" value="{{json_encode($produtos)}}" name="">
	<input type="hidden" id="categorias" value="{{json_encode($categorias)}}" name="">
	<input type="hidden" id="clientes" value="{{json_encode($clientes)}}" name="">
	<input type="hidden" id="agendamento_id" value="{{$agendamento_id ?? 0}}" name="">

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<input type="hidden" id="valor_entrega" @if(isset($valor_entrega)) value="{{$valor_entrega}}" @else value='0' @endif>
	
	@if(isset($itens))
	<input type="hidden" id="itens_pedido" value="{{json_encode($itens)}}">
	<input type="hidden" id="valor_total" @if(isset($valor_total)) value="{{$valor_total}}" @else value='0' @endif>
	<input type="hidden" id="delivery_id" @if(isset($delivery_id)) value="{{$delivery_id}}" @else value='0' @endif>
	<input type="hidden" id="bairro" @if(isset($bairro)) value="{{$bairro}}" @else value='0' @endif>
	
	@endif

	<input type="hidden" id="codigo_comanda_hidden" @if(isset($cod_comanda)) value="{{$cod_comanda}}" @else value='0' @endif name="">

	<input type="hidden" id="PDV_VALOR_RECEBIDO" @if(isset($atalhos)) value="{{$atalhos->valor_recebido_automatico}}" @else value='0' @endif>
	<input type="hidden" id="ATALHOS" value="{{ json_encode($atalhos) }}">

	<input type="hidden" id="ID_COD_BARRAS_BALANCA" value="{{ getenv('ID_COD_BARRAS_BALANCA') }}">
	<input type="hidden" id="IMPRIMIR_CUPOM_AUTOMATICO" value="{{ getenv('IMPRIMIR_CUPOM_AUTOMATICO') }}">

	<div class="card card-custom gutter-b example example-compact">
		<div class="col-lg-12">
			<div class="container">
				<div class="row" style="margin-top: 10px;">

					<div class="col-sm-2 col-lg-2 col-xl-4 col-md-6 col-6">

						<h4><strong id="timer">00:00:00</strong></h4>
					</div>

					<div class="col-sm-4 col-lg-4 col-md-6 col-xl-6 col-6">
						<h4>Ambiente: <strong class="text-success">{{session('user_logged')['ambiente']}}</strong>
						</h4>
					</div>

					<div class="col-sm-6 col-lg-6 col-xl-2 col-md-12 col-12">

						<div class="dropdown dropdown-inline show" data-toggle="tooltip" title="" data-placement="left">
							<a href="/frenteCaixa/list" class="btn btn-light-danger">
								<i class="la la-angle-double-left"></i>
								
								Sair
								<!--end::Svg Icon-->
							</a>
							<a href="#" class="btn btn-light-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Açoes
								<i class="la la-angle-down"></i>
								<!--end::Svg Icon-->

							</a>

							<div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 m-0 " style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-211px, 39px, 0px);" x-placement="bottom-end">
								<!--begin::Navigation-->
								<ul class="navi navi-hover">
									<li class="navi-header font-weight-bold py-4">
										<span class="font-size-lg">Selecione:</span>
									</li>
									<li class="navi-separator mb-3 opacity-70"></li>

									<li class="navi-item">
										<a href="/frenteCaixa/list" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-success">Lista de vendas</span>
											</span>
										</a>
									</li>
									<li class="navi-item">
										<a href="/frenteCaixa/devolucao" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-danger">Devolução</span>
											</span>
										</a>
									</li>
									<li class="navi-item">
										<a data-toggle="modal" href="#!" data-target="#modal2" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-dark">Sangria</span>
											</span>
										</a>
									</li>

									<li class="navi-item">
										<a data-toggle="modal" href="#!" data-target="#modal-supri" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-warning">Suprimento de Caixa</span>
											</span>
										</a>
									</li>
									<li class="navi-item">
										<a data-toggle="modal" href="#!" data-target="#modal3" onclick="fluxoDiario()" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-primary">
													Fluxo Diário
												</span>
											</span>
										</a>
									</li>
									<li class="navi-item">
										<a data-toggle="modal" href="#!" data-target="#modal-comanda" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-success">Apontar Comanda</span>
											</span>
										</a>
									</li>
									@if(getenv("APONTARMENSA") == 1)
									<li class="navi-item">
										<a data-toggle="modal" id="btn-modal-mesa" data-target="#modal-mesa" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-success">Apontar Mesa</span>
											</span>
										</a>
									</li>
									@endif

									<li class="navi-item">
										<a href="/frenteCaixa/fechar" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-danger">
													Fechar Caixa
												</span>
											</span>
										</a>
									</li>

									<li class="navi-item">
										<a href="/frenteCaixa/config" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-dark">
													Configuração
												</span>
											</span>
										</a>
									</li>

									<li class="navi-item">
										<a href="/frenteCaixa/list" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-info">
													Sair
												</span>
											</span>
										</a>
									</li>
								</ul>

							</div>
						</div>
					</div>

				</div>


			</div>
			<input autofocus type="" style="border: none; width: 0px; height: 0px; " id="codBarras" name="">


			<hr>
			<div class="row">

				<div class="col-sm-12 col-lg-7 col-md-12 col-12">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<div class="row align-items-center" style="margin-top: 10px;">
								<div class="form-group validated col-sm-6 col-lg-6 col-12 col-sm-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="focus-codigo">
												<li class="la la-barcode"></li>
											</span>
										</div>
										<select class="form-control select2" id="kt_select2_1" name="produto">
											<option>Selecione um produto, ou use código de barra</option>
											@foreach($produtos as $p)
											<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
											@endforeach
										</select>

									</div>
								</div>

								<div class="form-group validated col-sm-2 col-lg-2 col-5 col-sm-5">
									<div class="">
										<input id="valor_item" placeholder="Valor" type="text" class="form-control" name="valor" value="0.00">

									</div>
								</div>

								<div class="form-group validated col-sm-2 col-lg-2 col-5 col-sm-5">
									<div class="">
										<input id="quantidade" placeholder="QTD" type="text" class="form-control" name="quantidade" value="1">

									</div>
								</div>

								<div class="form-group validated col-sm-2 col-lg-2 col-6 col-sm-6">
									<button id="adicionar-item" type="submit" class="btn btn-success">Adicionar</button>
								</div>
							</div>
						</div>
						<div class="card-body" style="height: 445px;">

							<div class="col-xl-12">
								<div class="row">
									<div class="col-xl-12">
										<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" >

											<table class="datatable-table" style="max-width: 100%; overflow: scroll; max-height: 420px;">
												<thead class="datatable-head">
													<tr class="datatable-row" style="left: 0px;">
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 50px;">ITEM</span></th>
														<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 50px;">ID</span></th>
														<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">PRODUTO</span></th>
														<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">QTD</span></th>
														<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">VALOR</span></th>
														<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">SUBTOTAL</span></th>
													</tr>
												</thead>
												<tbody class="datatable-body" id="body">


												</tbody>

											</table>

										</div>
									</div>
								</div>

							</div>
						</div>

					</div>

					<div class="card card-custom gutter-b example example-compact" style="margin-top: -20px; height: auto;">
						<div class="card-body">
							<div class="row align-items-center">

								<div class="col-sm-3 col-lg-3 col-6">
									<label>Desconto: R$ <strong id="valor_desconto">0,00</strong></label>
									<button onclick="setaDesconto()" style="margin-left: 4px; margin-top: -10px;" class="btn btn-link-primary">
										<i class="la la-edit"></i>
									</button>
								</div>
								<div class="col-sm-3 col-lg-3 col-6">

									<label>Acrescimo: R$ <strong id="valor_acrescimo">0,00</strong></label>
									<button onclick="setaAcresicmo()" style="margin-left: 4px; margin-top: -10px;" class="btn btn-link-primary">
										<i class="la la-edit"></i>
									</button>
								</div>
								<div class="col-sm-2 col-lg-2 col-3">
									<label>Lista de Preços</label>
								</div>

								<div class="col-sm-4 col-lg-4 col-6" style="margin-top: -8px;">
									@if(isset($listaPreco))

									<select class="custom-select form-control" id="lista_id" name="lista_id">

										<option value="0">Padrão</option>
										@foreach($listaPreco as $l)
										<option value="{{$l->id}}">{{$l->nome}} - {{$l->percentual_alteracao}}%
										</option>
										@endforeach
									</select>

									@else


									<select class="custom-select form-control" id="lista_id" name="lista_id">

										<option value="0">Padrão</option>
									</select>


									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-5 col-lg-5 col-md-12 col-12" id="div-categorias">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<div class="row" style="height: 72px; overflow-x: auto; width: auto; white-space: nowrap">
								<div class="form-group validated col-sm-12 col-lg-12 col-12 col-sm-12" style="margin-top: 10px;">
									
									<div class="row">

										<div class="form-group validated col-sm-4 col-lg-4 col-4">

											<select id="tipo-pesquisa-pedido" class="custom-select">
												<option value="comanda">Comanda</option>
												<option value="mesa">Mesa</option>
											</select>

										</div>
										<div class="form-group validated col-sm-5 col-lg-5 col-5">

											<input type="text" placeholder="Buscar" id="cod-comanda2" name="cod-comanda2" class="form-control" value="">

										</div>
										<div class="form-group validated col-sm-3 col-lg-3 col-3">
											<button id="btn-apontar2" class="btn btn-info">Apontar</button>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="card-body" style="height: 533px; overflow-y: auto; ">
							<div class="row" id="">
								
								@if(session()->has('mensagem_sucesso'))
								<div class="row" style="background: #fff; height: 80px; width: 100%; margin-top: -25px">
									<div class="container">
										<div class="alert alert-custom alert-success fade show" role="alert" style="margin-top: 10px;">
											<div class="alert-icon"><i class="la la-check"></i></div>
											<div class="alert-text">{{ session()->get('mensagem_sucesso') }}</div>
											<div class="alert-close">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true"><i class="la la-close"></i></span>
												</button>
											</div>
										</div>
									</div>
								</div>
								@endif

								@if(session()->has('mensagem_erro'))
								<div class="row" style="background: #fff; height: 80px; margin-top: -25px">
									<div class="container">
										<div class="alert alert-custom alert-danger fade show" role="alert" style="margin-top: 10px;">
											<div class="alert-icon"><i class="la la-check"></i></div>
											<div class="alert-text">{{ session()->get('mensagem_erro') }}</div>
											<div class="alert-close">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true"><i class="la la-close"></i></span>
												</button>
											</div>
										</div>
									</div>
								</div>

								@endif
								<form class="row" method="post" action="/frenteCaixa/saveItemPedido">

									@if($pedido == null)
									<div class="form-group col-lg-3 col-md-2 col-sm-6 col-6">
										<label class="col-form-label">Comanda</label>
										<div class="">
											<div class="input-group">
												<input type="text" value="{{old('id')}}" name="id" class="form-control @if($errors->has('id')) is-invalid @endif" id="id"/>
												@if($errors->has('id'))
												<div class="invalid-feedback">
													{{ $errors->first('id') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="form-group validated col-sm-6 col-lg-5 col-12">
										<label class="col-form-label" id="">Mesa</label><br>
										<select class="form-control custom-select" style="width: 100%" name="mesa_id">
											<option value="null">Selecione a mesa</option>
											@foreach($mesas as $p)
											<option @if(old('mesa_id') == $p->id) selected @endif value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
											@endforeach
										</select>
										@if($errors->has('mesa_id'))
										<div class="invalid-feedback">
											{{ $errors->first('mesa_id') }}
										</div>
										@endif
									</div>
									@else

									<div class="col-12">
										<h4>Comanda: <strong class="text-info">{{$pedido->comanda}}</strong></h4>
									</div>
									<input type="hidden" id="pedido_id" name="id" @if($pedido != null) value="{{$pedido->comanda}}" @else value="0" @endif>

									@endif
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group validated col-sm-6 col-lg-5 col-12">
										<label class="col-form-label" id="">Produto</label><br>
										<select class="form-control select2" style="width: 100%" id="kt_select2_4" name="produto">
											<option value="0">Selecione o produto</option>
											@foreach($produtos as $p)
											<option @if(old('produto') == $p->id) selected @endif value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
											@endforeach
										</select>
										@if($errors->has('produto'))
										<div class="invalid-feedback">
											{{ $errors->first('produto') }}
										</div>
										@endif
									</div>
									<div class="form-group validated col-sm-5 col-lg-5 col-12">
										<label class="col-form-label" id="">Adicionais</label><br>
										<select class="form-control select2" style="width: 100%" id="kt_select2_2" name="adicional">
											<option value="0">Selecione o adicional</option>
											@foreach($adicionais as $a)
											<option value="{{$a->id}}">{{$a->id}} - {{$a->nome}} - R${{$a->valor}}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group col-lg-2 col-md-2 col-sm-6 col-6">
										<label class="col-form-label">Quantidade</label>
										<div class="">
											<div class="input-group">
												<input type="text" value="1.000" name="quantidade" class="form-control @if($errors->has('quantidade')) is-invalid @endif" id="quantidade"/>
												@if($errors->has('quantidade'))
												<div class="invalid-feedback">
													{{ $errors->first('quantidade') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									<div style="margin-top: -20px;" class="form-group col-lg-3 col-md-2 col-sm-6 col-6">
										<label class="col-form-label">Valor</label>
										<div class="">
											<div class="input-group">
												<input type="text" value="0" name="valor" class="form-control @if($errors->has('valor')) is-invalid @endif" id="valor"/>
												@if($errors->has('valor'))
												<div class="invalid-feedback">
													{{ $errors->first('valor') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									<div style="margin-top: -20px;" class="form-group col-lg-6 col-md-2 col-sm-6 col-6">
										<label class="col-form-label">Observação</label>
										<div class="">
											<div class="input-group">
												<input type="text" value="" name="observacao" class="form-control @if($errors->has('observacao')) is-invalid @endif" id="valor"/>
												@if($errors->has('observacao'))
												<div class="invalid-feedback">
													{{ $errors->first('observacao') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									<div style="margin-top: -20px;" class="col-lg-2 col-md-2 col-sm-6 col-6">
										<br>
										<button style="margin-top: 17px;" value="0" type="submit" class="btn btn-success">
											Adicionar
										</button>
									</div>
								</form>

							</div>
							@if($pedido != null)

							<div class="row">
								@foreach($pedido->itens as $i)
								<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4" id="atalho_add">
									<div class="card card-custom gutter-b example example-compact">
										<div class="card-body" >

											<h6 style="font-size: 12px;" class="kt-widget__label">
												{{$i->produto->nome}}
												@if($i->observacao != "")
												| OBS: {{$i->observacao}}
												@endif
												<?php $somaAdicionais = 0; ?>
												@foreach($i->itensAdicionais as $key => $a)
												{{$a->adicional->nome()}}
												<?php $somaAdicionais += $a->adicional->valor * $i->quantidade?>
												@if($key < count($i->itensAdicionais)-1)
												| 
												@endif
												@endforeach
											</h6>
											<h6 style="font-size: 12px;" class="text-info" class="kt-widget__label">

												{{number_format((($i->valor * $i->quantidade) + $somaAdicionais), 2, ',', '.')}}
											</h6>
											<a href="/frenteCaixa/deleteItemPedido/{{$i->id}}" class="btn btn-sm btn-outline-danger">
												<i class="la la-trash"></i>
											</a>
										</div>

									</div>
								</div>
								@endforeach
							</div>
							<a onclick="apontarComanda3('{{$pedido->comanda}}')" class="btn btn-info">Apontar e finalizar</a>

							<a href="/frenteCaixa/deletePedido/{{$pedido->id}}" class="btn btn-danger">Apagar pedido</a>
							@endif
						</div>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-sm-7 col-lg-7 col-md-12 col-12">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-body">

							<div class="row">
								<div class="form-group validated col-sm-2 col-lg-3 col-6 col-md-6" style="margin-top: 5px;">
									<div class="">
										<input type="text" placeholder="Valor recebido" id="valor_recebido" name="valor_recebido" class="form-control money" value="">
									</div>
								</div>
								<div class="form-group validated col-sm-3 col-lg-4 col-6 col-md-6" style="margin-top: 5px;">
									<div class="">
										<select class="custom-select form-control" id="tipo-pagamento" name="tipo-pagamento">
											<option value="--">Selecione o Tipo de pagamento</option>
											@foreach($tiposPagamento as $key => $t)
											<option 
											@if($config->tipo_pagamento_padrao == $key)
											selected
											@endif
											value="{{$key}}">{{$key}} - {{$t}}</option>
											@endforeach
										</select>
									</div>

								</div>

								<div class="form-group validated col-sm-6 col-lg-4 col-12 col-md-12">
									<div class="">

										<button id="finalizar-venda" style="width: 100%" class="btn btn-success btn-lg" disabled>
											<i class="la la-check"></i>
											Finalizar
											<strong id="total-venda">R$ 0,00</strong>
										</button>
									</div>
								</div>

								<div class="form-group validated col-sm-7 col-lg-6 col-12 col-md-12">
									<button id="click-client" class="btn btn-danger btn-lg">
										<i class="la la-user"></i>
									</button>
									<button id="click-multi" class="btn btn-info btn-lg">
										<i class="la la-list"></i>
									</button>
									<button onclick="setaObservacao()" class="btn btn-primary btn-lg">
										<i class="la la-marker"></i>
									</button>
									@isset($orcamentos)
									<button data-toggle="modal" data-target="#modal-orcamento"  class="btn btn-warning btn-lg">
										<i class="las la-clipboard-list"></i>
									</button>
									@endisset
								</div>


							</div>

						</div>
					</div>
				</div>

				<div class="col-sm-5 col-lg-5 col-md-12 col-12">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-body">
							<h4>Ultimos pedidos realizados</h4>
							@php
							$colors = ['danger', 'warning', 'success', 'info', 'dark'];
							@endphp
							<div class="row">
								
								@foreach($pedidos as $p)
								<a onclick="apontarComanda3('{{$p->comanda}}')" style="margin-top: 5px; margin-left: 5px;" class="btn btn-outline-{{$colors[rand(0,4)]}}">Comanda {{$p->comanda}} - R$ R$ {{number_format($p->somaItems(),2 , ',', '.')}} @if($p->mesa != null) | {{$p->mesa->nome}} @endif</a>
								@endforeach

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- Modals -->
		<input type="hidden" id="_token" value="{{csrf_token()}}" name="">

		<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">É necessário abrir o caixa com um valor</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12">
								<label class="col-form-label" id="">Valor</label>
								<div class="">
									<input type="text" id="valor" name="valor" class="form-control money" value="">
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
						<button type="button" onclick="abrirCaixa()" class="btn btn-light-success font-weight-bold">Abrir</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-pag-mult" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">PAGAMENTO MULTIPLO R$ <strong class="text-danger" id="v-multi"></strong></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Tipo de pagamento 1</label>
								<select class="custom-select form-control" id="tipo_pagamento_1" name="tipo_pagamento_1">
									@foreach(App\Models\VendaCaixa::tiposPagamento() as $key => $t)
									<option value="{{$key}}">{{$t}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Valor de pagamento 1</label>
								<input type="text" placeholder="Valor" id="valor_pagamento_1" name="valor_pagamento_1" class="form-control money" value="">
							</div>
						</div>

						<div class="row">
							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Tipo de pagamento 2</label>
								<select class="custom-select form-control" id="tipo_pagamento_2" name="tipo_pagamento_2">
									@foreach(App\Models\VendaCaixa::tiposPagamento() as $key => $t)
									<option value="{{$key}}">{{$t}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Valor de pagamento 2</label>
								<input type="text" placeholder="Valor" id="valor_pagamento_2" name="valor_pagamento_2" class="form-control money" value="">
							</div>
						</div>

						<div class="row">
							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Tipo de pagamento 3</label>
								<select class="custom-select form-control" id="tipo_pagamento_3" name="tipo_pagamento_3">
									@foreach(App\Models\VendaCaixa::tiposPagamento() as $key => $t)
									<option value="{{$key}}">{{$t}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Valor de pagamento 3</label>
								<input type="text" placeholder="Valor" id="valor_pagamento_3" name="valor_pagamento_3" class="form-control money" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
						<button type="button" id="btn-ok-multi" class="btn btn-light-success font-weight-bold" disabled="">OK</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-venda" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">FINALIZAR VENDA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-4 col-lg-4 col-12 @if($certificado == null) disabled @endif">
								<button @if($certificado == null) disabled @endif class="btn btn-success" onclick="verificaCliente()" style="height: 50px; width: 100%">
									CUPOM FISCAL
									@if($certificado == null)
									<br>
									<b class="text-danger">Sem certificado</b>
									@endif
								</button>
							</div>
							@if($usuario->venda_nao_fiscal == 1)
							<div class="form-group validated col-sm-4 col-lg-4 col-12">
								<button class="btn btn-info" id="btn_nao_fiscal" onclick="finalizarVenda('nao_fiscal')" style="height: 50px; width: 100%">
									CUPOM NÃO FISCAL
								</button>
							</div>
							@endif

							<div class="form-group validated col-sm-4 col-lg-4 col-12">
								<button class="btn btn-warning disabled" id="conta_credito-btn" onclick="finalizarVenda('credito')" style="height: 50px; width: 100%">
									CONTA CRÉDITO
								</button>
							</div>


						</div>


					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-cpf-nota" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">CPF/CNPJ NA NOTA?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<input type="hidden" id="nome" name="nome" class="form-control money" value="">
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-4 col-lg-4 col-12">
								<label class="col-form-label">TIPO</label>
								<select class="custom-select" id="select-doc">
									<option selected value="CPF">CPF</option>
									<option value="CNPJ">CNPJ</option>
								</select>
							</div>
							<div class="form-group validated col-sm-8 col-lg-8 col-12">
								<label class="col-form-label" id="tipo-doc">CPF</label>
								<input type="text" placeholder="CPF" id="cpf" name="cpf" class="form-control pula" value="">
							</div>
						</div>

						<div class="row">
							<div class="form-group validated col-12">
								<label class="col-form-label">Nome (opcional)</label>
								<input type="text" placeholder="Nome" id="nome-cpf" name="nome" class="form-control pula" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" id="btn-cpf" type="button" onPress="finalizarVenda('fiscal')" onclick="finalizarVenda('fiscal')" class="btn btn-success font-weight-bold spinner-white spinner-right pula">EMITIR</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-cliente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">SELECIONAR CLIENTE</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<input type="hidden" id="nome" name="nome" class="form-control money" value="">
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Cliente</label><br>
								<select class="form-control select2" style="width: 100%" id="kt_select2_3" name="cliente">
									<option value="null">Selecione o cliente</option>
									@foreach($clientes as $c)
									<option value="{{$c->id}}">{{$c->id}} - {{$c->razao_social}}</option>
									@endforeach
								</select>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
						<button type="button" onclick="selecionarCliente()" class="btn btn-light-success font-weight-bold">OK</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">SANGRIA DE CAIXA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-6 col-lg-6 col-6">
								<label class="col-form-label" id="">Valor</label>
								<input type="text" placeholder="Valor" id="valor_sangria" name="valor_sangria" class="form-control" value="">
							</div>
						</div>

						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Observação</label>
								<input type="text" placeholder="Observação" id="obs_sangria" name="obs" class="form-control" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="sangriaCaixa()" class="btn btn-success font-weight-bold">OK</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-supri" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">SUPRIMENTO DE CAIXA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-6 col-lg-6 col-6">
								<label class="col-form-label" id="">Valor</label>
								<input type="text" placeholder="Valor" id="valor_suprimento" name="valor_sangria" class="form-control money" value="">
							</div>
						</div>

						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Observação</label>
								<input type="text" placeholder="Observação" id="obs_suprimento" name="obs" class="form-control" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="suprimentoCaixa()" class="btn btn-success font-weight-bold">OK</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal3" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">FLUXO DIÁRIO</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>

					<div class="modal-body">

						<div class="row" style="height: 350px; overflow-y: auto;">
							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Abertura de Caixa:</h5>
								<div id="fluxo_abertura_caixa"></div>
							</div>

							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Sangrias:</h5>
								<div id="fluxo_sangrias"></div>
							</div>

							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Suprimentos:</h5>
								<div id="fluxo_suprimentos"></div>
							</div>

							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Vendas:</h5>
								<div id="fluxo_vendas"></div>
							</div>

							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Total em caixa: 
									<strong id="total_caixa" class="text-success"></strong></h5>
								</div>
							</div>
						</div>


					</div>

				</div>
			</div>
		</div>

		<div class="modal fade" id="modal4" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">SUGESTÃO DE TROCO</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>

					<div class="modal-body">
						<h2>Valor do troco: <strong id="valor_troco" class="text-danger">0,00</strong></h2>

						<div class="row" style="height: 460px; overflow-y: auto;">
							<div class="col-sm-12 col-lg-12 col-12">

								<div class="row 100_reais" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/100_reais.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_100_reais"></h4>
									</div>
								</div>

								<div class="row 50_reais" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/50_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_50_reais"></h4>
									</div>
								</div>
								<div class="row 20_reais" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/20_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_20_reais"></h4>
									</div>
								</div>

								<div class="row 10_reais" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/10_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_10_reais"></h4>
									</div>
								</div>

								<div class="row 5_reais" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/5_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_5_reais"></h4>
									</div>
								</div>

								<div class="row 2_reais" style="display: none">

									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/2_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_2_reais"></h4>
									</div>
								</div>

								<div class="row 1_real" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/1_real.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_1_real"></h4>
									</div>
								</div>

								<div class="row 50_centavo" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/50_centavo.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_50_centavos"></h4>
									</div>
								</div>

								<div class="row 25_centavo" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/25_centavo.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_25_centavos"></h4>
									</div>
								</div>

								<div class="row 10_centavo" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/10_centavo.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_10_centavos"></h4>
									</div>
								</div>


								<div class="row 5_centavo" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/5_centavo.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_5_centavos"></h4>
									</div>
								</div>
							</div>
						</div>


					</div>

				</div>
			</div>
		</div>

		<div id="modal4" class="modal">
			<div class="modal-content">
				<div class="row">
					<h4>Valor do troco: <strong id="valor_troco" class="orange-text">0,00</strong></h4>

					<h5>Sugestão:</h5>
					<div class="row 50_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/50_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_50_reais"></h4>
						</div>
					</div>
					<div class="row 20_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/20_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_20_reais"></h4>
						</div>
					</div>

					<div class="row 10_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/10_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_10_reais"></h4>
						</div>
					</div>

					<div class="row 5_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/5_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_5_reais"></h4>
						</div>
					</div>

					<div class="row 2_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/2_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_2_reais"></h4>
						</div>
					</div>

					<div class="row 1_real" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/1_real.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_1_real"></h4>
						</div>
					</div>

					<div class="row 50_centavo" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/50_centavo.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_50_centavos"></h4>
						</div>
					</div>

					<div class="row 25_centavo" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/25_centavo.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_25_centavos"></h4>
						</div>
					</div>

					<div class="row 10_centavo" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/10_centavo.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_10_centavos"></h4>
						</div>
					</div>


					<div class="row 5_centavo" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/5_centavo.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_5_centavos"></h4>
						</div>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<div class="modal-footer">
					<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
				</div>

			</div>
		</div>

		<div class="modal fade" id="modal-cartao" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">INFORME OS DADOS DO CARTÃO</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-3 col-lg-3 col-6">
								<label class="col-form-label">Bandeira</label>
								<select class="custom-select" id="bandeira_cartao">
									<option value="">--</option>
									@foreach(App\Models\VendaCaixa::bandeiras() as $key => $b)
									<option value="{{$key}}">{{$b}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group validated col-sm-4 col-lg-4 col-6">
								<label class="col-form-label">Código autorização(opcional)</label>
								<input type="text" placeholder="Código autorização" id="cAut_cartao" class="form-control" value="">
							</div>

							<div class="form-group validated col-sm-4 col-lg-5 col-12">
								<label class="col-form-label">CNPJ(opcional)</label>
								<input type="text" placeholder="CNPJ" id="cnpj_cartao" data-mask="00.000.000/0000-00" name="cnpj_cartao" class="form-control" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" data-dismiss="modal" class="btn btn-success font-weight-bold">Salvar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-pag-outros" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">INFORME A DESCRIÇAO DO TIPO DE PAGAMENTO OUTROS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">


							<div class="form-group validated col-12">
								<label class="col-form-label">Descrição</label>
								<input type="text" placeholder="Descrição" id="descricao_pag_outros" name="descricao_pag_outros" class="form-control" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" data-dismiss="modal" class="btn btn-success font-weight-bold">Salvar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-comanda" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">INFORME O CÓDIGO DA COMANDA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Código da comanda</label>
								<input type="text" placeholder="Comanda" id="cod-comanda" name="cod-comanda" class="form-control" value="">
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="apontarComanda()" class="btn btn-success font-weight-bold">APONTAR</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-itens" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">ITENS DA COMANDA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">

						<div class="row">
							<div class="col-12">
								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
									<table>
										<thead class="datatable-table" style="max-width: 100%; overflow: scroll">
											<tr class="datatable-row" style="left: 0px;">
												<th class="datatable-cell datatable-cell-sort" style="width: 300px;">Produto</th>
												<th class="datatable-cell datatable-cell-sort" style="width: 120px;">Qtd</th>
												<th class="datatable-cell datatable-cell-sort" style="width: 120px;">Valor Unit.</th>
												<th class="datatable-cell datatable-cell-sort" style="width: 120px;">Subtotal</th>
											</tr>
										</thead>

										<tbody id="table-itens" class="datatable-body">

										</tbody>

									</table>
								</div>

							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="apontarComanda2()" class="btn btn-success font-weight-bold">APONTAR</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-mesa" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">MESAS ABERTAS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row prt">

							<div class="col-6">
								<input placeholder="pesquise a mesa..." type="" class="form-control" id="pesquisa-mesa" name="">
							</div>
						</div>

						<br>
						<div class="row">
							<div class="col-12" id="body-mesas">

							</div>

							<div class="col-12" id="comandas-mesa">

							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-obs" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">OBSERVAÇÃO</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Observação</label>
								<input type="text" placeholder="Observação" id="obs" class="form-control" @if(isset($observacao)) value="{{$observacao}}" @endif>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="apontarObs()" class="btn btn-success font-weight-bold">OK</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-orcamento" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Busca Orçamento</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Orçamento</label>
								<br>
								<select style="width: 100%" class="form-control select2" id="kt_select2_4" name="orcamento_id">
									<option value="">Selecione um orçamento</option>
									@isset($orcamentos)
									@foreach($orcamentos as $o)
									<option value="{{$o->id}}">({{$o->id}}) OBS: {{$o->observacao}}, Valor: R$ {{$o->valor_total}}, Cliente: {{$o->cliente->razao_social}}</option>
									@endforeach
									@endisset
								</select>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="apontarOrcamento()" class="btn btn-success font-weight-bold">Apontar</button>
					</div>
				</div>
			</div>
		</div>


		<script>
			var KTAppSettings = {
				"breakpoints": {
					"sm": 576,
					"md": 768,
					"lg": 992,
					"xl": 1200,
					"xxl": 1400
				},
				"colors": {
					"theme": {
						"base": {
							"white": "#ffffff",
							"primary": "#3699FF",
							"secondary": "#E5EAEE",
							"success": "#1BC5BD",
							"info": "#8950FC",
							"warning": "#FFA800",
							"danger": "#F64E60",
							"light": "#E4E6EF",
							"dark": "#181C32"
						},
						"light": {
							"white": "#ffffff",
							"primary": "#E1F0FF",
							"secondary": "#EBEDF3",
							"success": "#C9F7F5",
							"info": "#EEE5FF",
							"warning": "#FFF4DE",
							"danger": "#FFE2E5",
							"light": "#F3F6F9",
							"dark": "#D6D6E0"
						},
						"inverse": {
							"white": "#ffffff",
							"primary": "#ffffff",
							"secondary": "#3F4254",
							"success": "#ffffff",
							"info": "#ffffff",
							"warning": "#ffffff",
							"danger": "#ffffff",
							"light": "#464E5F",
							"dark": "#ffffff"
						}
					},
					"gray": {
						"gray-100": "#F3F6F9",
						"gray-200": "#EBEDF3",
						"gray-300": "#E4E6EF",
						"gray-400": "#D1D3E0",
						"gray-500": "#B5B5C3",
						"gray-600": "#7E8299",
						"gray-700": "#5E6278",
						"gray-800": "#3F4254",
						"gray-900": "#181C32"
					}
				},
				"font-family": "Poppins"
			};
		</script>

		<!-- end::Global Config -->
		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="/metronic/js/plugins.bundle.js" type="text/javascript"></script>
		<script src="/metronic/js/prismjs.bundle.js" type="text/javascript"></script>
		<script src="/metronic/js/scripts.bundle.js" type="text/javascript"></script>
		<script src="/metronic/js/wizard.js" type="text/javascript"></script>

		<script src="/metronic/js/fullcalendar.bundle.js" type="text/javascript"></script>
		<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
		<script src="/metronic/js/gmaps.js" type="text/javascript"></script>
		<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="/js/mascaras.js"></script>
		<script src="/metronic/js/select2.js" type="text/javascript"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script> -->
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

		<?php $path = getenv('PATH_URL') . "/"; ?>
		<script type="text/javascript">
			let prot = window.location.protocol;
			let host = window.location.host;
			const path = prot + "//" + host + "/";
		</script>

		<script type="text/javascript" src="/js/mousetrap.js"></script>
		<script type="text/javascript" src="/js/frenteCaixa.js"></script>

		<script>

			jQuery(document).ready(function() {

				KTSelect2.init();

				// $('.select2-selection__rendered').html('Selecione')
				// let t = $('.select2-selection__rendered').attr('placeholder', 'esdsd')
				// $('#kt_select2_4').val('')
				// $('#kt_select2_2').val('')
				
				

				$('.select2-selection__arrow').addClass('select2-selection__arroww')
				$('.select2-selection__arrow').removeClass('select2-selection__arrow')
				var KTBootstrapDatepicker = function() {

					var arrows;
					if (KTUtil.isRTL()) {
						arrows = {
							leftArrow: '<i class="la la-angle-right"></i>',
							rightArrow: '<i class="la la-angle-left"></i>'
						}
					} else {
						arrows = {
							leftArrow: '<i class="la la-angle-left"></i>',
							rightArrow: '<i class="la la-angle-right"></i>'
						}
					}

					// Private functions
					var demos = function() {

						// minimum setup
						$('#kt_datepicker_1').datepicker({
							rtl: KTUtil.isRTL(),
							todayHighlight: true,
							orientation: "bottom left",
							templates: arrows
						});

						// minimum setup for modal demo
						$('#kt_datepicker_1_modal').datepicker({
							rtl: KTUtil.isRTL(),
							todayHighlight: true,
							orientation: "bottom left",
							templates: arrows
						});

						// input group layout
						$('#kt_datepicker_2').datepicker({
							rtl: KTUtil.isRTL(),
							todayHighlight: true,
							orientation: "bottom left",
							templates: arrows
						});

						// input group layout for modal demo
						$('#kt_datepicker_2_modal').datepicker({
							rtl: KTUtil.isRTL(),
							todayHighlight: true,

							orientation: "bottom left",
							templates: arrows
						});

						// enable clear button
						$('#kt_datepicker_3, #kt_datepicker_3_validate').datepicker({
							rtl: KTUtil.isRTL(),
							todayBtn: "linked",
							clearBtn: false,
							format: 'dd/mm/yyyy',
							todayHighlight: false,
							templates: arrows
						});

						// enable clear button for modal demo
						$('#kt_datepicker_3_modal').datepicker({
							rtl: KTUtil.isRTL(),
							todayBtn: "linked",
							clearBtn: false,
							format: 'dd/mm/yyyy',
							todayHighlight: false,
							templates: arrows
						});

						// orientation
						$('#kt_datepicker_4_1').datepicker({
							rtl: KTUtil.isRTL(),
							orientation: "top left",
							todayHighlight: true,
							templates: arrows
						});

						$('#kt_datepicker_4_2').datepicker({
							rtl: KTUtil.isRTL(),
							orientation: "top right",
							todayHighlight: true,
							templates: arrows
						});

						$('#kt_datepicker_4_3').datepicker({
							rtl: KTUtil.isRTL(),
							orientation: "bottom left",
							todayHighlight: true,
							templates: arrows
						});


					}


					return {

						init: function() {
							demos();
						}
					};
				}();

				KTBootstrapDatepicker.init({
					format: 'dd/mm/yyyy'
				});

			});

			setInterval(() => {
				let hora = formatar(new Date())
				$('#timer').html(hora)
			}, 1000)

			const formatar = (data) => {
				const hora = data.getHours() < 10 ? '0'+data.getHours() : data.getHours();
				const min = data.getMinutes() < 10 ? '0'+data.getMinutes() : data.getMinutes();
				const seg = data.getSeconds() < 10 ? '0'+data.getSeconds() : data.getSeconds();

				return `${hora}:${min}:${seg}`;
			};

			$('#kt_select2_4').change(() => {

				let id = $('#kt_select2_4').val()
				PRODUTOS.map((p) => {
					if(id == p.id){
						PRODUTO = p
						if(p.delivery && p.delivery.pizza.length > 0){
							setaTamanhosPizza(p.delivery)
						}else{
							$('#valor').val(p.valor_venda)
							$('#sabores-pizza').css('display', 'none')
							$('#tamanhos-pizza').css('display', 'none')
							$('#btn-add-sabor').css('display', 'none')

						}
					}
				})
			})



		</script>

	</body>


	</html>