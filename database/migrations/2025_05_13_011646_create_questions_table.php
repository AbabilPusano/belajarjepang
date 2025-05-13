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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['fill_blank', 'meaning_choice', 'jp_choice']); // tipe latihan
            $table->text('question'); // bisa jadi kalimat jepang atau indonesia tergantung tipe
            $table->json('options'); // array of pilihan ganda
            $table->string('correct_answer'); // jawaban yang benar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
