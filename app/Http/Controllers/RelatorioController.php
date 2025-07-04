<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Inscricao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RelatorioController extends Controller
{
    public function cursosDoAluno($aluno_id): View
    {
        $aluno = Aluno::find($aluno_id);
        $dados = Inscricao::where('aluno_id', '=', $aluno_id)->get();
        return view('relatorio.relatorio-cursosdoaluno', [
            'aluno' => $aluno,
            'dados' => $dados,
        ]);
    }
    public function alunosDoCurso($curso_id): View
    {
        $curso = Curso::find($curso_id);
        $dados = Inscricao::where('curso_id', '=', $curso_id)->get();

        return view('relatorio.relatorio-alunosdocurso', [
            'curso' => $curso,
            'dados' => $dados,
        ]);
    }
    public function inscricaoPeriodo($inicio, $termino): View
    {
        $dados = Inscricao::whereRaw("data_inscricao BETWEEN '{$inicio}' and '{$termino}'")->get();
        $inicio = Carbon::parse($inicio);
        $termino = Carbon::parse($termino);

        return view('relatorio.relatorio-inscricoesrealizadasnoperiodo', [
            'inicio' => $inicio->format('d/m/Y'),
            'termino' => $termino->format('d/m/Y'),
            'dados' => $dados,
        ]);
    }
}
