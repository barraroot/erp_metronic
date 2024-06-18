<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedidoDelivery extends Model
{
    protected $fillable = [
        'pedido_id', 'produto_id', 'status', 'quantidade', 'observacao', 'tamanho_id', 'impresso'
    ];

    public function produto(){
        return $this->belongsTo(ProdutoDelivery::class, 'produto_id');
    }

    public function tamanho(){
        return $this->belongsTo(TamanhoPizza::class, 'tamanho_id');
    }

    public function itensAdicionais(){
        return $this->hasMany('App\Models\ItemPedidoComplementoDelivery', 'item_pedido_id', 'id');
    }

    public function pedido(){
        return $this->belongsTo(PedidoDelivery::class, 'pedido_id');
    }

    public function sabores(){
        return $this->hasMany('App\Models\ItemPizzaPedido', 'item_pedido', 'id');
    }

    public function valorProduto(){

        if(sizeof($this->sabores) == 0){
            $valor = $this->produto->valor;
            foreach($this->itensAdicionais as $ad){
                $valor += $ad->adicional->valor;
            }
            return $valor;
        }else{

            $maiorValor = 0;
            $somaValores = 0;

            foreach($this->sabores as $sb){

                $sb->produto->produto;

                $v = $sb->maiorValor($sb->sabor_id, $this->tamanho_id);
                $somaValores += $v;

                if($v > $maiorValor) $maiorValor = $v;

            }

            if(getenv("DIVISAO_VALOR_PIZZA") == 1){

                $maiorValor = $somaValores/sizeof($this->sabores);

            }

            foreach($this->itensAdicionais as $ad){
                $maiorValor += $ad->adicional->valor;
            }
            return $maiorValor;
        }
    }

    public function nomeDoProduto(){

        if(sizeof($this->sabores) == 0){
            $nome = $this->produto->produto->nome;
            if($this->observacao != '') $nome .= " | OBS: " . $this->observacao;
            
        }else{
            $nome = "Tamanho: " . $this->tamanho->nome();
            $cont = 1;
            $nome .= " | ";
            foreach($this->sabores as $s){
                $nome .= "".$cont."/".count($this->sabores) . " " . $s->produto->produto->nome;
            }
            
            if($this->observacao != '') $nome .= " | OBS: " . $this->observacao;
        }

        if(sizeof($this->itensAdicionais) > 0){
            $nome .= " | Adicional: ";

            foreach($this->itensAdicionais as $s){
                $nome .= " " . $s->adicional->nome();
            }
        }


        return $nome;
    }

    public function nomeDoProduto2(){
        if(count($this->sabores) == 0){
            $nome = $this->produto->produto->nome;
            if($this->observacao != ''){
                $nome .= " | obs: " .$this->observacao;
            }

            if(sizeof($this->itensAdicionais) > 0){
                $str = "\nAdicional: ";

                // $str = "";
                $add = false;
                foreach($this->itensAdicionais as $key => $a){
                    if($a->adicional->categoria->adicional){
                        $str .= $a->adicional->nome . ", ";
                        $add = true;

                    }
                }

                if($add){
                    $str = substr($str, 0, strlen($str)-2);
                    $nome .= $str;
                }


                $str = "";
                $nome .= "\nComplemento: ";
                foreach($this->itensAdicionais as $key => $a){
                    if(!$a->adicional->categoria->adicional){
                        $str .= "\n* ".$a->adicional->nome;
                    }
                }

                if(strlen($str) > 0){
                    $str = substr($str, 0, strlen($str)-2);
                    $nome .= $str;
                }
            }

            return $nome;
        }else{
            $cont = 1;
            $nome = "";
            foreach($this->sabores as $s){
                $nome .= $cont."/".count($this->sabores) . " " . $s->produto->produto->nome;
            }
            $nome .= " | Tamanho: " . $this->tamanho->nome();

            if(sizeof($this->itensAdicionais) > 0){
                $nome .= " | Adicional: ";
                foreach($this->itensAdicionais as $key => $a){
                    $nome .= $a->adicional->nome() . ($key == sizeof($this->itensAdicionais)-1 ? "" : ", ");
                }
            }

            if($this->observacao != ''){
                $nome .= " | " .$this->observacao;
            }
            return $nome;
        }
    }

    public static function maisVendidosDaSemana(){

        return [];
        $dataInicial = date('Y-m-d', strtotime("-7 days"));
        $dataFinal = date('Y-m-d');

        // $c = ItemPedidoDelivery::
        // selectRaw('item_pedido_deliveries.*, sum(item_pedido_deliveries.quantidade) as soma')
        // ->join('produto_deliveries', 'produto_deliveries.id', '=', 'item_pedido_deliveries.produto_id')
        // ->whereBetween('item_pedido_deliveries.created_at', [$dataInicial, 
        //     $dataFinal])
        // ->orderBy('soma', 'asc')
        // ->groupBy('produto_deliveries.id')
        // ->limit(8);

        $c = ItemPedidoDelivery::
        selectRaw('item_pedido_deliveries.*, sum(item_pedido_deliveries.quantidade) as soma')
        ->join('produto_deliveries', 'produto_deliveries.id', '=', 'item_pedido_deliveries.produto_id')
        ->whereBetween('item_pedido_deliveries.created_at', [$dataInicial, 
            $dataFinal])
        ->orderBy('soma', 'asc')
        ->groupBy('produto_deliveries.id')
        ->limit(8);
        return $c->get();
    }
}
