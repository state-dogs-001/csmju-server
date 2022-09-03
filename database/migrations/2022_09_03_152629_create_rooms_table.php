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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_id')->unique()->comment('รหัสห้อง');
            $table->string('room_name_th')->comment('ชื่อห้องภาษาไทย');
            $table->string('room_name_en')->nullable()->comment('ชื่อห้องภาษาอังกฤษ');
            $table->unsignedBigInteger('personnel_id')->comment('ผู้ดูแลห้อง');
            $table->foreign('personnel_id')->references('id')->on('personnels');
            $table->unsignedBigInteger('building_id')->comment('อาคาร');
            $table->foreign('building_id')->references('id')->on('buildings');
            $table->string('floor')->comment('ชั้น');
            $table->integer('amount_seat')->nullable()->comment('จำนวนที่นั่ง');
            $table->string('image')->nullable()->comment('รูปภาพห้อง');
            $table->unsignedBigInteger('type_room_id')->comment('ประเภทห้อง');
            $table->foreign('type_room_id')->references('id')->on('type_rooms');
            $table->boolean('is_del')->default(false)->comment('สถานะการลบ');
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
        Schema::dropIfExists('rooms');
    }
};
