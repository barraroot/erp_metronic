<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigEcommercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_ecommerces', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome', 30);
            $table->string('link', 30);
            $table->string('logo', 80);
            $table->string('rua', 80);
            $table->string('numero', 10);
            $table->string('bairro', 30);
            $table->string('cidade', 30);
            $table->string('uf', 2);
            
            $table->string('cep', 10);
            $table->string('telefone', 15);
            $table->string('email', 60);
            $table->string('link_facebook', 120);
            $table->string('link_twiter', 120);
            $table->string('link_instagram', 120);
            $table->decimal('frete_gratis_valor', 10, 2);
            $table->string('mercadopago_public_key', 120);
            $table->string('mercadopago_access_token', 120);
            $table->string('funcionamento', 120);
            $table->string('latitude', 10);
            $table->string('longitude', 10);
            $table->text('politica_privacidade');
            $table->text('src_mapa');
            $table->string('cor_principal', 8);
            $table->string('tema_ecommerce', 30);
            $table->string('token', 30);

            $table->string('google_api', 40)->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_ecommerces');
    }
}
