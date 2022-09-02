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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_code')->unique()->comment('รหัสวิชา');
            $table->string('name_th')->comment('ชื่อวิชาภาษาไทย');
            $table->string('name_en')->comment('ชื่อวิชาภาษาอังกฤษ');
            $table->text('detail')->comment('รายละเอียดวิชา');
            $table->integer('credit')->comment('หน่วยกิต');
            $table->integer('theory_hour')->comment('จำนวนชั่วโมงเรียนทฤษฎีต่อสัปดาห์');
            $table->integer('practical_hour')->comment('จำนวนชั่วโมงเรียนปฏิบัติต่อสัปดาห์');
            $table->integer('self_hour')->comment('จำนวนชั่วโมงศึกษาค้นคว้าด้วยตัวเองต่อสัปดาห์');
            $table->integer('term')->nullable()->comment('ภาคการศึกษา');
            $table->string('is_del')->default(false)->comment('สถานะการลบข้อมูล');
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
        Schema::dropIfExists('subjects');
    }
};
