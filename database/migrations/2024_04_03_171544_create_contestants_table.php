<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateContestantsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('contestants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('number');
            $table->enum('category', ['male', 'female'])->nullable(); 
            $table->string('profile')->nullable(); 
            $table->integer('rankings')->default(0);
            $table->boolean('progress')->default(true); 
            $table->timestamps();
        });
    }
    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contestants');
    }
}
 