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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ชื่ออุปกรณ์');
            $table->integer('quantity')->comment('จำนวน');
            $table->string('image')->nullable()->comment('รูปภาพของวัสดุอุปกรณ์');
            $table->boolean('status')->default(true)->comment('สถานะของวัสดุอุปกรณ์');
            $table->boolean('is_del')->default(false)->comment('สถานะการลบข้อมูล');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
};
