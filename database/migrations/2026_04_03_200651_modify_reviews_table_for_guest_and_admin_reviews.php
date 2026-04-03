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
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->nullable()->change()->constrained()->nullOnDelete();
            
            $table->string('customer_name')->nullable()->after('user_id');
            $table->timestamp('review_date')->nullable()->after('replied_at');
            $table->boolean('is_admin_added')->default(false)->after('review_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->nullable(false)->change()->constrained()->cascadeOnDelete();
            
            $table->dropColumn(['customer_name', 'review_date', 'is_admin_added']);
        });
    }
};
