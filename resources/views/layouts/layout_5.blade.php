<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>CadVisa - Relatório</title>

    <style>

        @page {
            margin: 100px 40px 40px 55px;
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        #header {
            position: fixed;
            text-align: center;
            top: -80px;
            left: 0;
            right: 0;
            height: 60px;
        }

        #titulo1 {
            display: block;
            margin: 0;
            font-size: 13px;
            font-weight: bold;
        }

        #base-legal {
            display: block;
            font-size: 9px;
            margin-top: 3px;
        }


        #footer {
            font-family: Verdana, Geneva, sans-serif;
            position: fixed;
            font-size: 9px;
            border-top: 0.5px solid #000;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 5px;
        }
    </style>

</head>

<body>

    <div id="header">
        <p id="titulo1">RELAÇÃO DE EMPRESAS</p>
    </div>

    <div id="footer">
        Emissão: {{ date('d/m/Y') }} às {{ date('H:i') }} | Usuário: {{ auth()->user()->name }}
    </div>

    @yield('conteudo')

    <script type='text/php'>
        if (isset($pdf))
        {
            $pdf->page_text(490, $pdf->get_height() - 26, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 7, array(0,0,0));
        }
    </script>
</body>

</html>
