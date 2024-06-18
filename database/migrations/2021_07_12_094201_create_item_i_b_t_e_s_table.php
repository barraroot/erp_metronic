<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemIBTESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_i_b_t_e_s', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('ibte_id')->unsigned();
            $table->foreign('ibte_id')->references('id')->on('i_b_p_t_s')->onDelete('cascade');

            $table->string('codigo', 8);
            $table->string('descricao', 80);
            $table->decimal('nacional_federal', 5,2);
            $table->decimal('importado_federal', 5,2);
            $table->decimal('estadual', 5,2);
            $table->decimal('municipal', 5,2);
            
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
        Schema::dropIfExists('item_i_b_t_e_s');
    }
}
