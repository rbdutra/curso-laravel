<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricao';
    protected $fillable = ['aluno_id', 'curso_id', 'data_inscricao', 'matricula'];
}
