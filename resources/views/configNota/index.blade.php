@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/configNF/save">

					<input type="hidden" name="id" value="{{{ isset($config->id) ? $config->id : 0 }}}">

					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{{ isset($config) ? "Editar": "Cadastrar" }}} Emitente Fiscal</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										@if(empty($certificado))
										<div class="col-lg-12 col-sm-12 col-md-12">
											<p style="color: red">VOCE AINDA NÃO FEZ UPLOAD DO CERTIFICADO ATÉ O MOMENTO</p>
										</div>
										<div class="col-lg-12 col-sm-12 col-md-12">

											<a class="btn btn-lg btn-light-info" href="/configNF/certificado">
												Fazer upload agora
											</a>
										</div>

										@else
										<div class="col-lg-12 col-sm-12 col-md-12">
											<a onclick='swal("Atenção!", "Deseja remover este certificado?", "warning").then((sim) => {if(sim){ location.href="/configNF/deleteCertificado" }else{return false} })' href="#!" class="btn btn-danger">
												Remover certificado
											</a>

											@if(isset($config->razao_social))
											<a style="margin-left: 5px;" type="button" id="testar" class="btn btn-success spinner-white spinner-right">
												Testar ambiente
											</a>
											@endif

											
										</div>
										
										<div class="card card-custom gutter-b">
											<div class="card-body">
												<div class="card-content">

													<h6>Serial Certificado: <strong class="green-text">{{$infoCertificado['serial']}}</strong></h6>
													<h6>Inicio: <strong class="green-text">{{$infoCertificado['inicio']}}</strong></h6>
													<h6>Expiração: <strong class="green-text">{{$infoCertificado['expiracao']}}</strong></h6>
													<h6>IDCTX: <strong class="green-text">{{$infoCertificado['id']}}</strong></h6>

												</div>

												@if($soapDesativado)
												<div class="alert alert-custom alert-danger fade show" role="alert" style="margin-top: 10px;">
													<div class="alert-icon"><i class="la la-warning"></i></div>
													<div class="alert-text">
														Extensão SOAP está desativada!!
													</div>
												</div>

												@endif
											</div>
										</div>



										@endif
									</div>

									<div class="row">

										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label">CNPJ</label>
											<div class="">
												<input id="cnpj" type="text" class="form-control @if($errors->has('cnpj')) is-invalid @endif" name="cnpj" value="{{{ isset($config) ? $config->cnpj : old('cnpj') }}}">
												@if($errors->has('cnpj'))
												<div class="invalid-feedback">
													{{ $errors->first('cnpj') }}
												</div>
												@endif
											</div>
										</div>
										
										<div class="form-group validated col-lg-4 col-md-4 col-sm-4">
											<br><br>
											<a type="button" id="btn-consulta-cadastro" onclick="consultaCNPJ()" class="btn btn-success spinner-white spinner-right">
												<span>
													<i class="fa fa-search"></i>
												</span>
											</a>
										</div>	
									</div>

									<div class="row">
										<div class="form-group validated col-sm-12 col-lg-12">
											<label class="col-form-label">Razao Social</label>
											<div class="">
												<input id="razao_social" type="text" class="form-control @if($errors->has('razao_social')) is-invalid @endif" name="razao_social" value="{{{ isset($config) ? $config->razao_social : old('razao_social') }}}">
												@if($errors->has('razao_social'))
												<div class="invalid-feedback">
													{{ $errors->first('razao_social') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-12 col-lg-12">
											<label class="col-form-label">Nome Fantasia</label>
											<div class="">
												<input id="nome_fantasia" type="text" class="form-control @if($errors->has('nome_fantasia')) is-invalid @endif" name="nome_fantasia" value="{{{ isset($config) ? $config->nome_fantasia : old('nome_fantasia') }}}">
												@if($errors->has('nome_fantasia'))
												<div class="invalid-feedback">
													{{ $errors->first('nome_fantasia') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-2 col-lg-2">
											<label class="col-form-label">Tipo</label>
											<div class="">
												<select id="tipo" class="form-control custom-select">
													<option value="f">Fisica</option>
													<option value="j">Juridica</option>
												</select>
											</div>
										</div>
										<div class="form-group validated col-sm-5 col-lg-5">
											<label id="tipo-doc" class="col-form-label">CNPJ</label>
											<div class="">
												<input id="cnpj2" type="text" class="form-control @if($errors->has('cnpj')) is-invalid @endif" name="cnpj" value="{{{ isset($config) ? $config->cnpj : old('cnpj') }}}">
												@if($errors->has('cnpj'))
												<div class="invalid-feedback">
													{{ $errors->first('cnpj') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Inscrição Estadual</label>
											<div class="">
												<input id="ie" type="text" class="form-control @if($errors->has('ie')) is-invalid @endif" name="ie" value="{{{ isset($config) ? $config->ie : old('ie') }}}">
												@if($errors->has('ie'))
												<div class="invalid-feedback">
													{{ $errors->first('ie') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<hr>
									<h5>Endereço</h5>
									<div class="row">

										<div class="form-group validated col-sm-10 col-lg-10">
											<label class="col-form-label">Logradouro</label>
											<div class="">
												<input id="logradouro" type="text" class="form-control @if($errors->has('logradouro')) is-invalid @endif" name="logradouro" value="{{{ isset($config) ? $config->logradouro : old('logradouro') }}}">
												@if($errors->has('logradouro'))
												<div class="invalid-feedback">
													{{ $errors->first('logradouro') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-2 col-lg-2">
											<label class="col-form-label">Nº</label>
											<div class="">
												<input id="numero" type="text" class="form-control @if($errors->has('numero')) is-invalid @endif" name="numero" value="{{{ isset($config) ? $config->numero : old('numero') }}}">
												@if($errors->has('numero'))
												<div class="invalid-feedback">
													{{ $errors->first('numero') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">

										<div class="form-group validated col-sm-5 col-lg-5">
											<label class="col-form-label">Bairro</label>
											<div class="">
												<input id="bairro" type="text" class="form-control @if($errors->has('bairro')) is-invalid @endif" name="bairro" value="{{{ isset($config) ? $config->bairro : old('bairro') }}}">
												@if($errors->has('bairro'))
												<div class="invalid-feedback">
													{{ $errors->first('bairro') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">CEP</label>
											<div class="">
												<input id="cep" type="text" class="form-control @if($errors->has('cep')) is-invalid @endif" name="cep" value="{{{ isset($config) ? $config->cep : old('cep') }}}">
												@if($errors->has('cep'))
												<div class="invalid-feedback">
													{{ $errors->first('cep') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">

										<div class="form-group validated col-sm-5 col-lg-5">
											<label class="col-form-label">Município</label>
											<div class="">
												<input id="municipio" type="text" class="form-control @if($errors->has('municipio')) is-invalid @endif" name="municipio" value="{{{ isset($config) ? $config->municipio : old('municipio') }}}">
												@if($errors->has('municipio'))
												<div class="invalid-feedback">
													{{ $errors->first('municipio') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Codigo do Municipio</label>
											<div class="">
												<input id="codMun" type="text" class="form-control @if($errors->has('codMun')) is-invalid @endif" name="codMun" value="{{{ isset($config) ? $config->codMun : old('codMun') }}}">
												@if($errors->has('codMun'))
												<div class="invalid-feedback">
													{{ $errors->first('codMun') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-3 col-md-3 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">UF</label>

											<select id="uf-s" class="custom-select form-control" name="uf">
												<option value="null">--</option>
												@foreach($cUF as $key => $u)
												<option 
												@if(isset($config))
												@if($key == $config->cUF)
												selected
												@endif

												@else
												@if($key == old('uf'))
												selected
												@endif

												@endif
												value="{{$key}}">{{$key}} - {{$u}}</option>
												@endforeach
											</select>
											@if($errors->has('uf'))
											<div class="invalid-feedback">
												{{ $errors->first('uf') }}
											</div>
											@endif

										</div>
									</div>

									<div class="row">

										<div class="form-group validated col-lg-3 col-md-3 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Pais</label>
											<div class="">
												<input id="pais" placeholder="BRASIL" type="text" class="form-control @if($errors->has('pais')) is-invalid @endif" name="pais" value="{{{ isset($config) ? $config->pais : old('pais') }}}">
												@if($errors->has('pais'))
												<div class="invalid-feedback">
													{{ $errors->first('pais') }}
												</div>
												@endif
											</div>

										</div>

										<div class="form-group validated col-lg-3 col-md-3 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Codigo do Pais</label>
											<div class="">
												<input id="codPais" type="text" class="form-control @if($errors->has('codPais')) is-invalid @endif" name="codPais" value="{{{ isset($config) ? $config->codPais : old('codPais') }}}">
												@if($errors->has('codPais'))
												<div class="invalid-feedback">
													{{ $errors->first('codPais') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-4 col-md-4 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Telefone</label>
											<div class="">
												<input id="telefone" type="text" class="form-control @if($errors->has('fone')) is-invalid @endif" name="fone" value="{{{ isset($config) ? $config->fone : old('fone') }}}">
												@if($errors->has('fone'))
												<div class="invalid-feedback">
													{{ $errors->first('fone') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-12 col-md-12 col-sm-12">
											<label class="col-form-label text-left col-lg-12 col-sm-12">CST/CSOSN Padrão</label>

											<select class="custom-select form-control @if($errors->has('CST_CSOSN_padrao')) is-invalid @endif" name="CST_CSOSN_padrao">
												<option value="">--</option>
												@foreach($listaCSTCSOSN as $key => $l)
												<option value="{{$key}}"
												@isset($config)
												@if($key == $config->CST_CSOSN_padrao)
												selected
												@endif
												@endisset>{{$key}} - {{$l}}</option>
												@endforeach
											</select>
											@if($errors->has('CST_CSOSN_padrao'))
											<div class="invalid-feedback">
												{{ $errors->first('CST_CSOSN_padrao') }}
											</div>
											@endif
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">CST/PIS Padrão</label>

											<select class="custom-select form-control @if($errors->has('CST_PIS_padrao')) is-invalid @endif" name="CST_PIS_padrao">
												<option value="">--</option>
												@foreach($listaCSTPISCOFINS as $key => $l)
												<option value="{{$key}}"
												@isset($config)
												@if($key == $config->CST_PIS_padrao)
												selected
												@endif
												@endisset
												>{{$key}} - {{$l}}</option>
												@endforeach
											</select>
											@if($errors->has('CST_PIS_padrao'))
											<div class="invalid-feedback">
												{{ $errors->first('CST_PIS_padrao') }}
											</div>
											@endif

										</div>

										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">CST/COFINS Padrão</label>

											<select class="custom-select form-control @if($errors->has('CST_COFINS_padrao')) is-invalid @endif" name="CST_COFINS_padrao">
												<option value="">--</option>
												@foreach($listaCSTPISCOFINS as $key => $l)
												<option value="{{$key}}"
												@isset($config)
												@if($key == $config->CST_COFINS_padrao)
												selected
												@endif
												@endisset
												>{{$key}} - {{$l}}</option>
												@endforeach
											</select>
											@if($errors->has('CST_COFINS_padrao'))
											<div class="invalid-feedback">
												{{ $errors->first('CST_COFINS_padrao') }}
											</div>
											@endif
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-12 col-md-12 col-sm-12">
											<label class="col-form-label text-left col-lg-12 col-sm-12">CST/IPI Padrão</label>

											<select class="custom-select form-control @if($errors->has('CST_IPI_padrao')) is-invalid @endif" name="CST_IPI_padrao">
												<option value="">--</option>
												@foreach($listaCSTIPI as $key => $l)
												<option value="{{$key}}"
												@isset($config)
												@if($key == $config->CST_IPI_padrao)
												selected
												@endif
												@endisset
												>{{$key}} - {{$l}}</option>
												@endforeach
											</select>
											@if($errors->has('CST_IPI_padrao'))
											<div class="invalid-feedback">
												{{ $errors->first('CST_IPI_padrao') }}
											</div>
											@endif
										</div>
									</div>


									<div class="row">
										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Frete Padrão</label>

											<select class="custom-select form-control" name="frete_padrao">
												@foreach($tiposFrete as $key => $t)
												<option value="{{$key}}"
												@isset($config)
												@if($key == $config->frete_padrao)
												selected
												@endif
												@endisset
												>{{$key}} - {{$t}}</option>
												@endforeach
											</select>

										</div>

										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Tipo de pagamento Padrão</label>

											<select class="custom-select form-control" name="tipo_pagamento_padrao">
												@foreach($tiposPagamento as $key => $t)
												<option value="{{$key}}"
												@isset($config)
												@if($key == $config->tipo_pagamento_padrao)
												selected
												@endif
												@endisset
												>{{$key}} - {{$t}}</option>
												@endforeach
											</select>

										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-12 col-md-12 col-sm-12">
											<label class="col-form-label text-left col-lg-12 col-sm-12">
												Natureza de Operação Padrão Frente de Caixa
											</label>

											<select class="custom-select form-control" name="nat_op_padrao">
												@foreach($naturezas as $n)
												<option value="{{$n->id}}"
													@isset($config)
													@if($n->id == $config->nat_op_padrao)
													selected
													@endif
													@endisset
													>{{$n->natureza}}
												</option>
												@endforeach
											</select>

										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-4 col-md-4 col-sm-4">
											<label class="col-form-label text-left col-lg-12 col-sm-12">
												Ambiente
											</label>

											<select class="custom-select form-control" name="ambiente">
												<option @if(isset($config)) @if($config->ambiente == 2) selected @endif @endif value="2">2 - Homologação</option>
												<option @if(isset($config)) @if($config->ambiente == 1) selected @endif @endif value="1">1 - Produção</option>
											</select>

										</div>

										<div class="form-group validated col-lg-4 col-md-4 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Nº Serie NF-e</label>
											<div class="">
												<input id="numero_serie_nfe" type="text" class="form-control @if($errors->has('numero_serie_nfe')) is-invalid @endif" name="numero_serie_nfe" value="{{{ isset($config) ? $config->numero_serie_nfe : old('numero_serie_nfe') }}}">
												@if($errors->has('numero_serie_nfe'))
												<div class="invalid-feedback">
													{{ $errors->first('numero_serie_nfe') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-4 col-md-4 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Nº Serie NFC-e</label>
											<div class="">
												<input id="numero_serie_nfce" type="text" class="form-control @if($errors->has('numero_serie_nfce')) is-invalid @endif" name="numero_serie_nfce" value="{{{ isset($config) ? $config->numero_serie_nfce : old('numero_serie_nfce') }}}">
												@if($errors->has('numero_serie_nfce'))
												<div class="invalid-feedback">
													{{ $errors->first('numero_serie_nfce') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-3 col-md-3 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ultimo Nº NF-e</label>
											<div class="">
												<input id="ultimo_numero_nfe" type="text" class="form-control @if($errors->has('ultimo_numero_nfe')) is-invalid @endif" name="ultimo_numero_nfe" value="{{{ isset($config) ? $config->ultimo_numero_nfe : old('ultimo_numero_nfe') }}}">
												@if($errors->has('ultimo_numero_nfe'))
												<div class="invalid-feedback">
													{{ $errors->first('ultimo_numero_nfe') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-3 col-md-3 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ultimo Nº NFC-e</label>
											<div class="">
												<input id="ultimo_numero_nfce" type="text" class="form-control @if($errors->has('ultimo_numero_nfce')) is-invalid @endif" name="ultimo_numero_nfce" value="{{{ isset($config) ? $config->ultimo_numero_nfce : old('ultimo_numero_nfce') }}}">
												@if($errors->has('ultimo_numero_nfce'))
												<div class="invalid-feedback">
													{{ $errors->first('ultimo_numero_nfce') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-3 col-md-3 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ultimo Nº CT-e</label>
											<div class="">
												<input id="ultimo_numero_cte" type="text" class="form-control @if($errors->has('ultimo_numero_cte')) is-invalid @endif" name="ultimo_numero_cte" value="{{{ isset($config) ? $config->ultimo_numero_cte : old('ultimo_numero_cte') }}}">
												@if($errors->has('ultimo_numero_cte'))
												<div class="invalid-feedback">
													{{ $errors->first('ultimo_numero_cte') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-3 col-md-3 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ultimo Nº MDF-e</label>
											<div class="">
												<input id="ultimo_numero_mdfe" type="text" class="form-control @if($errors->has('ultimo_numero_mdfe')) is-invalid @endif" name="ultimo_numero_mdfe" value="{{{ isset($config) ? $config->ultimo_numero_mdfe : old('ultimo_numero_mdfe') }}}">
												@if($errors->has('ultimo_numero_mdfe'))
												<div class="invalid-feedback">
													{{ $errors->first('ultimo_numero_mdfe') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">CSC</label>
											<div class="">
												<input id="csc" type="text" class="form-control @if($errors->has('csc')) is-invalid @endif" name="csc" value="{{{ isset($config) ? $config->csc : old('csc') }}}">
												@if($errors->has('csc'))
												<div class="invalid-feedback">
													{{ $errors->first('csc') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-3 col-md-3 col-sm-3">
											<label class="col-form-label text-left col-lg-12 col-sm-12">CSCID</label>
											<div class="">
												<input id="csc_id" type="text" class="form-control @if($errors->has('csc_id')) is-invalid @endif" name="csc_id" value="{{{ isset($config) ? $config->csc_id : old('csc_id') }}}">
												@if($errors->has('csc_id'))
												<div class="invalid-feedback">
													{{ $errors->first('csc_id') }}
												</div>
												@endif
											</div>
										</div>

										<!-- <div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Certificado A3</label>
											<div class="col-6">
												<span class="switch switch-outline switch-primary">
													<label>
														<input id="certificado_a3" @if(isset($config->certificado_a3) && $config->certificado_a3) checked @endisset
														name="certificado_a3" type="checkbox" >
														<span></span>
													</label>
												</span>
											</div>
											<p style="color: red">*Em desenvolvimento</p>

										</div> -->

									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="card-footer">

						<div class="row">
							<div class="col-xl-2">

							</div>
							<div class="col-lg-3 col-sm-6 col-md-4">
								<a style="width: 100%" class="btn btn-danger" href="/clientes">
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
				</div>
			</form>
		</div>
	</div>
</div>

@endsection