@extends('relatorios.v2.base')

@section('report_name')
    Relátorio de Vendas Por Clientes {{$ordem}} Vendidos
@endsection

@section('report_name_subtitle')
    @if($data_inicial && $data_final)
        Periodo: {{$data_inicial}} - {{$data_final}}
    @endif
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>CÓD CLIENTE</th>
                <th>NOME</th>
                <th>TOTAL DE VENDAS</th>
                <th>TOTAL EM R$</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vendas as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->nome}}</td>
                    <td>{{number_format($v->total, 0)}}</td>
                    <td>{{number_format($v->total_dinheiro, 2)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
