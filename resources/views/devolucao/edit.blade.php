@extends('default.layout')
@section('content')

<div class="row" id="anime" style="display: none">
	<div class="col s8 offset-s2">
		<lottie-player 
		src="/anime/success.json"  background="transparent"  speed="0.8"  style="width: 100%; height: 300px;"    autoplay >
	</lottie-player>
</div>
</div>

<div class="card card-custom gutter-b">
	<div class="card-body">
		<h1 class="center-align">Visualizando Devolução</h1>
		<h4 class="center-align">Nota Fiscal de Entrada <strong class="grey-text">{{$devolucao->nNf}}</strong></h4>
		<h4 class="center-align">Chave de Entrada <strong class="grey-text">{{$devolucao->chave_nf_entrada}}</strong></h4>


		

		<div class="card card-custom gutter-b">
			<div class="card-body">
				<div class="card-content">
					<div class="row">
						<div class="col s8">
							<h5>Fornecedor: 
								<strong>{{$devolucao->fornecedor->razao_social}}</strong>
							</h5>
						</div>


					</div>
				</div>
			</div>

		</div>

		<div class="card card-custom gutter-b">
			<div class="card-body">
				<div class="row">
					<div class="col-xl-12">

						<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
							<h4>Itens da NF</h4>
							<p class="red-text">* Produtos em vermelho ainda não cadastrado no sistma</p>

							<table class="datatable-table" style="max-width: 100%; overflow: scroll">
								<thead class="datatable-head">
									<tr class="datatable-row" style="left: 0px;">
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">Código</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Produto</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">NCM</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">CFOP</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Cód Barras</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Un. compra</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Subtotal</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

									</tr>
								</thead>
								<input type="hidden" value="{{json_encode($devolucao->itens)}}" id="itens_dev">
								<tbody id="body" class="datatable-body">

									@foreach($devolucao->itens as $i)
									<tr class="datatable-row">

										<td class="datatable-cell"><span class="codigo" style="width: 70px;">{{$i->cod}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{$i->nome}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{$i->ncm}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{$i->cfop}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{$i->codBarras}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{$i->unidade_medida}}</span>
										</td>

										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{$i->valor_unit}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{$i->quantidade}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{number_format(($i->quantidade * $i->valor_unit), 2)}}</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												<a onclick="modalDev('{{$i->id}}')" class="btn btn-info">
													<i class="la la-edit"></i>
												</a>
											</span>
										</td>

									</tr>
									@endforeach
								</tbody>
							</table>
							<div class="row">
								<h5>Soma dos Itens: <strong id="soma-itens" class="red-text"></strong></h5>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>


		<div class="card card-custom gutter-b">
			<div class="card-body">
				<div class="row">
					<div class="col s6">
						<h4>Valor Integral da NF: <strong id="valorDaNF" class="text-primary">R$ {{$devolucao->valor_integral}}</strong></h4>
					</div>

					<div class="col s6">
						<h4>Valor Devolvido: <strong class="text-danger">R$ {{$devolucao->valor_devolvido}}</strong></h4>
					</div>

				</div>

				<div class="row">
					<div class="col s4">
						<a style="width: 50%;" href="/devolucao/downloadXmlEntrada/{{$devolucao->id}}" class="btn btn-info" target="_blank">
							Downlaod XML de entrada
						</a>
					</div>


				</div>

				<br>

			</div>
		</div>
	</div>


</div>

<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<form method="post" action="/devolucao/saveItem">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Adicionar produto</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						x
					</button>
				</div>
				<div class="modal-body">

					<div class="row">
						<div class="form-group validated col-sm-12 col-lg-12">
							<label class="col-form-label">Nome do Produto</label>
							<div class="">
								<input id="nome" type="text" class="form-control" name="nome" value="">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group validated col-sm-3 col-lg-3">
							<label class="col-form-label">NCM</label>
							<div class="">
								<input id="ncm" type="text" class="form-control" name="ncm" value="">
							</div>
						</div>
						<div class="form-group validated col-sm-3 col-lg-3">
							<label class="col-form-label">CFOP</label>
							<div class="">
								<input id="cfop" type="text" class="form-control" name="cfop" value="">
							</div>
						</div>
					</div>


					<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" id="id" name="id" value="">

					<div class="row">
						<div class="form-group validated col-sm-3 col-lg-3">
							<label class="col-form-label">%ICMS</label>
							<div class="">
								<input id="perc_icms" type="text" class="form-control" name="perc_icms" value="">
							</div>
						</div>
						<div class="form-group validated col-sm-3 col-lg-3">
							<label class="col-form-label">%PIS</label>
							<div class="">
								<input id="perc_pis" type="text" class="form-control" name="perc_pis" value="">
							</div>
						</div>
						<div class="form-group validated col-sm-3 col-lg-3">
							<label class="col-form-label">%COFINS</label>
							<div class="">
								<input id="perc_cofins" type="text" class="form-control" name="perc_cofins" value="">
							</div>
						</div>
						<div class="form-group validated col-sm-3 col-lg-3">
							<label class="col-form-label">%IPI</label>
							<div class="">
								<input id="perc_ipi" type="text" class="form-control" name="perc_ipi" value="">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label">CST/CSOSN</label>
							<select class="custom-select form-control" id="cst_csosn" name="cst_csosn">
								@foreach(App\Models\ConfigNota::listaCST() as $key => $c)
								<option value="{{$key}}">{{$key}} - {{$c}}
								</option>
								@endforeach
							</select>
						</div>




						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label">CST PIS</label>
							<select class="custom-select form-control" id="cst_pis" name="cst_pis">
								@foreach(App\Models\ConfigNota::listaCST_PIS_COFINS() as $key => $c)
								<option value="{{$key}}">
									{{$key}} - {{$c}}
								</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label">CST COFINS</label>
							<select class="custom-select form-control" id="cst_cofins" name="cst_cofins">
								@foreach(App\Models\ConfigNota::listaCST_PIS_COFINS() as $key => $c)
								<option value="{{$key}}">{{$key}} - {{$c}}
								</option>
								@endforeach
							</select>
						</div>

						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label">CST IPI</label>
							<select class="custom-select form-control" id="cst_ipi" name="cst_ipi">
								@foreach(App\Models\ConfigNota::listaCST_IPI() as $key => $c)
								<option value="{{$key}}">{{$key}} - {{$c}}
								</option>
								@endforeach
							</select>
						</div>

					</div>


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
					<button type="subit" id="salvar" class="btn btn-success font-weight-bold spinner-white spinner-right">Salvar</button>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection	