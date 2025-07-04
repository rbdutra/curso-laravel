@extends('relatorio.report')

@section('content')
<div>
    @if ($dados)
    <h2>Curso: {{ $curso->nome }}</h2>

    <ul>
        @foreach ($dados as $row)
        <li>{{ $row->aluno->nome }}</li>
        @endforeach
    </ul>
    @else
    <h3>Nenhum registro encontrado</h3>
    @endif
</div>
@endsection
