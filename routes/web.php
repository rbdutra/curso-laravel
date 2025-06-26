<?php

use App\Http\Controllers\AlunoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


$alunos = [
    ['id' => 1, 'nome' => 'João'],
    ['id' => 2, 'nome' => 'Maria'],
    ['id' => 3, 'nome' => 'Pedro'],
];
// Route::get('/alunos', function (Request $request) use ($alunos) {
//     return view('alunos', [
//         'alunos' => $alunos,
//     ]);
// });

Route::get('/alunos', [AlunoController::class, 'index']);

Route::get('/aluno/{id}', function (int $id) use ($alunos) {
    if(isset($alunos[$id-1]) === false) {
        abort(404, 'Aluno não encontrado');
    }
    $aluno = $alunos[$id-1];
    return view('alunos', [
        'aluno' => $aluno,
        'alunos' => $alunos,
    ]);
});





Route::get('/index/{nome?}', function (?string $nome=null) {
    return view('welcome', [
        'title' => 'Welcome to My Website',
        'description' => 'This is a sample Laravel application.',
        'nome' => $nome,
    ]);
})->name('site.index');
