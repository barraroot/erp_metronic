@extends('relatorios.v2.base')

@section('report_name')
    Relátorio de Produtos {{$ordem}} Vendidos
@endsection

@section('report_name_subtitle')
    Período: de {{$data_inicial}} à {{$data_final}}
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th class="text-center">CÓD PRODUTO</th>
                <th class="text-center">PRODUTO</th>
                <th class="text-center">TOTAL QTD</th>
                <th class="text-center">TOTAL R$</th>
            </tr>
            </thead>

            <tbody>
            @foreach($itens as $item)
                <tr class="text-center">
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['nome'] }} - R$ {{number_format($item['valor_venda'], 2)}}UN</td>
                    <td>{{number_format($item['total'], 2)}}</td>
                    <td>{{number_format($item['total_dinheiro'], 2)}}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
@endsection