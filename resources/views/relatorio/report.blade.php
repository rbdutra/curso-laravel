<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Relatório</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite('resources/css/app.css')
    </head>
    <body class="flex items-center lg:justify-center flex-col">
        <div class="border-slate-200 rounded-lg my-1 border-2 w-96 p-2">Cabeçalho do Sistema</div>
        <div class="p-2 border-slate-200 rounded-lg my-1 border-2 w-96">
            @yield('content')
        </div>
        <div class="border-slate-200 rounded-lg my-1 border-2 w-96 p-2">Rodapé</div>
    </body>
</html>
