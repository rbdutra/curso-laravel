<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $fillable = ['nome', 'descricao', 'disponivel'];
    protected $casts = [
        'disponivel' => 'boolean', // Assuming 'disponivel' is a boolean field
    ];
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'curso_id', 'id');
    }
    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'inscricao', 'curso_id', 'aluno_id');
    }
}
