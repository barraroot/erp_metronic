@extends('relatorios.v2.base')

@section('report_name', 'Relatório de Contas a Pagar')

@section('report_name_subtitle')
    Período: {{$data_inicial}} - {{$data_final}}
@endsection

@section('main_container', 'container-fluid')

@section('content')
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>FORNECEDOR</th>
                <th>REFERÊNCIA</th>
                <th>CATEGORIA</th>
                <th>DATA DE REGISTRO</th>
                <th>DATA DE VENCIMENTO</th>
                <th>VALOR TOTAL</th>
                <th>VALOR PAGO</th>
                <th>STATUS</th>
            </tr>
            </thead>

            <tbody>
            @foreach($contas as $conta)
                <tr>
                    <td>{{ $conta->compra->fornecedor->razao_social ?? '--' }}</td>
                    <td>{{ $conta->referencia }}</td>
                    <td>{{ $conta->categoria->nome ?? '--' }}</td>
                    <td>{{ $conta->dataRegistro }}</td>
                    <td>{{ $conta->dataVencimentoFormatado }}</td>
                    <td>R$ {{ number_format($conta->valor_integral, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($conta->valor_pago, 2, ',', '.') }}</td>
                    <td>{{ $conta->status ? 'PAGO' : 'PENDENTE' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-12">
        <p>VALOR A PAGAR: <strong class="text-danger">R$ {{ number_format($contas->where('status', false)->sum('valor_integral'), 2, ',', '.') }}</strong></p>
        <p>VALOR PAGO: <strong class="text-danger">R$ {{ number_format($contas->sum('valor_pago'), 2, ',', '.') }}</strong></p>
    </div>
@endsection

