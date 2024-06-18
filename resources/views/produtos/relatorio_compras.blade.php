<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/materialize.min.css">

</head>
<body>

	<div class="row">
		<div class="col s12">
			<h3 class="center-align">Relátorio de Compra <strong>{{$produto->nome}}</strong></h3>
			<h4>Data da ultima compra: 
				<strong style="color: red">{{\Carbon\Carbon::parse($produto->emCompras[sizeof($produto->emCompras)-1]->created_at)->format('d/m/Y H:i:s')}}</strong>
			</h4>

			<h4>Valor pago na ultima compra: 
				<strong style="color: red">{{number_format($produto->emCompras[sizeof($produto->emCompras)-1]->valor_unitario, 2, ',', '.')}}</strong>
			</h4>

			<h4>Valor médio de compra: 
				<strong style="color: red">{{number_format($produto->valorMediaDeCompra(), 2, ',', '.')}}</strong>
			</h4>

			<h4>Estoque: 
				<strong style="color: red">
					@if($produto->estoque)
					@if($produto->unidade_venda == 'UN' || $produto->unidade_venda == 'UNID')
					{{number_format($produto->estoque->quantidade)}}
					@else
					{{$produto->estoque->quantidade}}
					@endif
					@php $est = $produto->estoque->quantidade; @endphp
					@else
					0
					@endif

					{{$produto->unidade_venda}}
				</strong>
			</h4>
		</div>


		<table class="pure-table">
			<thead>
				<tr>
					<th width="80">CÓDIGO DA COMPRA</th>
					<th width="120">DATA</th>
					<th width="120">QUANTIDADE</th>
					<th width="120">VALOR UNIT</th>
				</tr>
			</thead>

			<tbody>
				@foreach($produto->emCompras as $key => $i)
				<tr class="@if($key%2 == 0) pure-table-odd @endif">
					<td>{{$i->id}}</td>
					<td>{{\Carbon\Carbon::parse($i->created_at)->format('d/m/Y H:i:s')}}</td>
					<td>{{$i->quantidade}}</td>
					<td>{{number_format($i->valor_unitario, 2, ',', '.')}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>


	</div>


</body>
</html>