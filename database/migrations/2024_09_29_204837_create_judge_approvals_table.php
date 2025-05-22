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
        Schema::create('judge_approvals', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('judge_id');
        $table->unsignedBigInteger('event_id');
        $table->unsignedBigInteger('contestant_id');
        $table->string('approval_type'); // 'minor_awards', 'overall_scores', or 'round_scores'
        $table->unsignedBigInteger('award_id')->nullable(); // For minor awards or round ID
        $table->timestamps();

        $table->foreign('judge_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        $table->foreign('contestant_id')->references('id')->on('contestants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judge_approvals');
    }
};
