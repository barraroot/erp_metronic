<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteEcommercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_ecommerces', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome', 30);
            $table->string('sobre_nome', 30);
            $table->string('cpf', 18);
            $table->string('email', 60);
            $table->string('telefone', 15);
            $table->string('senha', 100);
            $table->boolean('status')->default(true);
            
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
        Schema::dropIfExists('cliente_ecommerces');
    }
}
