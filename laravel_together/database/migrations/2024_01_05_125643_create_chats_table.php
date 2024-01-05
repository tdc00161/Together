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
        Schema::create('chats', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('chat_room_id'); // 채팅방 pk
            $table->unsignedBigInteger('sender_id'); // 보낸사람 pk
            $table->string('content',500); // 채팅내용 500자
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
        Schema::dropIfExists('chats');
    }
};
