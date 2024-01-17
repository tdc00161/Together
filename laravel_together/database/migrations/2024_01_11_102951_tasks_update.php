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
        Schema::table('tasks', function (Blueprint $table) {
            // // 컬럼 타입 변경 예시
            // $table->string('your_column_name')->change();
            // // 새로운 컬럼 추가 예시
            // $table->integer('new_column')->after('existing_column');
            // 컬럼 삭제
            // $table->dropColumn('your_column_name');
            $table->date('start_date')->nullable()->change(); // ->default('CURRENT_TIMESTAMP');
            $table->date('end_date')->nullable()->change(); // ->default('CURRENT_TIMESTAMP');
            $table->string('title',100)->change(); // ->default('CURRENT_TIMESTAMP');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->timestamps('start_date')->nullable()->change(); 
            $table->timestamps('end_date')->nullable()->change();
        });
    }
};
