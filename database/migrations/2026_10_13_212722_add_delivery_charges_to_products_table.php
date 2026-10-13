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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('inside_dhaka_delivery_charge', 10, 2)->nullable()->after('price');
            $table->decimal('outside_dhaka_delivery_charge', 10, 2)->nullable()->after('inside_dhaka_delivery_charge');
            $table->boolean('is_free_delivery')->default(false)->after('outside_dhaka_delivery_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'inside_dhaka_delivery_charge',
                'outside_dhaka_delivery_charge',
                'is_free_delivery'
            ]);
        });
    }
};
