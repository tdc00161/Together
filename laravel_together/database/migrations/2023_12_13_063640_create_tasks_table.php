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
        // 업무/공지 테이블
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id'); // 프로젝트 pk
            $table->unsignedBigInteger('task_responsible_id')->nullable(); // 담당자 pk
            $table->unsignedBigInteger('task_writer_id'); // 작성자 pk
            $table->unsignedBigInteger('task_status_id')->default(1); // 업무상태 pk(데이터테이블 id)
            $table->unsignedBigInteger('priority_id')->nullable(); // 우선순위 pk
            $table->unsignedBigInteger('category_id'); // 카테고리 pk
            $table->unsignedBigInteger('task_number'); // 업무번호
            $table->unsignedBigInteger('task_parent')->nullable(); // 상위업무
            $table->char('task_depth',1)->default(0); // 업무깊이
            $table->string('title',50); // 제목
            $table->string('content',500)->nullable(); // 내용
            // $table->foreign('project_id')->references('id')->on('projects'); // projects 테이블과 연결
            // $table->foreign('responsible_id')->references('id')->on('users'); // users 테이블과 연결
            // $table->foreign('writer_id')->references('id')->on('users'); // users 테이블과 연결
            // $table->foreign('status_id')->references('id')->on('base_data'); // base_data 테이블과 연결
            // $table->foreign('priority_id')->references('id')->on('base_data'); // base_data 테이블과 연결
            // $table->foreign('category_id')->references('id')->on('base_data'); // base_data 테이블과 연결
            $table->timestamps(); // 작성, 수정일자
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
        Schema::dropIfExists('tasks');
    }
};
