@extends('relatorios.v2.base')

@section('report_name', 'Relátorio de Estoque Mínimo')

@section('report_name_subtitle')
    Período: {{$data_inicial}} - {{$data_final}}
@endsection

@section('style')
    <style>
        th, td {
            font-size: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-sm align-middle table-striped">
            <thead>
            <tr class="text-center">
                <th>PRODUTO</th>
                <th>UNIDADE COMPRA</th>
                <th>REFERÊNCIA</th>
                <th>CATEGORIA</th>
                <th>TOTAL DISPONIVEL</th>
                <th>ESTOQUE MINIMO</th>
                <th>TOTAL A COMPRAR</th>
                <th>VALOR DE COMPRA ANTERIOR POR ITEM</th>
            </tr>
            </thead>

            <tbody>
            @foreach($itens['produtos'] as $item)
                <tr class="text-center">
                    <td>{{ $item['produto']['nome'] }}</td>
                    <td>{{ $item['produto']['unidade_compra'] }}</td>
                    <td>{{ $item['produto']['referencia'] ?? "-" }}</td>
                    <td>{{ $item['produto']['categoria']['nome'] ?? "-" }}</td>
                    <td>{{ number_format($item['estoque_atual']['quantidade'], 2) }}</td>
                    <td>{{ number_format($item['produto']['estoque_minimo'], 2) }}</td>
                    <td>{{ $item['total_comprar'] }}</td>
                    <td>{{ $item['valor_compra'] }}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

    <div class="col-12">
        <p>Total de itens para comprar: <strong style="color: red">{{number_format($itens['totais']['soma_itens'], 2)}}</strong></p>
        <p>Valor presumido: <strong style="color: red">R$ {{number_format($itens['totais']['valor_total'], 2, ',', '.')}}</strong></p>
    </div>
@endsection