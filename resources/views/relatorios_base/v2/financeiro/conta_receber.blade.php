@extends('relatorios.v2.base')

@section('report_name', 'Relatório de Contas a Receber')

@section('report_name_subtitle')
    Período: {{$data_inicial}} - {{$data_final}}
@endsection

@section('main_container', 'container-fluid')

@section('content')
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>CLIENTE</th>
                <th>REFERÊNCIA</th>
                <th>CATEGORIA</th>
                <th>DATA DE REGISTRO</th>
                <th>DATA DE VENCIMENTO</th>
                <th>VALOR TOTAL</th>
                <th>VALOR RECEBIDO</th>
                <th>STATUS</th>
            </tr>
            </thead>

            <tbody>
            @foreach($contas as $conta)
                <tr>
                    <td>{{ $conta->venda->cliente->razao_social ?? '--' }}</td>
                    <td>{{ $conta->referencia }}</td>
                    <td>{{ $conta->categoria->nome ?? '--' }}</td>
                    <td>{{ $conta->dataRegistro }}</td>
                    <td>{{ $conta->dataVencimentoFormatado }}</td>
                    <td>R$ {{ number_format($conta->valor_integral, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($conta->valor_recebido, 2, ',', '.') }}</td>
                    <td>{{ $conta->status ? 'RECEBIDO' : 'PENDENTE' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-12">
        <p>VALOR A RECEBER: <strong class="text-danger">R$ {{ number_format($contas->where('status', false)->sum('valor_integral'), 2 , ',', '.') }}</strong></p>
        <p>VALOR A RECEBIDO: <strong class="text-success">R$ {{ number_format($contas->sum('valor_recebido'), 2 , ',', '.') }}</strong></p>
    </div>
@endsection

