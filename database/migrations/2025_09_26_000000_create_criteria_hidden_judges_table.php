<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criteria_hidden_judges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criteria_id');
            $table->unsignedBigInteger('judge_id');
            $table->timestamps();

            $table->foreign('criteria_id')->references('id')->on('criteria')->onDelete('cascade');
            $table->foreign('judge_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['criteria_id', 'judge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criteria_hidden_judges');
    }
};
