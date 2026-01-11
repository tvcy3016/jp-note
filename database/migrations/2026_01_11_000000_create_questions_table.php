<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->comment('Supabase user id / session user id');
            $table->unsignedBigInteger('note_id');
            $table->string('question_type');
            $table->text('question_text');
            $table->text('answer_text');
            $table->json('choices')->nullable();
            $table->text('explanation')->nullable();
            $table->unsignedTinyInteger('review_level')->default(3);
            $table->timestamps();

            $table->index('user_id');
            $table->index('note_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
