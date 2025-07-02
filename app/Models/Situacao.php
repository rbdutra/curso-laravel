<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Situacao extends Model
{
    protected $table = 'situacao';
    protected $fillable = ['descricao', 'cor'];

    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'situacao_id', 'id');
    }
}
