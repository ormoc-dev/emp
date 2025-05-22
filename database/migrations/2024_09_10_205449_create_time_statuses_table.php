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
        Schema::create('time_statuses', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');  // Foreign key to events
            $table->time('start_time')->nullable();  // Start time
            $table->time('end_time')->nullable();    // End time
            $table->timestamps();  // For created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_statuses');
    }
};
