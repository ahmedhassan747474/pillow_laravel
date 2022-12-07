<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('owner_id')->index()->nullable();
            $table->double('price')->nullable();
            $table->date('date_of_visit')->nullable();
            $table->tinyInteger('commission_negotiate')->default(0)->comment('0=>no 1=>yes');
            $table->float('commission')->nullable();
            $table->enum('status', ['1', '2', '3', '4'])->default('1')->comment('1 = Pending, 2 = Accept, 3 = Reject, 4 = Cancel');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('offers');
    }
}
