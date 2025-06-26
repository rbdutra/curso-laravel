@extends('layout')

@section('title', 'Cursos')
@section('content')
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
@endsection
