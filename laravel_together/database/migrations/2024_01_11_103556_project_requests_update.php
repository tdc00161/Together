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
        Schema::table('project_requests', function (Blueprint $table) {
            // // 컬럼 타입 변경 예시
            // $table->string('your_column_name')->change();
            // // 새로운 컬럼 추가 예시
            // $table->integer('new_column')->after('existing_column');
            // 컬럼 삭제
            // $table->dropColumn('your_column_name');
            $table->dropColumn('flg');
            $table->dropColumn('to_user_email');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_requests', function (Blueprint $table) {
            $table->char('flg',1)->after('project_id');
            $table->string('to_user_email',255)->after('to_user_id');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')->after('invite_token');
        });
    }
};
