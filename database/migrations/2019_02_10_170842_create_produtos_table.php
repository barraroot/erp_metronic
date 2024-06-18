<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome', 100);
            $table->string('cor', 20);
            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias')
            ->onDelete('cascade');
            $table->decimal('valor_venda', 10,2)->default(0);
            $table->decimal('valor_compra', 10,2)->default(0);
            $table->string('NCM', 13)->default("");
            $table->string('codBarras', 13)->default("");
            $table->string('CEST', 10)->default("");
            $table->string('CST_CSOSN', 3)->default("");
            $table->string('CST_PIS', 3)->default("");
            $table->string('CST_COFINS', 3)->default("");
            $table->string('CST_IPI', 3)->default("");

            $table->string('unidade_compra', 10);
            $table->string('conversao_unitaria')->default(1);
            $table->string('unidade_venda', 10);
            $table->boolean('composto')->default(false);
            $table->boolean('valor_livre');

            $table->decimal('perc_icms', 10,2)->default(0);
            $table->decimal('perc_pis', 10,2)->default(0);
            $table->decimal('perc_cofins', 10,2)->default(0);
            $table->decimal('perc_ipi', 10,2)->default(0);
            $table->decimal('perc_iss', 10,2)->default(0);
            $table->decimal('pRedBC', 5,2)->default(0);
            $table->string('cBenef',10)->default('');

            $table->string('cListServ', 5);

            $table->string('CFOP_saida_estadual', 5);
            $table->string('CFOP_saida_inter_estadual', 5);

            $table->string('codigo_anp', 10);
            $table->string('descricao_anp', 95);
            $table->decimal('perc_glp', 5,2)->default(0);
            $table->decimal('perc_gnn', 5,2)->default(0);
            $table->decimal('perc_gni', 5,2)->default(0);
            $table->decimal('valor_partida', 10, 2)->default(0);
            $table->string('unidade_tributavel', 4)->default('');
            $table->decimal('quantidade_tributavel', 10, 2)->default(0);

            // alter table produtos add column perc_glp decimal(10,2) default 0;
            // alter table produtos add column perc_gnn decimal(10,2) default 0;
            // alter table produtos add column perc_gni decimal(10,2) default 0;
            // alter table produtos add column valor_partida decimal(10,2) default 0;
            // alter table produtos add column quantidade_tributavel decimal(10,2) default 0;
            // alter table produtos add column unidade_tributavel varchar(4) default '';

            
            $table->string('imagem', 100);
            $table->integer('alerta_vencimento');
            $table->boolean('gerenciar_estoque');
            $table->integer('estoque_minimo')->default(0);
            $table->string('referencia', 25)->default('');
            $table->integer('referencia_balanca')->default(0);

            $table->integer('tela_id')->nullable()->unsigned();
            $table->foreign('tela_id')->references('id')->on('tela_pedidos')->onDelete('cascade');
            
            $table->decimal('largura', 6, 2)->default(0);
            $table->decimal('comprimento', 6, 2)->default(0);
            $table->decimal('altura', 6, 2)->default(0);
            $table->decimal('peso_liquido', 8, 3)->default(0);
            $table->decimal('peso_bruto', 8, 3)->default(0);

            $table->string('referencia_grade', 20)->default('');
            $table->boolean('grade')->default(false);
            $table->string('str_grade', 20)->default('');

            // alter table produtos add column referencia_grade varchar(20) default '';
            // alter table produtos add column str_grade varchar(20) default '';
            // alter table produtos add column grade boolean default false;

            // alter table produtos add column grade boolean default false;
            // alter table produtos add column referencia_balanca integer default 0;


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
        Schema::dropIfExists('produtos');
    }
}
