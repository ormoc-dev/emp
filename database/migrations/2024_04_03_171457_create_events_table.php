<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateEventsTable extends Migration
{
    /**
     * @return void
     */
public function up()
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('event_name');
        $table->string('event_subtitle', 500);
        $table->string('event_status')->default('pending');
        $table->integer('event_rounds');
        $table->integer('event_year');
        $table->date('date_start');
        $table->date('date_end');
        $table->string('event_venue');
        $table->unsignedBigInteger('views_count')->default(0);
        $table->timestamps();
    });


}
    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
