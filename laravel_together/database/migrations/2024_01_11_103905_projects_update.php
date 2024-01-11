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
        Schema::table('projects', function (Blueprint $table) {
            // // 컬럼 타입 변경 예시
            // $table->string('your_column_name')->change();
            // // 새로운 컬럼 추가 예시
            // $table->integer('new_column')->after('existing_column');
            // 컬럼 삭제
            // $table->dropColumn('your_column_name');
            $table->string('invite',255)->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('invite');
        });
    }
};
