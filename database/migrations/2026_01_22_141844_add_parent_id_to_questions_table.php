<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // parent_id 允許為 null (原本的題目就沒有 parent)
            // 當父題目被刪除時，變體題目設為 null (不刪除，保留複習紀錄)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('questions')
                  ->nullOnDelete(); 
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};