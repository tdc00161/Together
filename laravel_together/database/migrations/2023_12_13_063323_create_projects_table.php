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
    // 프로젝트 테이블
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('user_pk'); // 생성자 pk            
            $table->unsignedBigInteger('color_code_pk'); // 색상코드 pk
            $table->string('project_title',16); // 프로젝트명
            $table->string('project_content',44)->nullable(); // 설명
            $table->char('flg',1); // 조직구분
            $table->date('start_date'); // 시작일자
            $table->date('end_date'); // 마감일자
            $table->string('invite',255); // 초대링크
            // $table->foreign('user_id')->references('id')->on('users'); // users 테이블과 연결
            // $table->foreign('color_code')->references('id')->on('base_data'); // user테이블과 연결
            $table->timestamps(); // 가입일
            $table->softDeletes(); // 탈퇴일
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
