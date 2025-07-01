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
        Schema::table('cursos', function (Blueprint $table) {
            $table->longText('descricao')->comment('Descrição do curso')->nullable(true);
            $table->integer('disponivel')->default(1)->comment('Curso disponível para inscrição');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn('descricao');
            $table->dropColumn('disponivel');
        });
    }
};
