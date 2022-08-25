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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ชื่อกิจกรรม');
            $table->string('organizer')->comment('ผู้รับผิดชอบกิจกรรม');
            $table->dateTime('date_start')->comment('วันแรกที่จัดกิจกรรม');
            $table->dateTime('date_end')->nullable()->comment('วันสุดท้ายที่จัดกิจกรรม');
            $table->text('detail')->comment('รายละเอียดกิจกรรม');
            $table->string('image')->nullable()->comment('รูปกิจกรรม');
            $table->boolean('is_show')->default(true)->comment('สถานะการแสดงข้อมูล');
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
        Schema::dropIfExists('activities');
    }
};
