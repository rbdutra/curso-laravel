<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AlunoController extends Controller
{
    public $alunos = [
        ['id' => 1, 'nome' => 'João'],
        ['id' => 2, 'nome' => 'Maria'],
        ['id' => 3, 'nome' => 'Pedro'],
    ];
    public function index(): View
    {
        return view('alunos', [
            'alunos' => $this->alunos,
        ]);
    }
    public function show(int $id): View
    {
        if(isset($this->alunos[$id-1]) === false) {
            abort(404, 'Aluno não encontrado');
        }
        $aluno = $this->alunos[$id-1];
        return view('alunos', [
            'aluno' => $aluno,
            'alunos' => $this->alunos,
        ]);
    }
}
