<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AlunoController extends Controller
{
    public function index(): View
    {
        $alunos = [
            ['id' => 1, 'nome' => 'João'],
            ['id' => 2, 'nome' => 'Maria'],
            ['id' => 3, 'nome' => 'Pedro'],
        ];
        return view('alunos', [
            'alunos' => $alunos,
        ]);
    }
}
