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
        Schema::create('project_requests', function (Blueprint $table) {
            $table->id(); //pk
            $table->unsignedBigInteger('project_id'); // 초대될 프로젝트 pk
            $table->string('from_user_id'); // 요청 보낸 유저 pk
            $table->string('to_user_id'); // 요청 받는 유저 pk
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // 현재 요청 상태 [대기중/ 수락됌/ 거절됌 -> 기본값 : 대기중]
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
        Schema::dropIfExists('project_requests');
    }
};
