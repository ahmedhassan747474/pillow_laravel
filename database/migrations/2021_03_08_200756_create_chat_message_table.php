<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_message', function (Blueprint $table) {
            $table->id();
            $table->longText('message');
            $table->enum('type', ['file', 'text']);
            $table->enum('is_read', ['0', '1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
            $table->unsignedBigInteger('chat_id')->index();
            $table->foreign('chat_id')->references('id')->on('chat')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('chat_message');
    }
}
