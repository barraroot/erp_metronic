@extends('relatorios.v2.base')

@section('report_name', 'Relátorio de Lucro')

@section('report_name_subtitle')
    @if($data_inicial && $data_final)
        <h4>Periodo: {{$data_inicial}} - {{$data_final}}</h4>
    @endif
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>DATA</th>
                <th>LUCRO PDV</th>
                <th>LUCRO VENDA NF-e</th>
                <th>SOMA</th>
            </tr>
            </thead>
            <tbody>
            <?php $somaLucro = 0; ?>
            @foreach($lucros as $v)
                <tr>
                    <td>{{$v['data']}}</td>
                    <td>R$ {{number_format($v['valor_caixa'], 2)}}</td>
                    <td>R$ {{number_format($v['valor'], 2)}}</td>
                    <td>R$ {{number_format($v['valor'] + $v['valor_caixa'], 2)}}</td>
                </tr>

                <?php $somaLucro += $v['valor'] + $v['valor_caixa'] ?>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-12">
        <p>Total lucro: <strong style="color: green">R$ {{number_format($somaLucro, 2)}}</strong></p>
    </div>
@endsection
