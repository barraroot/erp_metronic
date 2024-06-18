@extends('default.layout')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/deliveryProduto/saveAdicionais">
					<input type="hidden" name="id" value="{{$produto->id}}">

					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Adicionais para o produto <strong style="margin-left: 3px;" class="text-info"> {{$produto->produto->nome}}</strong></h3>
						</div>

					</div>
					@csrf

					<!-- {{$produto->adicionais}} -->
					<div class="row">

						<div class="col-xl-12">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">

										@foreach($categorias as $c)

										<div class="col-lg-4 col-xl-4 col-12">
											<div class="card card-custom">
												<div class="card-header">
													<h3 style="margin-top: 20px;">
														{{$c->nome}}
													</h3>
												</div>
												<div class="card-body">
													<div class="checkbox-inline" style="margin-top: 10px;">
														@foreach($c->adicionais as $a)
														<div class="col-12">
															<label class="checkbox checkbox-info check-sub">
																<input 

																@if(in_array($a->id, $adicionados))
																checked
																@endif
																id="ad_{{$a->id}}" type="checkbox" name="ad_{{$a->id}}">
																<span></span>{{$a->nome}}
															</label>
														</div>
														@endforeach
													</div>
												</div>
											</div>
										</div>

										@endforeach
									</div>

								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="card-footer">

						<div class="row">
							<div class="col-xl-2">

							</div>
							<div class="col-lg-3 col-sm-6 col-md-4">
								<a style="width: 100%" class="btn btn-danger" href="">
									<i class="la la-close"></i>
									<span class="">Cancelar</span>
								</a>
							</div>
							<div class="col-lg-3 col-sm-6 col-md-4">
								<button style="width: 100%" type="submit" class="btn btn-success">
									<i class="la la-check"></i>
									<span class="">Salvar</span>
								</button>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection