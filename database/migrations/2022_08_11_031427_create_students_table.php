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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('citizen_id', 13)->unique()->comment('เลขประจำตัวประชาชน');
            $table->string('student_code', 10)->unique()->comment('รหัสนักศึกษา');
            $table->string('name_th')->comment('ชื่อไทย');
            $table->string('name_en')->comment('ชื่ออังกฤษ');
            $table->string('image_profile')->nullable()->comment('รูปโปรไฟล์');
            $table->string('email')->comment('อีเมลล์ติดต่อ');
            $table->string('tel_number')->comment('เบอร์โทรศัพท์');
            $table->string('province')->comment('จังหวัด');
            $table->string('district')->comment('อำเภอ');
            $table->string('sub_district')->comment('ตำบล');
            $table->string('postcode')->comment('รหัสไปรษณีย์');
            $table->string('address')->comment('ที่อยู่');
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
        Schema::dropIfExists('students');
    }
};
