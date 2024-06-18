@extends('relatorios.v2.base')

@section('report_name')
    Relátorio de cobrança pendente
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
                <th>CLIENTE</th>
                <th>DATA REGISTRO</th>
                <th>VENCIMENTO</th>
                <th>VALOR</th>
            </tr>
            </thead>
            <tbody>
            <?php $soma = 0; ?>
            @foreach($contas as $v)
                <tr>
                    @if($v->venda_id != NULL)
                        <td>{{$v->venda->cliente->razao_social}}</td>
                    @else
                        <td>--</td>
                    @endif
                    <td>{{\Carbon\Carbon::parse($v->created_at)->format('d/m/Y')}}</td>
                    <td>{{\Carbon\Carbon::parse($v->data_vencimento)->format('d/m/Y')}}</td>
                    <td>{{number_format($v->valor_integral, 2)}}</td>
                </tr>
                <?php $soma += $v->valor_integral; ?>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-12">
        <p>SOMA: <strong style="color: green">R$ {{number_format($soma, 2)}}</strong></p>
    </div>
@endsection
