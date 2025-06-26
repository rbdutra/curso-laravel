<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
</head>
<body>
    <h1>Listagem dos Cursos</h1>
    @if (isset($curso))
    <h2>Curso: {{ $curso['id'] }}: {{ $curso['nome'] }}</h2>
    @endif

    @if (isset($cursos))
    <ul>
        @foreach ($cursos as $curso)
            <li>{{ $curso['id'] }}: {{ $curso['nome'] }}</li>
        @endforeach
    </ul>
    @endif
</body>
</html>
