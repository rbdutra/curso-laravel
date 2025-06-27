<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscricao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')
                ->constrained('alunos')
                ->onDelete('cascade')
                ->comment('ID do aluno inscrito');
            $table->foreignId('curso_id')
                ->constrained('cursos')
                ->onDelete('cascade')
                ->comment('ID do curso inscrito');
            $table->integer('matricula')
                ->unique()
                ->comment('Matrícula do aluno no curso');
            $table->date('data_inscricao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricao');
    }
};
