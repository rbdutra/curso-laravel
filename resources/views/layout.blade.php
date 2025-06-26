<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Curso Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold mb-4">Bem-vindo ao Curso Laravel</h1>
            <nav class="mb-4">
                <ul class="flex space-x-4">
                    <li><a href="{{ route('aluno.index') }}" class="text-blue-500 hover:underline">Alunos</a></li>
                    <li><a href="{{ route('curso.index') }}" class="text-blue-500 hover:underline">Cursos</a></li>
                </ul>
            </nav>
        </div>
        <div style="border: 2px solid #ccc;">
            <h1 class="text-2xl font-bold mb-4">@yield('title')</h1>
            @yield('content')
        </div>
    </body>
</html>
