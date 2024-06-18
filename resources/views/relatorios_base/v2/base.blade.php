<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="{{ public_path('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            color: #333;
        }

        body {
            background-color: #FFF;
        }

        .page-break {
            page-break-after: always;
        }

        .subtitle_heading {
            font-size: 13px;
            margin-bottom: 0;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
        }
    </style>

    @yield('style')
</head>

<body>

    <footer>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-right">
                        Relatório gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:m:i') }} - {{ request()->fullUrl() }}
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <div class="@yield('main_container', 'container')">

        <div class="row">
            <table class="table">
                <tbody>
                    <tr class="text-center">
                        <td style="padding-top: 30px">
                            <img src="{{public_path('/imgs/logo.jpg')}}" style="max-width:220px;max-height:200px;">
                            <p style="font-size: 12px; padding-top: 10px;"></p>
                        </td>
                        <td class="center" style="padding-top: 20px;">
                            <h3>{{$emitente->nome_fantasia}}</h3>
                            <p class="subtitle_heading">{{$emitente->razao_social}}</p>
                            <p class="subtitle_heading">CNPJ:{{$emitente->cnpj}}</p>
                            <p class="subtitle_heading">{{$emitente->full_address}} - {{$emitente->city_state}}</p>
                            <p class="subtitle_heading">CEP: {{$emitente->cep}}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="text-center">
                <h3>@yield('report_name')</h3>
            </div>
            <div class="text-center">
                <p>@yield('report_name_subtitle')</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>
