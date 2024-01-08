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
            $table->bigInteger('from_user_id'); // 요청 보낸 유저 pk
            $table->bigInteger('to_user_id'); // 요청 받는 유저 pk
            $table->string('invite_token')->unique();//초대시 생성토큰
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
