@extends('ecommerce.default')
@section('content')

<section class="product-details spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="product__details__pic">
					<div class="product__details__pic__item">
						<img class="product__details__pic__item--large"
						src="/ecommerce/produtos/{{$produto->galeria[0]->img}}" alt="">
					</div>
					<div class="product__details__pic__slider owl-carousel">
						@foreach($produto->galeria as $g)
						<img data-imgbigurl="/ecommerce/produtos/{{$g->img}}" alt="" src="/ecommerce/produtos/{{$g->img}}">
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="product__details__text">
					<h3>{{$produto->produto->nome}}</h3>
					
					<div class="product__details__price">
						R$ {{number_format($produto->valor, 2, ',', '.')}}
					</div>
					
					<div class="text-truncate" style="height: 85px;">
						{!! $produto->descricao !!}
					</div>
					<form method="post" action="{{$rota}}/addProduto">
						@csrf
						<input type="hidden" value="{{$default['config']->empresa_id}}" name="empresa_id">
						<input type="hidden" value="{{$produto->id}}" name="produto_id">
						<div class="product__details__quantity">
							<div class="quantity">
								<div class="pro-qty">
									<input name="quantidade" type="text" value="1">
								</div>
							</div>
						</div>
						<button class="btn primary-btn">ADICIONAR AO CARRINHO</button>
						<a href="{{$rota}}/{{$produto->id}}/curtirProduto" class="heart-icon @if($curtida) text-danger @endif">
							<span class="icon_heart_alt"></span>
						</a>
					</form>
					<ul>
						<li><b>Disponibilidade</b> <span>Em estoque</span></li>
						<li><b>Entrega</b> <span>Imediata</span></li>

					</ul>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="product__details__tab">
					
					<div class="tab-pane active" id="tabs-1" role="tabpanel">
						<div class="product__details__tab__desc">
							<h6>Informação do produto</h6>
							{!! $produto->descricao !!}
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</section>

@endsection	
