<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {

            /*
             |--------------------------------------------------------------------------
             | 單字（vocabulary）
             |--------------------------------------------------------------------------
             */
            $table->string('reading')->nullable()->after('title');   // 假名
            $table->text('meaning')->nullable()->after('reading');   // 中文意思


            /*
             |--------------------------------------------------------------------------
             | 文法（grammar）
             |--------------------------------------------------------------------------
             */
            $table->text('usage')->nullable()->after('meaning');     // 用法說明
            $table->text('example')->nullable()->after('usage');     // 例句（可多句）


            /*
             |--------------------------------------------------------------------------
             | 錯題（mistake）
             |--------------------------------------------------------------------------
             */
            $table->text('question')->nullable()->after('example');     // 題目
            $table->text('answer')->nullable()->after('question');      // 正解
            $table->text('explanation')->nullable()->after('answer');   // 解釋
            $table->unsignedTinyInteger('difficulty')
                  ->nullable()
                  ->comment('1–5，自覺難度')
                  ->after('explanation');
        });
    }

    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn([
                'reading',
                'meaning',
                'usage',
                'example',
                'question',
                'answer',
                'explanation',
                'difficulty',
            ]);
        });
    }
};
