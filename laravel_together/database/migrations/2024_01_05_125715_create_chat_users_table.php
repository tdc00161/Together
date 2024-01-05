<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_users', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('chat_room_id'); // 채팅방 pk
            $table->unsignedBigInteger('user_id'); // 참여자 pk
            $table->timestamps(); // 작성일/수정일
            $table->softDeletes(); // 삭제일
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_users');
    }
};
