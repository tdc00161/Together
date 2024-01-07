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
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id(); // pk
            $table->char('flg',1); // 0 => 1대1, 1 => 그룹
            $table->string('last_chat',60); // 최신채팅내역
            $table->string('chat_room_name',30); // 채팅방 이름
            // $table->timestamps('created_at')->useCurrent(); // 작성일
            // $table->timestamps('updated_at'); // 수정일
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
        Schema::dropIfExists('chat_rooms');
    }
};
