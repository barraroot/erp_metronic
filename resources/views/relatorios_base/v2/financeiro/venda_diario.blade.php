@extends('relatorios.v2.base')

@section('report_name')
    Relátorio de Venda {{$data_inicial}}
@endsection

@section('style')
    <style>
        .list p {
            margin: 0;
        }

        .list p:last-child {
            margin-bottom: 10px;
        }

    </style>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-borderless table-striped">
            <thead>
            <tr>
                <th>VENDA ID</th>
                <th>HORA DA VENDA</th>
                <th>ITENS</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
            <?php $soma = 0; $inc = 0; ?>
            @foreach($vendas as $v)
                <tr>
                    <td>#{{$v['id']}}</td>
                    <td>{{$v['data']}}</td>
                    <td>
                        <ol>
                            @foreach($v['itens'] as $i)
                                <li class="list">
                                    <p>{{$i->produto->nome}}</p>
                                    <p>{{$i->quantidade}} ({{$i->produto->unidade_venda}})
                                        x R$ {{number_format($i->valor, 2, ',', '.')}} =
                                        R$ {{number_format(($i->quantidade * $i->valor), 2, ',', '.')}}</p>
                                </li>
                                @if(!$loop->last)
                                    <hr>@endif
                            @endforeach
                        </ol>
                    </td>
                    <td>{{number_format($v['total'], 2)}}</td>
                </tr>
                <?php $soma += $v['total']; $inc++;?>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-12">
        <p>Total de vendas: <strong style="color: red">{{$inc}}</strong></p>
        <p>Valor Total: <strong style="color: green">R$ {{number_format($soma, 2)}}</strong></p>
    </div>
@endsection
