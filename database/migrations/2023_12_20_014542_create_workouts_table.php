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
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();

        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
        $table->integer('repetitions');
        $table->decimal('weight');
        $table->integer('break_time');
        $table->enum('day', ['SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÁBADO', 'DOMINGO']);
        $table->text('observations')->nullable();
        $table->integer('time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};