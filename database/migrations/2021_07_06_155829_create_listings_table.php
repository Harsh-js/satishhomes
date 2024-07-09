<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->text('property_name');
            $table->text('property_slug')->nullable();
            $table->text('property_description');
            $table->text('property_address');
            $table->text('property_phone');
            $table->text('property_email');
            $table->text('property_website')->nullable();
            $table->text('property_map')->nullable();
            $table->text('property_oh_monday')->nullable();
            $table->text('property_oh_tuesday')->nullable();
            $table->text('property_oh_wednesday')->nullable();
            $table->text('property_oh_thursday')->nullable();
            $table->text('property_oh_friday')->nullable();
            $table->text('property_oh_saturday')->nullable();
            $table->text('property_oh_sunday')->nullable();
            $table->text('property_featured_photo');
            $table->integer('property_category_id');
            $table->integer('property_location_id');
            $table->integer('user_id');
            $table->text('user_type');
            $table->text('seo_title')->nullable();
            $table->text('seo_meta_description')->nullable();
            $table->text('property_status');
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
        Schema::dropIfExists('properties');
    }
}
