<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'alunos';
    protected $fillable = ['nome', 'endereco'];
    protected $casts = [
        'endereco' => 'array', // Assuming endereco is stored as a JSON array
    ];
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'aluno_id', 'id');
    }
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'inscricao', 'aluno_id', 'curso_id');
    }
}
