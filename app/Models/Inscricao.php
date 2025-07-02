<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricao';
    protected $fillable = ['aluno_id', 'curso_id', 'data_inscricao', 'matricula', 'situacao_id'];
    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id', 'id');
    }
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'id');
    }
    public function situacao()
    {
        return $this->belongsTo(Situacao::class, 'situacao_id', 'id');
    }
}
