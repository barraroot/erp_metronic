<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
        	'nome' => 'Sistema',
        	'login' => 'flowsys',
        	'senha' => '202cb962ac59075b964b07152d234b70',
            'adm' => 1,
        	'ativo' => 1,
        	'acesso_cliente' => 1,
        	'acesso_fornecedor' => 1,
        	'acesso_produto' => 1,
        	'acesso_financeiro' => 1,
        	'acesso_caixa' => 1,
        	'acesso_estoque' => 1,
        	'acesso_compra' => 1,
        	'acesso_fiscal' => 1,
            'venda_nao_fiscal' => 1,
            'acesso_cte' => 1,
            'acesso_mdfe' => 1
        ]);
    }
}
