@extends('relatorios.v2.base')

@section('report_name', 'Relatório de Manifesto')

@section('report_name_subtitle')
    Período: {{$data_inicial}} - {{$data_final}}
@endsection

@section('main_container', 'container-fluid')

@section('content')
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Documento</th>
                <th>Valor</th>
                <th>Data Emissão</th>
                <th>Num. Protocolo</th>
                <th>Chave</th>
                <th>Estado</th>
            </tr>
            </thead>

            <tbody>
            @foreach($docs as $doc)
                <tr>
                    <td>{{$doc->nome}}</td>
                    <td>{{$doc->documento}}</td>
                    <td>R$ {{number_format($doc->valor, 2, ',','.')}}</td>
                    <td>{{$doc->dataEmissaoFormatado}}</td>
                    <td>{{$doc->num_prot}}</td>
                    <td>{{$doc->chave}}</td>
                    <td>{{$doc->estado()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

