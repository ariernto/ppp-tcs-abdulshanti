<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('uid')->nullable();
            $table->integer('assign_id')->nullable(); 
            $table->integer('property_id');
            $table->enum('mantinance_type', ['new', 'in_process','resolved']);
            $table->string('title')->nullable();            
            $table->text('description')->nullable();
            $table->string('days')->nullable();
            $table->string('filepath')->nullable();
            $table->enum('status', ['active', 'cancel','archive','mute','deleted']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
