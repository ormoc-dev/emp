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
        Schema::table('paypal_transactions', function (Blueprint $table) {
            //
            $table->decimal('paypal_fee', 10, 2)->after('amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paypal_transactions', function (Blueprint $table) {
            //
            $table->dropColumn('paypal_fee');
        });
    }
};
