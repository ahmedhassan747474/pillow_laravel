<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('flag');
            $table->string('code');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('co_map_image')->nullable();
            $table->string('mobile_pattern')->nullable();
            $table->string('mobile_format')->nullable();
            $table->enum('status',  ['0', '1'])->default('1')->comment('0 = not active, 1 = active');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
