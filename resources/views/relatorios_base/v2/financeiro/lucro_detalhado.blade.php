@extends('relatorios.v2.base')

@section('report_name', 'Relátorio de Lucro Detalhado')

@section('report_name_subtitle')
    @if($data_inicial)
        <h4>Data: {{$data_inicial}}</h4>
    @endif
@endsection

@section('main_container', 'container-fluid')

@section('content')
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>HORÁRIO</th>
                <th>LOCAL</th>
                <th>CLIENTE</th>
                <th>VALOR VENDA/COMPRA</th>
                <th>LUCRO</th>
                <th>%LUCRO</th>
            </tr>
            </thead>
            <tbody>
            @php
                $somaPerc =0;
            @endphp
            @foreach($vendas as $venda)
                <tr>
                    <td>{{$venda->created_at->format('H:i')}}</td>
                    <td>{{class_basename($venda) === 'Venda' ? 'NF-e' : 'PDV'}}</td>
                    <td>{{$venda->cliente->razao_social ?? "Cliente Padrão"}}</td>
                    <td>
                        R$ {{number_format($venda->valor_total, 2, ',', '.')}} /
                        R$ {{number_format($venda->somaValorCompra(), 2, ',', '.')}}
                    </td>
                    <td>R$ {{number_format(($venda->valor_total - $venda->somaValorCompra()), 2, ',', '.')}}</td>
                    <td>
                        @php
                            $somaPerc += (($venda->somaValorCompra() - $venda->valor_total) / $venda->somaValorCompra() * 100) * -1;
                        @endphp
                        {{number_format((($venda->somaValorCompra() - $venda->valor_total) / $venda->somaValorCompra() * 100) * -1, 2 ,',','.')}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-sm-12">
        <p>Total lucro:
            <strong class="text-success">
                R$ {{number_format(($vendas->sum('valor_total') - $vendas->sum('somaValorCompra')), 2, ',', '.')}}
            </strong>
        </p>
        <p>% Médio:
            <strong class="text-danger">
                {{ number_format($somaPerc/($vendas->count() === 0 ? 1 : $vendas->count()), 2, ',', '.') }}
            </strong>
        </p>
    </div>
@endsection
