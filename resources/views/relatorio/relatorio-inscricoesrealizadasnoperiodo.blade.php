@extends('relatorio.report')

@section('content')
<div>
    <h2>Período: {{ $inicio }} a {{ $termino }}</h2>

    <table>
        <thead>
            <tr>
                <th>Curso</th>
                <th>Aluno</th>
                <th>Data Matrícula</th>
                <th>Matrícula</th>
            </tr>
        </thead>
        @foreach ($dados as $inscricao)
        <tbody>
            <tr>
                <th>{{ $inscricao->curso->nome }}</th>
                <th>{{ $inscricao->aluno->nome }}</th>
                <th>{{ $inscricao->data_inscricao }}</th>
                <th>{{ $inscricao->matricula }}</th>
            </tr>
        </tbody>
        @endforeach
    </table>
</div>
@endsection
