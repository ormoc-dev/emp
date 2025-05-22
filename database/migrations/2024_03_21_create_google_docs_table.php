<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('google_docs', function (Blueprint $table) {
            $table->id();
            $table->string('document_name');
            $table->text('google_docs_link');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('google_docs');
    }
};
