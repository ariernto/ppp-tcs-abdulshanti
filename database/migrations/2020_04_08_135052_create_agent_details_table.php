<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('agent_id')->nullable();
            $table->string('office_id')->nullable();            
            $table->string('type')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('username')->nullable();
            $table->text('description')->nullable();
            $table->string('level')->nullable();
            $table->string('position')->nullable();
            $table->string('suburb')->nullable();
            $table->string('role')->nullable();
            $table->string('url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('facebook_username')->nullable();
            $table->string('twitter_username')->nullable();
            $table->string('linkedin_username')->nullable();
            $table->string('instagram_username')->nullable();
            $table->text('groups')->nullable();
            $table->text('testimonials')->nullable(); 
            $table->string('display_on_team_page')->nullable();
            $table->text('photos_landscape')->nullable();
            $table->text('photos_portrait')->nullable();
           
            $table->string('disabled')->nullable();            
           
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
        Schema::dropIfExists('agent_details');
    }
}
