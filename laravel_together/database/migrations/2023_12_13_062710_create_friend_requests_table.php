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
    // 친구요청 테이블
    public function up()
    {
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->id(); //pk
            $table->string('from_user_id'); // 친구 요청 보낸 유저 pk
            $table->string('to_user_id'); // 친구 요청 받는 유저 pk
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // 현재 친구 상태 [대기중/ 수락됌/ 거절됌 -> 기본값 : 대기중]
            // $table->foreign('from_user_email')->references('email')->on('users')->onDelete('cascade'); // users 테이블 email 참조하는 외래키로 설정 -> users가 삭제 되었을 경우 cascade 옵션을 통해 같이 삭제 되도록 설정
            // $table->foreign('to_user_email')->references('email')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('friend_requests');
    }
};
