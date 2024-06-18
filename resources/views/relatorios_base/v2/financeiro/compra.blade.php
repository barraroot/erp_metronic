@extends('relatorios.v2.base')

@section('report_name', 'Relatório de Compras')

@section('report_name_subtitle')
    @if($data_inicial && $data_final)
        Período: {{$data_inicial}} - {{$data_final}}
    @endif
@endsection

@section('style')
    <style>
        .list p {
            margin: 0;
        }

        .list p:last-child {
            margin-bottom: 5px;
        }
        hr {
            margin-top: 2px;
            margin-bottom: 2px;
        }
    </style>
@endsection

@section('main_container', 'container-fluid')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-condensed">
            <thead>
            <tr>
                <th>DATA</th>
                <th>FORNECEDOR</th>
                <th class="text-center">ITENS</th>
                <th>NF-e</th>
                <th>DESCONTO</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
            @foreach($compras as $compra)
                <tr>
                    <td>{{ $compra->created_at->format('d/m/Y') }}</td>
                    <td>{{$compra->fornecedor->razao_social ?? '-'}}</td>
                    <td>
                        <ol>
                            @foreach($compra->itens as $item)
                                <li class="list">
                                    <p><strong>Produto:</strong> {{ $item->produto->nome ?? '-' }}</p>
                                    <p><strong>Quantidade:</strong> {{ $item->quantidade ?? '-' }}</p>
                                    <p><strong>Valor Unitário:</strong>
                                        R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</p>
                                </li>
                                @if(!$loop->last)<hr>@endif
                            @endforeach
                        </ol>
                    </td>
                    <td>{{ $compra->nf > 0 ? $compra->nf : '--' }}</td>
                    <td>R$ {{number_format($compra->desconto, 2, ',', '.')}}</td>
                    <td>R$ {{number_format(($compra->valor - $compra->desconto), 2, ',', '.')}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
