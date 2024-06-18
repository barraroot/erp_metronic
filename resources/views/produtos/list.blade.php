@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="">
			<div class="col-12">

				<a href="/produtos/new" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Novo Produto
				</a>


				<a style="margin-left: 5px; margin-top: 5px;" href="/divisaoGrade" class="btn btn-lg btn-info">
					<i class="fa fa-th"></i>Divisao de Grade
				</a>
			</div>
		</div>
		<br>


		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<form method="get" action="/produtos/filtroCategoria">
				<div class="row align-items-center">
					<div class="col-lg-5 col-xl-5">
						<div class="row align-items-center">
							<div class="col-md-12 my-2 my-md-0">
								<div class="input-icon">
									<input type="text" name="pesquisa" class="form-control" value="{{{isset($pesquisa) ? $pesquisa : ''}}}"
									placeholder="Produto..." id="kt_datatable_search_query">
									<span>
										<i class="fa fa-search"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					
					<div class="col-lg-4 col-xl-4">
						<div class="row align-items-center">
							<label class="col-form-label text-right col-lg-3 col-sm-12">Categoria</label>
							<div class=" col-lg-9 col-md-9 col-sm-12">
								<select class="form-control select2" id="kt_select2_1" name="categoria">
									<option value="-">Todas</option>
									@foreach($categorias as $c)
									<option @if(isset($categoria)) @if($c->nome == $categoria)
										selected
										@endif
										@endif
										value="{{$c->id}}">{{$c->nome}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>


						<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
							<button type="submit" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
						</div>
					</div>

				</form>

				<br>
				<h4>Lista de Produtos</h4>
				<label>Total de registros: {{count($produtos)}}</label>
				<div class="row">
					<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
						<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="between" data-wizard-clickable="true">
							<!--begin: Wizard Nav-->

							<div class="wizard-nav">

								<div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
									<!--begin::Wizard Step 1 Nav-->
									<div class="wizard-step" data-wizard-type="step" data-wizard-state="done">
										<div class="wizard-label">
											<h3 class="wizard-title">
												<span>
													<i style="font-size: 40px" class="la la-table"></i>
													Tabela
												</span>
											</h3>
											<div class="wizard-bar"></div>
										</div>
									</div>
									<!--end::Wizard Step 1 Nav-->
									<!--begin::Wizard Step 2 Nav-->
									<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
										<div class="wizard-label" id="grade">
											<h3 class="wizard-title">
												<span>
													<i style="font-size: 40px" class="la la-tablet"></i>
													Grade
												</span>
											</h3>
											<div class="wizard-bar"></div>
										</div>
									</div>

								</div>
							</div>

							<!-- inicio grid -->
							<div class="pb-5" data-wizard-type="step-content">
								<div class="row">
									<div class="col-xl-12">

										<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

											<table class="datatable-table" style="max-width: 100%; overflow: scroll">
												<thead class="datatable-head">
													<tr class="datatable-row" style="left: 0px;">
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">NOME</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">CATEGORIA</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">VALOR DE VENDA</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">VALOR DE COMPRA</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">UN. COMPRA</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">UN. VENDA</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">GERENCIAR ESTOQUE</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">TIPO GRADE</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">ESTOQUE</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">AÇÕES</span></th>
													</tr>
												</thead>

												<tbody id="body" class="datatable-body">
													@foreach($produtos as $p)
													<tr class="datatable-row" @if($p->inativo) style="background: #ffcdd2;" @endif>
														<td class="datatable-cell"><span class="codigo" style="width: 250px;" id="id">{{$p->nome}}</span>
														</td>
														<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$p->categoria->nome}}</span>
														</td>

														@if($p->grade)
														<td class="datatable-cell">
															<span class="codigo" style="width: 100px;" id="id">
																{{$p->valoresGrade()}}	
															</span>
														</td>
														@else
														<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($p->valor_venda, 2, ',', '.')}}</span>
														</td>
														@endif
														<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($p->valor_compra, 2, ',', '.')}}</span>
														</td>
														<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$p->unidade_compra}}</span>
														</td>
														<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$p->unidade_venda}}</span>
														</td>
														<td class="datatable-cell">
															<span class="codigo" style="width: 120px;" id="id">
																@if($p->gerenciar_estoque)
																<span class="label label-xl label-inline label-light-success">Sim</span>
																@else
																<span class="label label-xl label-inline label-light-warning">Não</span>
																@endif
															</span>
														</td>

														<td class="datatable-cell">
															<span class="codigo" style="width: 120px;" id="id">
																@if($p->grade)
																<span class="label label-xl label-inline label-light-success">Sim</span>
																@else
																<span class="label label-xl label-inline label-light-warning">Não</span>
																@endif
															</span>
														</td>

														<td class="datatable-cell">
															<span class="codigo" style="width: 100px;" id="id">
																@if($p->estoque)
																@if($p->unidade_venda == 'UN' || $p->unidade_venda == 'UNID')
																{{number_format($p->estoque_atual)}}
																@else
																{{$p->estoque_atual}}
																@endif

																@else
																0
																@endif
															</span>
														</td>

														<td class="datatable-cell">
															<span class="codigo" style="width: 300px;" id="id">
																<a class="btn btn-warning" onclick='swal("Atenção!", "Deseja editar este registro?", "warning").then((sim) => {if(sim){ location.href="/produtos/edit/{{ $p->id }}" }else{return false} })' href="#!">
																	<i class="la la-edit"></i>	
																</a>
																<a class="btn btn-danger" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/produtos/delete/{{ $p->id }}" }else{return false} })' href="#!">
																	<i class="la la-trash"></i>	
																</a>
																@if($p->composto)
																<a class="btn btn-primary" href="/produtos/receita/{{ $p->id }}">
																	<i class="la la-list"></i>	
																</a>
																@endif


																@if($p->ecommerce)
																<a title="Ecommerce" class="btn btn-info" href="/produtoEcommerce/edit/{{ $p->ecommerce->id }}">
																	<i class="la la-shopping-cart"></i>
																</a>
																@endif

																@if($p->grade)
																<a class="btn btn-primary" href="/produtos/grade/{{ $p->id }}">
																	<i class="la la-th"></i>	
																</a>
																@endif
															</span>
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>




							<div class="pb-5" data-wizard-type="step-content">
								<div class="row">
									@foreach($produtos as $p)


									<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
										<div class="card card-custom gutter-b example example-compact">
											<div class="card-header">
												<div class="card-title">
													<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
														<div class="symbol symbol-circle symbol-lg-75">
															@if($p->imagem != '')
															<img src="/imgs_produtos/{{$p->imagem}}" alt="image">
															@else
															<img src="/imgs/no_image.png" alt="image">
															@endif

														</div>
													</div>
													<h3 style="width: 230px; font-size: 12px; height: 10px;" class="card-title">{{$p->id}} - {{substr($p->nome, 0, 30)}}
													</h3>

													<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Ações">
														<a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="fa fa-ellipsis-h"></i>
														</a>
														<div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
															<!--begin::Navigation-->
															<ul class="navi navi-hover">
																<li class="navi-header font-weight-bold py-4">
																	<span class="font-size-lg">Ações:</span>
																</li>
																<li class="navi-separator mb-3 opacity-70"></li>
																<li class="navi-item">
																	<a href="/produtos/edit/{{$p->id}}" class="navi-link">
																		<span class="navi-text">
																			<span class="label label-xl label-inline label-light-primary">Editar</span>
																		</span>
																	</a>
																</li>
																<li class="navi-item">
																	<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/produtos/delete/{{ $p->id }}" }else{return false} })' href="#!" class="navi-link">
																		<span class="navi-text">
																			<span class="label label-xl label-inline label-light-danger">Excluir</span>
																		</span>
																	</a>
																</li>

																@if($p->composto)
																<li class="navi-item">
																	<a href="/produtos/receita/{{$p->id}}" class="navi-link">
																		<span class="navi-text">
																			<span class="label label-xl label-inline label-light-warning">Receita</span>
																		</span>
																	</a>
																</li>
																@endif

																<li class="navi-item">
																	<a href="/produtos/relatorio_compra/{{$p->id}}" class="navi-link">
																		<span class="navi-text">
																			<span class="label label-xl label-inline label-light-info">Relatório de compra</span>
																		</span>
																	</a>
																</li>
															</ul>
														</div>
													</div>
												</div>

												<div class="card-body">

													<div class="kt-widget__info">
														<span class="kt-widget__label">Categoria:</span>
														<a target="_blank" href="/categorias/edit/{{ $p->categoria->id }}" class="kt-widget__data text-success">{{ $p->categoria->nome }}</a>
													</div>
													<div class="kt-widget__info">
														<span class="kt-widget__label">Valor de venda:</span>

														@if($p->grade)
														<a class="kt-widget__data text-success">{{$p->valoresGrade()}}</a>
														@else
														<a class="kt-widget__data text-success">{{ number_format($p->valor_venda, 2, ',', '.') }}</a>
														@endif

													</div>
													<div class="kt-widget__info">
														<span class="kt-widget__label">Unidade:</span>
														<a class="kt-widget__data text-success">{{$p->unidade_compra}}/{{$p->unidade_venda}}</a>
													</div>
													<div class="kt-widget__info">
														<span class="kt-widget__label">Gerenciar estoque:</span>
														@if($p->gerenciar_estoque)
														<span class="label label-xl label-inline label-light-success">SIM</span>
														@else
														<span class="label label-xl label-inline label-light-danger">NÃO</span>
														@endif
													</div>	

													<div class="kt-widget__info">
														<span class="kt-widget__label">Ecommerce:</span>
														@if($p->ecommerce)
														<span class="label label-xl label-inline label-light-success">SIM</span>
														@else
														<span class="label label-xl label-inline label-light-danger">NÃO</span>
														@endif
													</div>	

													<div class="kt-widget__info">
														<span class="kt-widget__label">Delivery:</span>
														@if($p->delivery)
														<span class="label label-xl label-inline label-light-success">SIM</span>
														@else
														<span class="label label-xl label-inline label-light-danger">NÃO</span>
														@endif
													</div>	
													<div class="kt-widget__info">
														<span class="kt-widget__label">Grade:</span>
														@if($p->grade)
														<span class="label label-xl label-inline label-light-success">SIM</span>
														@else
														<span class="label label-xl label-inline label-light-danger">NÃO</span>
														@endif
													</div>	

													@php
													$est = 0;
													@endphp

													<div class="kt-widget__info">
														<span class="kt-widget__label">Estoque atual:</span>
														<a class="kt-widget__data text-success">
															@if($p->estoque)
															@if($p->unidade_venda == 'UN' || $p->unidade_venda == 'UNID')
															{{number_format($p->estoque->quantidade)}}
															@else
															{{$p->estoque->quantidade}}
															@endif
															@php $est = $p->estoque->quantidade; @endphp
															@else
															0
															@endif
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Valor médio de compra:</span>
														<a class="kt-widget__data text-success">
															{{number_format($p->valorMediaDeCompra(), 2, ',', '.')}}
														</a>
													</div>
													<div class="kt-widget__info">
														<span class="kt-widget__label">Valor de estoque sobre valor médio:</span>
														<a class="kt-widget__data text-success">
															{{number_format($p->valorMediaDeCompra() * $est, 2, ',', '.') }}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Valor da ultima compra:</span>
														<a class="kt-widget__data text-success">
															{{number_format($p->valorDaUltimaCompra(), 2, ',', '.') }}
														</a>
													</div>

												</div>
											</div>
										</div>

									</div>

									@endforeach

								</div>
							</div>
						</div>

						<div class="d-flex justify-content-between align-items-center flex-wrap">
							<div class="d-flex flex-wrap py-2 mr-3">
								@if(isset($links))
								{{$produtos->links()}}
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection