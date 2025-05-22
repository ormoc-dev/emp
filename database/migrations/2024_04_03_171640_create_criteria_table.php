<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('round_id')->constrained()->onDelete('cascade');
            $table->string('highest_rate'); 
            $table->string('lowest_rate');
            $table->text('criteria_description');
            $table->timestamps();
        });       
    }
    public function down(): void
    {
        Schema::dropIfExists('criteria');
    }
};
