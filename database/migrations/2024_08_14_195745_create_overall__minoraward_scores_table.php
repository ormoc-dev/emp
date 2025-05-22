<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('overall_minor_award_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contestant_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->decimal('overall_score', 8, 2); // Adjust precision as needed
            $table->timestamps();

            $table->unique(['contestant_id', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('overall_minor_award_scores');
    }
};
