<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!DOCTYPE html>
<html>

<head>
	<title>{{$title}}</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords"
	content="Tasty Burger Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--// Meta tag Keywords -->

	<!-- Custom-Files -->
	<link rel="stylesheet" href="/cssboot/bootstrap.css">
	<!-- Bootstrap-Core-CSS -->
	<link href="/cssboot/css_slider.css" type="text/css" rel="stylesheet" media="all">
	<!-- css slider -->
	<link rel="stylesheet" href="/cssboot/style.css" type="text/css" media="all" />
	<!-- Style-CSS -->
	<link href="/cssboot/font-awesome.min.css" rel="stylesheet">
	@if(isset($carrinho) || isset($historico))
	<link href="/css/delivery.css" rel="stylesheet">
	<link href="/css/card.css" rel="stylesheet">

	@endif

	@if(isset($historico))
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	@endif
	<!-- Font-Awesome-Icons-CSS -->
	<!-- //Custom-Files -->

	<!-- Web-Fonts -->
	<link
	href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext"
	rel="stylesheet">
	<link
	href="//fonts.googleapis.com/css?family=Barlow+Semi+Condensed:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
	rel="stylesheet">

	<style type="text/css">
		.cod{
			width: 40px;
			height: 40px;
			text-align: center;
			margin-left: -5px;
		}
		.fixarRodape {
			bottom: 0;
			position: fixed;
			width: 100%;
			text-align: center;
		}
	</style>

	<style type="text/css">
		.area_menu{
			position: fixed;
			left: 0;
			right: 5px;
			bottom: 0;
			margin-bottom: 60px;
			overflow: visible;
			height: 2px;
			z-index: 1000;
		}

		.area_menu .wrap{
			position: relative;
		}
		body.home .area_menu .wrap{
			max-width: 500px;
		}
		.fab-site {
			position: absolute;
			bottom: 10px;
			right: 0;
		}
		.fab-site:hover,
		.fab-site:active{
			box-shadow:  0 24px 38px 3px rgba(0,0,0,0.14), 0 9px 46px 8px rgba(0,0,0,0.12), 0 11px 15px -7px rgba(0,0,0,0.2);
		}
		.fab-site a {
			cursor: pointer;
			width: 48px;
			height: 48px;
			border-radius: 30px;
			border: none;
			box-shadow: 0 1px 5px rgba(0, 0, 0, .4);
			font-size: 24px;
			color: white;
			text-align: center;
			line-height: 2.1em;
			-webkit-transition: .2s ease-out;
			-moz-transition: .2s ease-out;
			transition: .2s ease-out;
		}
		.fab-site a:focus {
			outline: none;
		}
		.fab-site a.main {
			position: absolute;
			width: 60px;
			height: 60px;
			border-radius: 30px;
			right: 0;
			bottom: 0;
			z-index: 20;
			line-height: 2.6em;
			text-align: center;
		}
		.fab-site ul {
			position: absolute;
			bottom: 0;
			right: 0;
			padding: 0;
			padding-right: 5px;
			margin: 0;
			list-style: none;
			z-index: 10;
			-webkit-transition: .2s ease-out;
			-moz-transition: .2s ease-out;
			transition: .2s ease-out;
			margin-right: 10px;
		}
		.fab-site ul li {
			display: flex;
			justify-content: flex-end;
			position: relative;
			margin-bottom: -10%;
			opacity: 0;
			-webkit-transition: .3s ease-out;
			-moz-transition: .3s ease-out;
			transition: .3s ease-out;
		}
		.fab-site ul li label {
			margin-right: 10px;
			white-space: nowrap;
			display: block;
			margin-top: 10px;
			padding: 5px 8px;
			background-color: #333333;
			box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
			border-radius: 3px;
			height: 33px;
			font-size: 16px;
			pointer-events: none;
			opacity: 1;
			-webkit-transition: .2s ease-out;
			-moz-transition: .2s ease-out;
			transition: .2s ease-out;
			color: white;
		}
		.fab-site.show a.main, .fab-site.show a.main {
			outline: none;
			box-shadow: 0 3px 8px rgba(0, 0, 0, .5);
			color: white;
		}
		.fab-site.show a.main + ul, .fab-site.show a.main + ul {
			bottom: 70px;
		}
		.fab-site.show a.main + ul li,
		.fab-site.show a.main + ul li {
			margin-bottom: 10px;
			opacity: 1;
			display: flex;
			justify-content: flex-end;
		}
		.fab-site.show a.main + ul li:hover label, .fab-site.show a.main + ul li:hover label {
			opacity: 1;
		}

		
	</style>

	<!-- Colar OneSignal -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
	

	

	<!-- Fim manter aqui -->

	<!-- //Web-Fonts -->
</head>

