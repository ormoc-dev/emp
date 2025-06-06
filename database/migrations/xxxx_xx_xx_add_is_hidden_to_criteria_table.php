<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false);
        });
    }

    public function down()
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });
    }
};
