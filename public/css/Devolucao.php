<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devolucao extends Model
{
	protected $fillable = [
		'fornecedor_id', 'usuario_id', 'natureza_id', 'data_registro', 'valor_integral', 
		'valor_devolvido', 'motivo', 'observacao', 'estado', 'devolucao_parcial', 
		'chave_nf_entrada', 'nNf', 'vFrete', 'vDesc', 'chave_gerada', 'numero_gerado', 'empresa_id'
	];

	public function fornecedor(){
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function natureza(){
        return $this->belongsTo(NaturezaOperacao::class, 'natureza_id');
    }

    public function itens(){
        return $this->hasMany('App\ItemDevolucao', 'devolucao_id', 'id');
    }

    public static function getTrib($objeto){


        $arr = (array_values((array)$objeto->ICMS));

        $cst = $arr[0]->CST ?? $arr[0]->CSOSN;

        $pICMS = $arr[0]->pICMS ?? 0;
        $vICMS = $arr[0]->vICMS ?? 0;
        $pRedBC = $arr[0]->pRedBC ?? 0;

        $vBC = $arr[0]->vBC ?? 0;

        $arr = (array_values((array)$objeto->PIS));
        $pis = $arr[0]->CST ?? $arr[0]->CSOSN;
        $pPIS = $arr[0]->pPIS ?? 0;

        $arr = (array_values((array)$objeto->COFINS));
        $cofins = $arr[0]->CST ?? $arr[0]->CSOSN;
        $pCOFINS = $arr[0]->COFINS ?? 0;

        $arr = (array_values((array)$objeto->IPI));
        if(isset($arr[1])){
            $ipi = $arr[1]->CST ?? $arr[1]->CSOSN;
            $pIPI = $arr[0]->IPI ?? 0;
        }else{
            $ipi = '99';
            $pIPI = 0;
        }

        $data = [
            'cst_csosn' => (string)$cst,
            'pICMS' => (float)$pICMS,
            'cst_pis' => (string)$pis,
            'pPIS' => (float)$pPIS,
            'cst_cofins' => (string)$cofins,
            'pCOFINS' => (float)$pCOFINS,
            'cst_ipi' => (string)$ipi,
            'pIPI' => (float)$pIPI,
            'pRedBC' => (float)$pRedBC,
            'vBC' => (float)$vBC,
            'vICMS' => (float)$vICMS
        ];

        return $data;

    }
}
