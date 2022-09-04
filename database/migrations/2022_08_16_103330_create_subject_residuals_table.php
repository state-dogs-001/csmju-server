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
        Schema::create('subject_residuals', function (Blueprint $table) {
            $table->id();
            $table->string('subject_type')->comment('ประเภทวิชา');
            $table->string('subject_code')->comment('รหัสวิชา');
            $table->string('subject_name')->comment('ชื่อวิชา');
            $table->string('section')->comment('กลุ่มเรียน');
            $table->text('detail')->comment('รายละเอียด');
            $table->unsignedBigInteger('student_id')->comment('ไอดีนักศึกษา');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->unsignedBigInteger('personnel_id')->comment('ไอดีบุคลากรผู้รับผิดชอบ');
            $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade');
            $table->string('status')->default('waiting')->comment('สถานะคำร้องขอ');
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
        Schema::dropIfExists('subject_residuals');
    }
};
