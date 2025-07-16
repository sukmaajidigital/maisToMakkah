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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('rank_id')->nullable()->constrained('ranks');
            $table->decimal('bonus_balance', 15, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['rank_id']);

            // Then drop the columns
            $table->dropColumn(['parent_id', 'rank_id', 'bonus_balance']);
        });
    }
};
