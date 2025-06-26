@extends('layout')

@section('title', 'Alunos')

@section('content')

    @if (isset($aluno))
    <h2>Aluno: {{ $aluno['id'] }}: {{ $aluno['nome'] }}</h2>
    @endif

    @if (isset($alunos))
    <ul>
        @foreach ($alunos as $aluno)
        <li>{{ $aluno['id'] }}: <a href="{{ route('aluno.show',$aluno['id']) }}">{{ $aluno['nome'] }}</a></li>
        @endforeach
    </ul>
    @endif
@endsection
