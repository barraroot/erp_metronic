<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dres', function (Blueprint $table) {
            $table->increments('id');

            $table->date('inicio');
            $table->date('fim');

            $table->string('observacao', 300);
            $table->decimal('percentual_imposto', 5, 2)->default(0);
            $table->decimal('lucro_prejuizo', 12, 2)->default(0);

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
        Schema::dropIfExists('dres');
    }
}
