<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_admin')->default('0');
            $table->boolean('is_user')->default('0');
            $table->boolean('is_ride')->default('0');
            $table->boolean('is_hotel')->default('0');
            $table->boolean('is_furnished')->default('0');
            $table->boolean('is_shared')->default('0');
            $table->boolean('is_restaurant')->default('0');
            $table->boolean('is_wedding')->default('0');
            $table->boolean('is_travel')->default('0');
            $table->boolean('is_business')->default('0');
            $table->boolean('is_car')->default('0');
            $table->boolean('is_residential')->default('0');
            $table->boolean('is_attributes')->default('0');
            $table->boolean('is_book_list')->default('0');
            $table->boolean('is_through')->default('0');
            $table->boolean('is_include')->default('0');
            $table->boolean('is_residential_type')->default('0');
            $table->boolean('is_country')->default('0');
            $table->boolean('is_city')->default('0');
            $table->boolean('is_reason')->default('0');
            $table->boolean('is_coupon')->default('0');
            $table->boolean('is_property')->default('0');
            $table->boolean('is_reservation')->default('0');
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
        Schema::dropIfExists('permissions');
    }
}
