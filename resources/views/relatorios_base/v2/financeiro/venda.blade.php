@extends('relatorios.v2.base')

@if(isset($data_final))
    @section('report_name', 'Relatório de Vendas')

    @section('report_name_subtitle')
        Período: de {{$data_inicial}} à {{$data_final}}
    @endsection
@else
    @section('report_name')
        Relátorio de Venda {{$data_inicial}}
    @endsection
@endif

@section('style')
    <style>
        .list p {
            margin: 0;
        }

        .list p:last-child {
            margin-bottom: 10px;
        }
        hr {
            margin: 5px;
        }

    </style>
@endsection

@section('main_container', 'container-fluid')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-condensed">
            <thead>
            <tr>
                <th>VENDA NÚMERO</th>
                <th>DATA</th>
                <th>CLIENTE</th>
                <th>ORIGEM VENDA</th>
                <th>NF-e/NFC-e</th>
                <th>ITENS</th>
                <th>Tipo Pagamento</th>
                <th>DESCONTO</th>
                <th>ACRÉSCIMO</th>
                <th>TOTAL</th>
                <th>ESTADO</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vendas as $venda)
                <tr>
                    <td class="text-center">{{ $venda->id }}</td>
                    <td>{{ $venda->dataRegistroFormatada }}</td>
                    <td>{{ $venda->cliente->razao_social ?? 'CLIENTE NÃO IDENTIFICADO' }}</td>
                    <td>{{ class_basename($venda) === 'VendaCaixa' ? 'PDV' : 'VENDAS' }}</td>
                    <td>{{ $venda->nfeOrNfce }}</td>
                    <td>
                        <ol>
                            @foreach($venda->itens as $item)
                                <li class="list">
                                    <p><strong>Produto:</strong> {{ $item->produto->nome ?? '-' }}</p>
                                    <p><strong>Quantidade:</strong> {{ $item->quantidade ?? '-' }}</p>
                                    <p><strong>Valor Unitário:</strong>
                                        R$ {{ number_format($item->valor, 2, ',', '.') }}</p>
                                </li>
                                @if(!$loop->last)<hr>@endif
                            @endforeach
                        </ol>
                    </td>
                    <td>{{ $venda->getTipoPagamento($venda->tipo_pagamento) }}</td>
                    <td>R$ {{number_format($venda->desconto, 2, ',', '.')}}</td>
                    <td>R$ {{number_format($venda->acrescimo ?? 0, 2, ',', '.')}}</td>
                    <td>R$ {{number_format(($venda->valorTotalCalculado), 2, ',', '.')}}</td>
                    <td>{{ $venda->estado }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
