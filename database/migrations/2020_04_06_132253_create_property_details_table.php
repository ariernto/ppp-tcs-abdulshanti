<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_id')->nullable();
            $table->string('office_id')->nullable();
            
            $table->string('agent_id_1')->nullable();
            $table->string('agent_id_2')->nullable();
            $table->string('type')->nullable();
            $table->string('property_type')->nullable();
            $table->string('deal_type')->nullable();
            $table->string('rent_type')->nullable();
            $table->string('property_type2')->nullable();
            $table->string('property_type3')->nullable();            
            $table->text('photos')->nullable();
            $table->string('headline')->nullable();
            $table->text('description')->nullable();
            $table->string('authority')->nullable();
            $table->string('current_rent')->nullable();
            $table->string('current_rent_include_tax')->nullable();
            $table->text('address')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
           
            $table->string('display_address')->nullable();
            $table->string('price_text')->nullable();
            $table->string('display_price')->nullable();
            
            $table->string('price_include_tax')->nullable();
            $table->string('rental_yield')->nullable();
            $table->string('capital_growth')->nullable();
            $table->string('zoning')->nullable();
            $table->string('parking')->nullable();
            $table->string('current_leased')->nullable();
            $table->string('tenancy_option')->nullable();
            $table->string('lease_further_option')->nullable();
            $table->string('land_area')->nullable();
            $table->string('land_area_to')->nullable();
            $table->string('land_area_metric')->nullable();
            $table->string('floor_area')->nullable();
            $table->string('floor_area_metric')->nullable();
            $table->string('area_range')->nullable();
            $table->string('area_range_to')->nullable();
            $table->string('land_frontage_metric')->nullable();
            $table->string('land_depth_left_metric')->nullable();
            $table->string('land_depth_right_metric')->nullable();
            $table->string('land_depth_rear_metric')->nullable();
            $table->string('land_crossover')->nullable();
            $table->string('energy_efficiency_rating')->nullable();
            $table->string('all_the_floor')->nullable();
            $table->string('all_the_building')->nullable();
            $table->string('forthcoming_auction')->nullable();
            $table->string('office_area_metric')->nullable();           
            $table->string('warehouse_area_metric')->nullable();           
            $table->string('retail_area_metric')->nullable();
            $table->string('other_area_metric')->nullable();
            $table->string('outgoings_paid_by_tenant')->nullable();
            $table->string('listings_this_address')->nullable();
            $table->string('method_of_sale')->nullable();
            $table->text('features')->nullable();
            
            $table->text('floorplans')->nullable();
            $table->text('brochures')->nullable();
            $table->text('projects')->nullable(); 
            $table->text('custom')->nullable();
            $table->text('exports')->nullable();
           
            $table->text('opentimes')->nullable();
            $table->text('exports_old')->nullable();
            $table->text('translations')->nullable();  
           
            $table->string('status');
            
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
        Schema::dropIfExists('property_details');
    }
}
