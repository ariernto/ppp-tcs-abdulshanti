<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('uid')->nullable();
            $table->enum('newlisting', [1, 0]);
            $table->enum('interest', [1, 0]);
            $table->enum('news', [1, 0]);
            $table->enum('event', [1, 0]);  
            $table->enum('maintenance', [1, 0]);  
            $table->enum('message', [1, 0]); 
            $table->enum('update_status', [1, 0]);            
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
        Schema::dropIfExists('notifications');
    }
}
