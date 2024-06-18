

@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	
	<div class="card-body">

		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<div class="card card-custom gutter-b example example-compact">
				<div class="card-header">

					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
									<br>
									<h4>{{$title}}</h4>
									<h5>Registros: 
										<strong>
											{{sizeof($itens)}}
										</strong>
									</h5>

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Produto</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">QTD</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Usuário</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Data</span></th>

											</tr>
										</thead>
										<tbody class="datatable-body">
											<?php 
											$subtotal = 0;
											?>
											@foreach($itens as $i)
											<tr class="datatable-row" style="left: 0px;">
												
												<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{$i->produto->nome}}</span></td>

												<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{$i->quantidade}}</span></td>

												<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{number_format($i->valor, 2, ',', '.')}}</span></td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														@if($i->usuario)
														{{$i->usuario->nome}}
														@else
														--
														@endif
													</span>
												</td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 150px;">
														{{\Carbon\Carbon::parse($i->created_at)->format('d/m/Y H:i')}}

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
				</div>
			</div>
		</div>
	</div>

</div>

@endsection
