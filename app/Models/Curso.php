<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $fillable = ['nome'];
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'curso_id', 'id');
    }
    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'inscricoes', 'curso_id', 'aluno_id');
    }
}
