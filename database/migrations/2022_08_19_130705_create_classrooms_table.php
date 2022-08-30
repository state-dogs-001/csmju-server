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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_code')->comment('รหัสห้องเรียน');
            $table->string('name')->comment('ชื่อห้องเรียน');
            $table->string('floor')->comment('ชั้น');
            $table->string('building')->comment('อาคาร');
            $table->string('faculty')->comment('คณะ');
            $table->string('univerity')->comment('มหาวิทยาลัย');
            $table->string('room_type')->comment('ประเภทห้องเรียน');
            $table->integer('reserve_seats')->comment('สำรองที่นั่งได้');
            $table->string('image')->nullable()->comment('รูปภาพ');
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
        Schema::dropIfExists('classrooms');
    }
};
