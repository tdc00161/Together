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
            $table->char('flg',1); // 0 => 1대1, 1 => 그룹
            $table->unsignedBigInteger('sender_id'); // 보낸사람 pk
            $table->unsignedBigInteger('receiver_id'); // 받는 사람/그룹 pk
            $table->string('content',500); // 채팅내용 500자
            // $table->timestamps('created_at')->useCurrent(); // 작성일
            // $table->timestamps('updated_at'); // 수정일
            $table->timestamps(); // 수정일
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
