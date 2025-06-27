<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlunoController extends Controller
{
    public function index(): View
    {
        $alunos = Aluno::all();
        return view('alunos', [
            'alunos' => $alunos,
        ]);
    }
    public function show(int $id): View
    {
        $alunos = Aluno::all();
        $aluno = $alunos->find($id);
        return view('alunos', [
            'aluno' => $aluno,
            'alunos' => $alunos,
        ]);
    }
}
