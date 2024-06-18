@extends('ecommerce.default')
@section('content')
<style type="text/css">
	.owl-nav{
		display: none;
	}
</style>
<section class="carrossel">
	<div class="container">
		<div class="latest-product__text">

			<div class="latest-product__slider owl-carousel">
				@foreach($carrossel as $c)
				<div class="latest-prdouct__slider__item">
					<div class="hero__item set-bg" data-setbg="/ecommerce/carrossel/{{$c->img}}">
						<div class="hero__text">
							<span>{{$c->titulo}}</span>
							<h2>{{$c->descricao}}</h2>
							@if($c->nome_botao != "" && $c->link_acao != "")
							<a href="{{$c->link_acao}}" class="primary-btn">{{$c->nome_botao}}</a>
							@endif
						</div>
					</div>

				</div>
				@endforeach
			</div>
		</div>
	</div>
</section>

<section class="categories spad">
	<div class="container">
		<div class="row">
			<div class="categories__slider owl-carousel">
				@foreach($default['categorias'] as $c)
				<div class="col-lg-3">
					<div onclick="link('{{$rota}}/{{$c->id}}/categorias')" class="categories__item set-bg" data-setbg="/ecommerce/categorias/{{$c->img}}">
						<h5><a href="{{$rota}}/{{$c->id}}/categorias">{{$c->nome}}</a></h5>
					</div>

				</div>
				@endforeach
			</div>
		</div>
	</div>
</section>

@if(sizeof($categoriasEmDestaque) > 0)
<section class="featured">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="section-title">
					<h2>Produtos em destaques</h2>
				</div>
				<div class="featured__controls">
					@if(sizeof($categoriasEmDestaque) > 1)
					<ul>
						<li class="active" data-filter="*">Todos</li>
						@foreach($categoriasEmDestaque as $c)
						<li data-filter=".{{$c->nome}}">{{$c->nome}}</li>
						@endforeach
					</ul>
					@endif
				</div>
			</div>
		</div>
		<div class="row featured__filter">

			@foreach($produtosEmDestaque as $p)
			@if(sizeof($p->galeria) > 0)
			<div class="col-lg-3 col-md-4 col-sm-6 mix {{$p->categoria->nome}}">
				<div class="featured__item">
					<div class="featured__item__pic set-bg" data-setbg="/ecommerce/produtos/{{$p->galeria[0]->img}}">
						<ul class="featured__item__pic__hover">
							<li><a href="{{$rota}}/{{$p->id}}/curtirProduto"><i class="fa fa-heart @if($p->curtido) text-danger @endif"></i></a></li>
							<li><a href="{{$rota}}/{{$p->id}}/verProduto"><i class="fa fa-shopping-cart"></i></a></li>
						</ul>
					</div>
					<div class="featured__item__text">
						<h6><a href="#">{{$p->produto->nome}}</a></h6>
						<h5>R$ {{number_format($p->valor, 2, ',', '.')}}</h5>
					</div>
				</div>
			</div>
			@endif
			@endforeach

		</div>
	</div>
</section>
@endif

@section('javascript')
<script type="text/javascript">
	function link(link){
		location.href = link
	}
</script>
@endsection	

@endsection	
