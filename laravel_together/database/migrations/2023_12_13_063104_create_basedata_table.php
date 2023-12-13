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
        Schema::create('basedata', function (Blueprint $table) {
            $table->id(); // pk
            $table->char('data_title_code',1); // 대분류
            $table->string('data_title_name', 20); // 대분류 이름
            $table->char('data_content_code',1); // 소분류
            $table->string('data_content_name', 20); // 소분류 이름
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basedata');
    }
};
