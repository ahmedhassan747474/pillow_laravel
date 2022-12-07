<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('property_id')->index()->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('ride_id')->index()->nullable();
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('set null')->onUpdate('cascade');
            $table->float('sub_price');
            $table->string('coupon_name')->nullable();
            $table->integer('coupon_dicount')->nullable();
            $table->enum('coupon_type', ['percent', 'price'])->nullable();
            $table->float('final_price');
            $table->unsignedBigInteger('payment_id')->index()->nullable();
            $table->foreign('payment_id')->references('id')->on('payment_method')->onDelete('set null')->onUpdate('cascade');
            $table->string('card_number')->nullable();
            $table->string('card_name')->nullable();
            $table->string('card_cvv')->nullable();
            $table->string('card_expired_date')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['1', '2', '3', '4'])->default('1')->comment('1 = Pending, 2 = Accept, 3 = Reject, 4 = Cancel');
            $table->unsignedBigInteger('reason_id')->index()->nullable();
            $table->foreign('reason_id')->references('id')->on('reasons')->onDelete('set null')->onUpdate('cascade');
            $table->longText('other_reason')->nullable();
            $table->enum('type', ['1', '2', '3', '4', '5', '6', '7', '8', '9'])->comment('1 = Hotel, 2 = Furnished Apartment, 3 = Shared Room, 4 = Restaurant, 5 = Wedding Hall, 6 = Travel Agent Packages, 7 = Business Space, 8 = Car, 9 = Residential');
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
        Schema::dropIfExists('reservations');
    }
}
