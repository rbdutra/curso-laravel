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
    public function cursosDoAluno(int $aluno_id): View
    {
        $aluno = Aluno::find($aluno_id);
        if ($aluno) {
            $dados = Inscricao::where('aluno_id', '=', $aluno_id)->get();
            return view('relatorio.relatorio-cursosdoaluno', [
                'aluno' => $aluno,
                'dados' => $dados,
            ]);
        }

        abort(404, 'Aluno não encontrado');
    }
    public function alunosDoCurso(int $curso_id): View
    {
        $curso = Curso::find($curso_id);
        if ($curso) {
            $dados = Inscricao::where('curso_id', '=', $curso_id)->get();

            return view('relatorio.relatorio-alunosdocurso', [
                'curso' => $curso,
                'dados' => $dados,
            ]);
        }

        abort(404, 'Curso não encontrado');
    }
    public function inscricaoPeriodo($inicio, $termino): View
    {
        if ($inicio && $termino) {
            $dados = Inscricao::whereRaw("data_inscricao BETWEEN '{$inicio}' and '{$termino}'")->get();
            $inicio = Carbon::parse($inicio);
            $termino = Carbon::parse($termino);

            return view('relatorio.relatorio-inscricoesrealizadasnoperiodo', [
                'inicio' => $inicio->format('d/m/Y'),
                'termino' => $termino->format('d/m/Y'),
                'dados' => $dados,
            ]);
        }

        abort(404, 'Inscrição não encontrada');
    }
}
