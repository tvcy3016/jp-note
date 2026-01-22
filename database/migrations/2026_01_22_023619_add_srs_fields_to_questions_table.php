<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // SRS 核心欄位
            $table->float('ease_factor')->default(2.5)->after('review_level'); // 難易度係數 (預設 2.5)
            $table->integer('interval_days')->default(0)->after('ease_factor'); // 目前間隔天數
            $table->integer('repetitions')->default(0)->after('interval_days'); // 連續答對次數
            $table->timestamp('next_review_at')->useCurrent()->after('repetitions'); // 下次複習時間 (預設現在，即立刻可複習)
            
            // 索引 (優化查詢速度)
            $table->index('next_review_at');
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['ease_factor', 'interval_days', 'repetitions', 'next_review_at']);
        });
    }
};