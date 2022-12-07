<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surename')->nullable();
            $table->string('email')->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password');
            // $table->string('phone')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('image')->default('user_default.png')->nullable();
            $table->string('remember_token')->nullable();
            $table->enum('status', ['0', '1'])->default('0')->comment('0 = not active, 1 = active');
            $table->enum('email_activate', ['0', '1'])->default('0')->comment('0 = not active, 1 = active');
            $table->string('change_email')->nullable();
            $table->string('active_email_token')->nullable();
            // $table->string('change_phone')->nullable();
            $table->string('change_phone_code')->nullable();
            $table->string('change_phone_number')->nullable();
            $table->string('token')->nullable();
            $table->string('provider_google_id')->nullable();
            $table->string('provider_facebook_id')->nullable();
            $table->string('provider_twitter_id')->nullable();
            $table->float('wallet')->nullable();
            $table->enum('user_type', ['1', '2'])->default('1')->comment('1 = user, 2 = ride');
            $table->enum('ride_verified', ['0', '1'])->default('0')->comment('0 = No, 1 = Yes');
            $table->enum('phone_verified', ['0', '1'])->default('0')->comment('0 = No, 1 = Yes');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
