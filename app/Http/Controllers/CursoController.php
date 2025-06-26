<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CursoController extends Controller
{
    public $cursos = [
        ['id' => 1, 'nome' => 'Curso Laravel'],
        ['id' => 2, 'nome' => 'Curso JavaScript'],
        ['id' => 3, 'nome' => 'Curso PHP Avançado'],
        ['id' => 4, 'nome' => 'Curso de Banco de Dados'],
        ['id' => 5, 'nome' => 'Curso de HTML e CSS'],
    ];
    /**
     * Display a listing of the cursos.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('cursos', [
            'cursos' => $this->cursos,
        ]);
    }
    public function show(int $id): View
    {
        if(isset($this->cursos[$id-1]) === false) {
            abort(404, 'Curso não encontrado');
        }
        $curso = $this->cursos[$id-1];
        return view('cursos', [
            'curso' => $curso,
            'cursos' => $this->cursos,
        ]);
    }
}
