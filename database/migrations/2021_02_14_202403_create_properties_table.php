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
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->unsignedBigInteger('country_id')->index()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('city_id')->index()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('num_of_adult')->nullable();
            $table->integer('num_of_child')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->float('price', 12, 2);
            $table->integer('discount')->nullable();
            $table->enum('discount_type', ['percent', 'price'])->nullable();
            $table->float('size')->nullable();
            $table->string('per')->nullable();
            $table->enum('is_furnished', ['0', '1'])->comment('0 = No, 1 = Yes')->nullable();
            $table->enum('is_hot_deal', ['0', '1'])->comment('0 = No, 1 = Yes')->nullable();
            $table->enum('is_cheapest', ['0', '1'])->comment('0 = No, 1 = Yes')->nullable();
            $table->enum('is_popular', ['0', '1'])->comment('0 = No, 1 = Yes')->nullable();
            $table->dateTime('book_in')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('table_for')->nullable();
            $table->integer('child_chair')->nullable();
            $table->integer('guest_number')->nullable();
            $table->float('hall_size')->nullable();
            $table->unsignedBigInteger('book_list_id')->index()->nullable();
            $table->foreign('book_list_id')->references('id')->on('book_list')->onDelete('set null')->onUpdate('cascade');
            $table->date('traveler_date')->nullable();
            $table->integer('traveler_number')->nullable();
            $table->integer('num_of_employees')->nullable();
            $table->date('business_date')->nullable();
            $table->unsignedBigInteger('include_id')->index()->nullable();
            $table->foreign('include_id')->references('id')->on('includes')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('residential_type_id')->index()->nullable();
            $table->foreign('residential_type_id')->references('id')->on('residential_type')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('through_id')->index()->nullable();
            $table->foreign('through_id')->references('id')->on('throughs')->onDelete('set null')->onUpdate('cascade');
            $table->string('phone_number')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('type', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'])->comment('1 = Apartment, 2 = Villa, 3 = administrative, 4 = Shop , 5 = Chalet, 6 = Land , 7 = Farms, 8 = Factories');
            $table->integer('parent_id')->nullable();
            $table->enum('status',  ['0', '1'])->default('1')->comment('0 = not active, 1 = active');
            $table->timestamps();
            $table->softDeletes();
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
