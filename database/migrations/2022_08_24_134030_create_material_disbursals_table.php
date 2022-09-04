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
        Schema::create('material_disbursals', function (Blueprint $table) {
            $table->id();
            $table->string('citizen_id')->comment('รหัสบัตรประชาชนของผู้เบิกจ่ายวัสดุ');
            $table->foreign('citizen_id')->references('citizen_id')->on('personnels')->onDelete('cascade');
            $table->unsignedBigInteger('material_id')->comment('ไอดีของวัสดุอุปกรณ์');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->integer('quantity')->comment('จำนวนที่ของเบิกจ่าย');
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
        Schema::dropIfExists('material_disbursals');
    }
};
