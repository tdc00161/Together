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
        // 프로젝트 참여자 테이블
        Schema::create('project_users', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('project_id'); // 프로젝트 pk
            $table->unsignedBigInteger('authority_id'); // 권한 pk
            $table->unsignedBigInteger('member_id'); // 참여자 pk
            // $table->foreign('project_id')->references('id')->on('projects'); // projects 테이블과 연결
            // $table->foreign('authority_id')->references('id')->on('base_data'); // base_data 테이블과 연결
            // $table->foreign('member_id')->references('id')->on('users'); // users 테이블과 연결
            $table->timestamps('created_at'); // 참여일자
            $table->softDeletes(); // 탈퇴일자
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_users');
    }
};
