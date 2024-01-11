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
        Schema::create('alarms', function (Blueprint $table) {
            $table->id(); // pk
            $table->unsignedBigInteger('listener_id'); // 받는사람 pk
            $table->string('content',1000); // 알림 내용
            $table->timestamp('created_at')->useCurrent(); // 생성일
            $table->softDeletes(); // 확인일
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alarms');
    }
};
