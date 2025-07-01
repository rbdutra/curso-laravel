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
        Schema::table('inscricao', function (Blueprint $table) {
            $table->foreignId('situacao_id')
                ->constrained('situacao')
                ->restrictOnUpdate()
                ->restrictOnDelete()
                ->default(1) // Assuming 1 is the default situation ID
                ->nullable()
                ->comment('ID do aluno inscrito');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscricao', function (Blueprint $table) {
            $table->dropColumn('situacao_id');
        });
    }
};
