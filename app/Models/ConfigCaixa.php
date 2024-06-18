<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigCaixa extends Model
{
    use HasFactory;

    protected $fillable = [
		'finalizar', 'reiniciar', 'editar_desconto', 'editar_acrescimo', 'editar_observacao', 
		'setar_valor_recebido', 'forma_pagamento_dinheiro', 'forma_pagamento_debito',
		'forma_pagamento_credito', 'forma_pagamento_pix', 'setar_leitor', 
		'valor_recebido_automatico', 'usuario_id', 'modelo_pdv', 'impressora_modelo'
	];
}
