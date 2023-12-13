<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   
        // 친구요청 테이블
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->id(); //pk
            $table->string('from_user_email'); // 친구 요청 보낸 유저 이메일
            $table->string('to_user_email'); // 친구 요청 받는 유저 이메일
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // 현재 친구 상태 [대기중/ 수락됌/ 거절됌 -> 기본값 : 대기중]
            // $table->foreign('from_user_email')->references('email')->on('users')->onDelete('cascade'); // users 테이블 email 참조하는 외래키로 설정 -> users가 삭제 되었을 경우 cascade 옵션을 통해 같이 삭제 되도록 설정
            // $table->foreign('to_user_email')->references('email')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        // 친구목록 테이블
        Schema::create('friendlists', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('friend_id');
            $table->timestamps();
            $table->softDeletes();
        });
        // 프로젝트 참여자 테이블
        Schema::create('project_users', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('project_pk'); // 프로젝트 pk
            $table->unsignedBigInteger('authority_pk'); // 권한 pk
            $table->unsignedBigInteger('member_pk'); // 참여자 pk
            // $table->foreign('project_id')->references('id')->on('projects'); // projects 테이블과 연결
            // $table->foreign('authority_id')->references('id')->on('base_data'); // base_data 테이블과 연결
            // $table->foreign('member_id')->references('id')->on('users'); // users 테이블과 연결
            $table->timestamps(); // 참여일자
            $table->softDeletes(); // 탈퇴일자
        });
        // 업무/공지 테이블
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_pk'); // 프로젝트 pk
            $table->unsignedBigInteger('task_responsible_user_pk')->nullable(); // 담당자 pk
            $table->unsignedBigInteger('task_writer_user_pk'); // 작성자 pk
            $table->unsignedBigInteger('task_status_pk')->default(1); // 업무상태 pk(데이터테이블 id)
            $table->unsignedBigInteger('priority_pk')->nullable(); // 우선순위 pk
            $table->unsignedBigInteger('category_pk'); // 카테고리 pk
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
        // 첨부파일 테이블
        Schema::create('attachments', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('task_pk'); // 업무/공지 pk
            $table->char('type_flg',1); // 플래그 (파일/이미지/지도)
            $table->string('address', 500); // 주소
            // $table->foreign('task_id')->references('id')->on('tasks'); // tasks 테이블과 연결
        });
        // 댓글 테이블
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('task_pk'); // 업무 pk
            $table->unsignedB
            igInteger('user_pk'); // 작성자 pk
            $table->string('content',500); // 내용
            // $table->foreign('task_id')->references('id')->on('tasks'); // tasks 테이블과 연결
            // $table->foreign('user_id')->references('id')->on('users'); // users 테이블과 연결
            $table->timestamps(); // 작성/수정일
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
        Schema::dropIfExists('comments');
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('project_users');
        Schema::dropIfExists('friends');
        Schema::dropIfExists('friend_requests');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('base_data');
        Schema::dropIfExists('users');
    }
};
