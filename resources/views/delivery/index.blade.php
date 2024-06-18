@extends('delivery.default')
@section('content')

<style type="text/css">
	@media only screen and (max-width: 400px) {
		.img-home{
			width: 100%; height: 250px;
			border-radius: 5px;
		}
	}
	@media only screen and (min-width: 401px) and (max-width: 1699px){
		.img-home{
			width: 99%; height: 400px;
			border-radius: 5px;
		}
	}

	@media only screen and (min-width: 1700px){
		.img-home{
			width: 99%; height: 500px;
			border-radius: 5px;
		}
	}
</style>


@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif

@if(session()->has('message_erro'))
<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
@endif
<section class="portfolio py-2">
	<div class="container py-xl-2 py-lg-1">
		<form action="/filtroProduto" method="get">
			<div class="row">
				<div class="col-12 col-lg-10">

					<div class="col-lg-12 form-group">
						<input style="width: 100%" type="text" class="form-control" name="pesquisa" placeholder="Pesquisar produto" required="">
					</div>
				</div>
				<div class="col-12 col-lg-2">
					<button style="width: 100%" type="submit" class="btn btn-success"><span class="fa fa-search"></span>Buscar</button>
				</div>
			</div>
		</form>
	</div>
</section>


@foreach($destaques as $d)

@if(!isset($d->block))
<div class="baneer-w3ls">
	<div class="row no-gutters">
		<div class="col-xl-5 col-lg-6">
			<div class="banner-left-w3">
				<div class="container">
					<div class="banner-info_agile_w3ls" style="">

						<h3 class=""><span>{{$d->produto->nome}}</span> </h3>
						<p>{{$d->descricao}}</p>

						
						@if(count($d->pizza) == 0)
						@if($d->valor_anterior > 0)
						<h4 style="text-decoration: line-through;">de R$ <span">{{$d->valor_anterior}}</span> </h4>
						<h3>Por R$ <span style="color: orange">{{$d->valor}}</span> </h3>

						@else

						<h3>R$ <span style="color: orange">{{$d->valor}}</span> </h3>

						@endif
						@else

						@foreach($d->pizza as $tp)
						@if($tp->valor > 0)
						<h4>{{$tp->tamanho->nome()}}: 
							<span style="color: orange">{{number_format($tp->valor, 2)}}</span></h4> 
							@endif
							
							@endforeach

							@endif

							<a href="/cardapio/acompanhamento/{{$d->id}}" class="button-w3ls active mt-5">Adicionar ao Carrinho
								<span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
							</a>

						</div>
					</div>	
				</div>
				<br>
			</div>
			<div class="col-xl-7 col-lg-6 callbacks_container">

				<div class="csslider infinity" id="slider1">
					@foreach($d->galeria as $key => $g)
					<input type="radio" name="slides" @if($key+1 == 1) checked="checked" @endif id="slides_{{$key+1}}" />
					@endforeach

					<ul class="banner_slide_bg">
						@foreach($d->galeria as $key => $g)
						<li>
							<img class="img-home" loading="lazy"
							src="/imagens_produtos/{{$g->path}}">
						</li>
						@endforeach
						
					</ul>
					<div class="arrows">
						@foreach($d->galeria as $key => $g)
						<label for="slides_{{$key+1}}"></label>
						@endforeach

					</div>
					<div class="navigation">
						<div>
							@foreach($d->galeria as $key => $g)

							<label for="slides_{{$key+1}}"></label>
							@endforeach

						</div>
					</div>
				</div>

			</div>
		</div>
	</div><br>
	@endif
	@endforeach

	<div class="clearfix"></div>

	@if(isset($produtos))


		<div class="container py-xl-5 py-lg-3">

			<?php $ativo = false; ?>

			<div class="row mt-4">

				@foreach($produtos as $p)
				@if($p->status)
				<div @if(!$p->itemPedido()) style="opacity: 0.5" @endif class="col-md-4">
					<div class="gallery-demo">
						<a @if($p->itemPedido()) 
							href="/cardapio/acompanhamento/{{$p->id}}"
							@else
							href="#!"
							@endif>
							@if(count($p->galeria) > 0)
							<img src="/imagens_produtos/{{$p->galeria[0]->path}}" 
							alt="" style="height: 300px; width: 100%;" class="img-fluid" />
							@else
							<img style="height: 300px; width: 100%" src="/imagens/sem-imagem.png"  class="img-fluid" >
							@endif

							<?php $ativo = true; ?>
							<h4 class="p-mask">{{$p->produto->nome}} - <span>R${{$p->valor}}</span></h4>
							@if(!$p->itemPedido())
							<p style="color: red; margin-left: 10px;">Limite diário de vendas atingido</p>
							@endif
						</a>
					</div>
				</div>
				@endif
				@endforeach


			</div>
			@if(!$ativo)
			<div class="title-section text-center mb-md-5 mb-4">
				<h4 class="w3ls-title mb-3 "><span>Nada encontrado :(</span></h4>
			</div>
			@endif

		</div>


	@else
	<section class="blog_w3ls py-5">
		<div class="container pb-xl-5 pb-lg-3">
			<div class="title-section text-center mb-md-5 mb-4">
				<p class="w3ls-title-sub">Categorias</p>
			</div>
			<div class="row">
				<!-- blog grid -->
				@foreach($categorias as $c)
				<div class="col-lg-4 col-md-6">
					<div class="card border med-blog">
						<div class="card-header p-0">
							<a href="/cardapio/{{$c->id}}">
								<img loading="lazy" style="height: 200px; width: 100%;" class="card-img-bottom" src="imagens_categorias/{{$c->path}}" alt="Card image cap">
							</a>
						</div>
						<div class="card-body border border-top-0">
							<h5 class="blog-title card-title m-0"><a href="menu.html">{{$c->nome}}</a></h5>
							<p style="height: 80px;" class="mt-3">{{$c->descricao}}</p>
							<a href="/cardapio/{{$c->id}}" class="btn button-w3ls mt-4 mb-3">Ver Produtos
								<span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
							</a>
						</div>
					</div>
				</div>
				@endforeach
				
			</div>
		</div>
	</section>
	@endif

	<section class="wthree-slider" id="masthead">

	</section>

	@endsection	