<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->id();
            $table->integer('sender');
            $table->integer('receiver');
            // $table->longText('message');
            // $table->enum('type', ['file', 'text']);
            $table->enum('is_read', ['0', '1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
            $table->enum('for_whom', ['admin', 'property', 'ride']);
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
        Schema::dropIfExists('chat');
    }
}
