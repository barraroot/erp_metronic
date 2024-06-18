@extends('relatorios.v2.base')

@section('report_name')
    Cotação Referência <span style="color: red">{{$cotacao->referencia}}</span>
@endsection

@section('report_name_subtitle')
    <p>Fornecedor: <strong>{{$fornecedor->razao_social}}</strong></p>
    <p>CPF/CNPJ: <strong>{{$fornecedor->cpf_cnpj}}</strong></p>
    <p>Escolhida? <strong>{{$cotacao->escolhida ? 'Sim' : 'Não'}}</strong></p>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>ITEM</th>
                <th>VALOR UNIT</th>
                <th>QUANTIDADE</th>
                <th>SUB TOTAL</th>
            </tr>
            </thead>



            <tbody>
            <?php $soma = 0; ?>
            @foreach($itens as $key => $i)
                <tr class="@if($key%2 == 0) pure-table-odd @endif">
                    <td>{{$i['item']}}</td>
                    <td>R$ {{number_format($i['valor_unitario'], 2, ',', '.')}}</td>
                    <td>{{number_format($i['quantidade'], 2)}}</td>
                    <td>R$ {{number_format($i['valor_total'], 2, ',', '.')}}</td>

                    <?php $soma += $i['valor_total']; ?>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="col-sm-12">
            <p>Total: <strong style="color: red">R$ {{number_format($soma, 2, ',', '.')}}</strong></p>
        </div>
    </div>
@endsection
