<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigEcommerce extends Model
{
	protected $fillable = [
		'nome', 'link', 'logo', 'rua', 'numero', 'bairro', 'cidade', 'cep', 'telefone',
		'email', 'link_facebook', 'link_twiter', 'link_instagram', 'frete_gratis_valor', 
		'mercadopago_public_key', 'mercadopago_access_token', 'funcionamento', 'latitude',
		'longitude', 'politica_privacidade', 'src_mapa', 'cor_principal', 
		'google_api', 'tema_ecommerce', 'uf'
	];
}
