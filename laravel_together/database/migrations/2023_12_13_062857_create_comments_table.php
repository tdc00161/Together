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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('task_id'); // 업무 pk
            $table->unsignedBigInteger('user_id'); // 작성자 pk
            $table->string('content',500); // 내용
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
    }
};
