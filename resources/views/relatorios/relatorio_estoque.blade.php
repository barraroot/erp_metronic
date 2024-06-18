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
			<h3 class="center-align">Relátorio de Estoque</h3>
			
		</div>


		<table class="pure-table">
			<thead>
				<tr>
					<th width="150">ID</th>
					<th width="150">PRODUTO</th>
					<th width="150">QUANTIDADE</th>
				</tr>
			</thead>

			

			<tbody>
				@foreach($produtos as $key => $p)
				<tr class="@if($key%2 == 0) pure-table-odd @endif">
					<td>{{$p->id}}</td>
					<td>{{$p->nome}}</td>
					@if($p->unidade_venda == 'UNID' || $p->unidade_venda == 'UN')
					<td>{{number_format($p->quantidade)}} {{$p->unidade_venda}}</td>
					@else
					<td>{{$p->quantidade}} {{$p->unidade_venda}}</td>

					@endif

				</tr>
				@endforeach
			</tbody>
		</table>


	</div>
	<div class="row">
		<canvas id="grafico-vendas" style="width: 100%; margin-left: 100px; margin-top: 20px;"></canvas>
	</div>

</body>
</html>