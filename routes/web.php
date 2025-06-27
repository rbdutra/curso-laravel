<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CursoController;
use App\Livewire\Counter;

Route::get('/', function () {
    return view('layout');
});

// $alunos = [
//     ['id' => 1, 'nome' => 'João'],
//     ['id' => 2, 'nome' => 'Maria'],
//     ['id' => 3, 'nome' => 'Pedro'],
// ];
// Route::get('/alunos', function (Request $request) use ($alunos) {
//     return view('alunos', [
//         'alunos' => $alunos,
//     ]);
// });

// Route::get('/aluno/{id}', function (int $id) use ($alunos) {
//     if(isset($alunos[$id-1]) === false) {
//         abort(404, 'Aluno não encontrado');
//     }
//     $aluno = $alunos[$id-1];
//     return view('alunos', [
//         'aluno' => $aluno,
//         'alunos' => $alunos,
//     ]);
// });

Route::group(['prefix' => 'aluno'], function () {
    Route::get('/', [AlunoController::class, 'index'])->name('aluno.index');
    Route::get('/{id}', [AlunoController::class, 'show'])->name('aluno.show');
});

Route::group(['prefix' => 'curso'], function () {
    Route::get('/', [CursoController::class, 'index'])->name('curso.index');
    Route::get('/{id}', [CursoController::class, 'show'])->name('curso.show');
});

Route::get('/counter', Counter::class)->name('counter');
