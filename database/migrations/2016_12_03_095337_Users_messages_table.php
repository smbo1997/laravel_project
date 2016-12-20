<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersMessagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users_messages', function (Blueprint $table) {
            $table->increments('chat_id');
            $table->integer('from_user');
            $table->integer('to_user');
            $table->string('content');
            $table->string('images')->nullable();
            $table->integer('delivered');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users_messages');
    }

}
