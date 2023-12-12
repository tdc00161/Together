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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        // 데이터 테이블
        Schema::create('base_data', function (Blueprint $table) {
            $table->id(); // pk
            $table->char('class1',1); // 대분류
            $table->string('class1_name', 20); // 대분류 이름
            $table->char('class2',1); // 소분류
            $table->string('class2_name', 20); // 소분류 이름
        });
        // 프로젝트 테이블
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('user_id'); // 생성자 pk            
            $table->unsignedBigInteger('color_code'); // 색상코드 pk
            $table->string('project_title',16); // 프로젝트명
            $table->string('project_content',44)->nullable(); // 설명
            $table->char('flg',1); // 조직구분
            $table->date('start_date'); // 시작일자
            $table->date('end_date'); // 마감일자
            $table->foreign('user_id')->references('id')->on('users'); // users 테이블과 연결
            $table->foreign('color_code')->references('id')->on('base_data'); // user테이블과 연결
            $table->timestamps(); // 가입일
            $table->softDeletes(); // 탈퇴일
        });
        // 친구요청 테이블
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->id(); //pk
            $table->string('from_user_email'); // 친구 요청 보낸 유저 이메일
            $table->string('to_user_email'); // 친구 요청 받는 유저 이메일
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // 현재 친구 상태 [대기중/ 수락됌/ 거절됌 -> 기본값 : 대기중]
            $table->foreign('from_user_email')->references('email')->on('users')->onDelete('cascade'); // users 테이블 email 참조하는 외래키로 설정 -> users가 삭제 되었을 경우 cascade 옵션을 통해 같이 삭제 되도록 설정
            $table->foreign('to_user_email')->references('email')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        // 친구목록 테이블
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('friend_id');
            $table->timestamps();
            $table->softDeletes();
        });
        // 프로젝트 참여자 테이블
        Schema::create('project_users', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('project_id'); // 프로젝트 pk
            $table->unsignedBigInteger('authority_id'); // 권한 pk
            $table->unsignedBigInteger('member_id'); // 참여자 pk
            $table->foreign('project_id')->references('id')->on('projects'); // projects 테이블과 연결
            $table->foreign('authority_id')->references('id')->on('base_data'); // base_data 테이블과 연결
            $table->foreign('member_id')->references('id')->on('users'); // users 테이블과 연결
            $table->timestamps(); // 참여일자
            $table->softDeletes(); // 탈퇴일자
        });
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
            $table->foreign('project_id')->references('id')->on('projects'); // projects 테이블과 연결
            $table->foreign('responsible_id')->references('id')->on('users'); // users 테이블과 연결
            $table->foreign('writer_id')->references('id')->on('users'); // users 테이블과 연결
            $table->foreign('status_id')->references('id')->on('base_data'); // base_data 테이블과 연결
            $table->foreign('priority_id')->references('id')->on('base_data'); // base_data 테이블과 연결
            $table->foreign('category_id')->references('id')->on('base_data'); // base_data 테이블과 연결
            $table->timestamps(); // 작성, 수정일자
            $table->softDeletes(); // 탈퇴일자
        });
        // 첨부파일 테이블
        Schema::create('attachments', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('task_id'); // 업무/공지 pk
            $table->char('type_flg',1); // 플래그 (파일/이미지/지도)
            $table->string('address', 500); // 주소
            $table->foreign('task_id')->references('id')->on('tasks'); // tasks 테이블과 연결
        });
        // 댓글 테이블
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('task_id'); // 업무 pk
            $table->unsignedBigInteger('user_id'); // 작성자 pk
            $table->string('content',500); // 내용
            $table->foreign('task_id')->references('id')->on('tasks'); // tasks 테이블과 연결
            $table->foreign('user_id')->references('id')->on('users'); // users 테이블과 연결
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
