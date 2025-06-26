<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos</title>
</head>
<body>
    <h1>Listagem dos Alunos</h1>
    @if (isset($aluno))
    <h2>Aluno: {{ $aluno['id'] }}: {{ $aluno['nome'] }}</h2>
    @endif

    @if (isset($alunos))
    <ul>
        @foreach ($alunos as $aluno)
            <li>{{ $aluno['id'] }}: {{ $aluno['nome'] }}</li>
        @endforeach
    </ul>
    @endif
</body>
</html>
