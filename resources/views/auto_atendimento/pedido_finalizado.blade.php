@extends('auto_atendimento.default')
@section('content')

@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif
<div class="clearfix"></div>

<br><br>

<div class="col-lg-12 col-md-12">
	<div class="card border-0 med-blog">

		<div class="row">
			<div class="container">
				<h2 class="text-success text-center">Obrigado pela confiança, aguarde seu pedido ser entregue!!<i class="fa fa-check"></i></h2>

				<h4 class="text-center"><strong>ID do pedido: <span style="color: green"> {{$pedido->comanda}}</span></strong></h4>

				<h4 class="text-center"><strong>Total pedido = <span style="color: red">R$ {{number_format($pedido->somaItems(), 2, ',', '.')}}</span></strong></h4>

				<h4 class="text-center"><strong>Início do auto atendimento: <span style="color: blue">{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y H:i')}}</span></strong></h4>
				<h4 class="text-center"><strong>Término do auto atendimento: <span style="color: blue">{{ \Carbon\Carbon::parse($pedido->updated_at)->format('d/m/Y H:i')}}</span></strong></h4>


				<a style="margin-top: 15px;" href="/atendimento" class="btn btn-success btn-lg btn-block">
					INICIAR NOVO ATENDIMENTO <span class="fa fa-reply"></span>
				</a>

			</div>
		</div>

	</div>
</div>

<br>

@endsection	