<body>
	<!-- header -->


	<header id="home">
		<!-- top-bar -->
		<div class="top-bar py-2 border-bottom">
			<div class="main-top py-1">
				<div class="container">
					<div class="nav-content">
						<!-- logo -->
						<h1>

							<a id="logo" class="logo">
								<img src="/images/logo.png" alt="" class="img-fluid">
								<span>{{$config->nomeExib(0)}}</span> {{$config->nomeExib(1)}}

							</a>
						</h1>
						<!-- //logo -->
						<!-- nav -->
						<div class="nav_web-dealingsls">
							<nav>
								<label for="drop" class="toggle">Menu</label>
								<input type="checkbox" id="drop" />
								<ul class="menu">
									<!-- <li><a href="/">INICIO</a></li> -->
									<li><a href="/atendimento">CARDÁPIO</a></li>

									<li><a href="/atendimento/ver">MEU PEDIDO</a></li>
									<li><a href="/atendimento/encerrar">ENCERRAR ATENDIMENTO</a></li>
									<!-- <li><a href="/carrinho/historico">MEUS PEDIDOS</a></li> -->
									<!-- <li><a href="/carrinho/cupons">CUPONS DE DESCONTO</a></li> -->

								</ul>
							</nav>
						</div>
						<!-- //nav -->
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- //top-bar -->

	<!-- header 2 -->
	<!-- navigation -->
	
	<!-- //navigation -->

	@yield('content')

	<div class="area_menu">

		@if((session('comanda')))
		<nav class="fab-site">
			<a class="main btn-info"><i class="fa fa-list" aria-hidden="true"></i></a>
			<ul>
				<li>
					<label for="">CARDÁPIO</label>
					<a class="btn-primary" id="noticias" href="/atendimento"> <i class="fa fa-cutlery" aria-hidden="true"></i> </a> 
				</li>
				<li>
					<label for="">MEU PEDIDO</label>
					<a class="btn-success" id="desenvolvimento" href="/atendimento/ver"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> </a> 
				</li>
				<li>
					<label for="">ENCERRAR ATENDIMENTO</label>
					<a class="btn-danger" id="design" href="/atendimento/encerrar"> <i class="fa fa-times-circle" aria-hidden="true"></i></a> 
				</li>
				<li style="display: none">
				
				</li>
				
			</ul>
		</nav>
		@endif

	</div>

	<!-- //footer -->
	<!-- copyright -->
	<div class="cpy-right text-center py-3 fixarRodape">
		<p>© 2021 Slym | Design by
			<a href="http://slymtech.com.br"> SlymTech.</a>
		</p>
	</div>


	<!-- //copyright -->
	<!-- move top icon -->
	<a href="#home" class="move-top text-center">
		<span class="fa fa-level-up" aria-hidden="true"></span>
	</a>
	<!-- //move top icon -->

	<?php $path = getenv('PATH_URL')."/";?>
	<script type="text/javascript">
		const path = "{{$path}}";
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	@if(isset($historico))
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	@else

	<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/js/jquery.mask.min.js"></script>

	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script type="text/javascript">

		$('#quantidade').mask('00', {reverse: true});
		$('#telefone').mask('00 00000-0000', {reverse: true});
		$(".qtd").mask('00', {reverse: true});
		$('#troco_para').mask('000000,00', {reverse: true});
		$('#cod1').mask('0', {reverse: true});
		$('#cod2').mask('0', {reverse: true});
		$('#cod3').mask('0', {reverse: true});
		$('#cod4').mask('0', {reverse: true});
		$('#cod5').mask('0', {reverse: true});
		$('#cod6').mask('0', {reverse: true});
		$('#cpf').mask('000.000.000-00', {reverse: true});


	</script>


	@endif

	@if(isset($acompanhamento))
	<script src="/jsd_atendimento/acompanhamento.js" type="text/javascript"></script>
	@endif

	@if(isset($acompanhamentoPizza))
	<script src="/jsd_atendimento/acompanhamentoPizza.js" type="text/javascript"></script>
	@endif

	@if(isset($carrinho))
	<script src="/jsd_atendimento/carrinho.js" type="text/javascript"></script>
	@endif

	@if(isset($forma_pagamento))
	<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
	<script src="/jsd_atendimento/card.js" type="text/javascript"></script>
	<script src="/jsd_atendimento/forma_pagamento.js" type="text/javascript"></script>

	<script type="text/javascript">

		new Card({
			form: document.querySelector('form'),
			container: '.card-wrapper',
			width: 300,
			placeholders: {
				number: '•••• •••• •••• ••••',
				name: 'Nome Completo',
				expiry: '••/••••',
				cvc: 'CVC'
			},
			debug: true,
			formSelectors: {
				numberInput: 'input#number', 
				expiryInput: 'input#validade', 
				cvcInput: 'input#cvc', 
				nameInput: 'input#nome' 
			},
		});


	</script>
	@endif

	<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
	@if(isset($cadastro_ative))
	<script src="/jsd_atendimento/cadastro_ative.js" type="text/javascript"></script>
	@endif

	@if(isset($pizzaJs))
	<script src="/jsd_atendimento/pizza.js" type="text/javascript"></script>
	@endif

	@if(isset($login_ative))
	<script src="/jsd_atendimento/login_ative.js" type="text/javascript"></script>
	@endif

	@if(isset($mapaJs))
	<script src="https://maps.googleapis.com/maps/api/js?key={{getenv('API_KEY_MAPS')}}"
	async defer></script>
	@endif

	@if(isset($tokenJs))
	<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-app.js"></script>
	@endif

	@if(isset($finalizarJs))
	<script>
		// setTimeout(() => {
		// 	location.href = path + "atendimento";
		// }, 15000)


	</script>
	@endif

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>

	@if(session()->has('message_sucesso_swal'))
	<script type="text/javascript">
		swal('Sucesso!', '<?php echo session()->get('message_sucesso_swal') ?>', 'success');
	</script>
	@endif

	<script type="text/javascript">
		$('.main').click(() => {
			let c = $('.fab-site').hasClass("show")
			if(!c){
				$('.fab-site').addClass('show');
			}else{
				$('.fab-site').removeClass('show');

			}
		})
	</script>
</body>

</html>