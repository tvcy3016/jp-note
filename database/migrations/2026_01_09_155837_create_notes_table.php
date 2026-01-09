<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            // 目前僅保留 user_id，不做外鍵、不驗證
            $table->string('user_id')->nullable()->comment('Supabase user id / session user id');

            $table->string('title')->comment('筆記標題');
            $table->text('content')->comment('筆記內容');

            // 例如: vocab / grammar / sentence / free
            $table->string('note_type')->nullable()->comment('筆記類型');

            $table->timestamps();

            // 查詢效能（之後會用到）
            $table->index('user_id');
            $table->index('note_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
