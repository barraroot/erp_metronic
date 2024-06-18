@extends('relatorios_base.v2.base')

@section('report_name', 'Relatório de Clientes')

@section('report_name_subtitle')
    Período: 
@endsection

@section('main_container', 'container-fluid')

@section('content')
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>RAZÃO SOCIAL</th>
                <th>CPF/CNPJ</th>
                <th>IE/RG</th>
                <th>ENDEREÇO</th>
                <th>CIDADE</th>
            </tr>
            </thead>

            <tbody>
            @foreach($clientes as $c)
                <tr>
                    <td>{{ $c->razao_social }}</td>
                    <td>{{ $c->cpf_cnpj }}</td>
                    <td>{{ $c->ie_rg }}</td>
                    <td>{{ $c->rua }}, {{ $c->numero }} - {{ $c->bairro }}</td>
                    <td>{{ $c->cidade->nome }}, ({{ $c->cidade->uf }})</td>
                    
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-12">
        <p>REGISTROS: <strong class="text-danger">{{sizeof($clientes)}} </strong></p>
    </div>
@endsection

