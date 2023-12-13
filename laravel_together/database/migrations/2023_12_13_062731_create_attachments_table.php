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
        // 첨부파일 테이블
        Schema::create('attachments', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('task_id'); // 업무/공지 pk
            $table->char('type_flg',1); // 플래그 (파일/이미지/지도)
            $table->string('address', 500); // 주소
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
};
