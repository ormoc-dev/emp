<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoteCountToUsersVotesTable extends Migration
{
    public function up()
    {
        Schema::table('users_votes', function (Blueprint $table) {
            $table->integer('vote_count')->default(1);
        });
    }

    public function down()
    {
        Schema::table('users_votes', function (Blueprint $table) {
            $table->dropColumn('vote_count');
        });
    }
}