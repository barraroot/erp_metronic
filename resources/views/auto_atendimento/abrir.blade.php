@extends('auto_atendimento.default')
@section('content')

<style type="text/css">
	@media only screen and (max-width: 400px) {
		.img-home{
			width: 100%; height: 250px;
		}
	}
	@media only screen and (min-width: 401px) and (max-width: 1699px){
		.img-home{
			width: 100%; height: 400px;
		}
	}

	@media only screen and (min-width: 1700px){
		.img-home{
			width: 100%; height: 500px;
		}
	}
</style>


@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif

@if(session()->has('message_erro'))
<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
@endif




<div class="clearfix"></div>


<section class="blog_w3ls py-5">
	<div class="container pb-xl-5 pb-lg-3">
		<div class="title-section text-center mb-md-5 mb-4">
			<p class="w3ls-title-sub">Iniciar Atendimento</p>
		</div>
		<form method="post" action="/atendimento/iniciar">
			@csrf
			<div class="row">
				<!-- blog grid -->

				<div class="col-sm-12 col-md-8 col-lg-4 offset-lg-4 offset-md-2">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1">Nome</span>
						</div>
						<input required type="text" class="form-control" value="" name="nome" aria-describedby="basic-addon1">
					</div>
				</div>
				<div class="col-sm-12 col-md-8 col-lg-4 offset-lg-4 offset-md-2">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1">Comanda (Opcional)</span>
						</div>
						<input type="text" class="form-control" value="" name="comanda" aria-describedby="basic-addon1">
					</div>
				</div>

				<button type="submit" class="btn btn-success btn-lg btn-block">
					Abrir atendimento <span class="fa fa-play mr-2"></span>
				</button>

			</div>
		</form>
	</div>
</section>



@if(session()->has('message_sucesso_swal'))
<script type="text/javascript">
	swal('Sucesso!', <?php session()->get('message_sucesso_swal') ?>, 'success');
</script>
@endif

@endsection	