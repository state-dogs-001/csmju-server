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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('citizen_id', 13)->unique()->comment('รหัสบัตรประชาชน');
            $table->string('name_title')->comment('คำนำหน้าชื่อ');
            $table->string('name_th')->comment('ชื่อไทย');
            $table->string('name_en')->comment('ชื่ออังกฤษ');
            $table->string('image_profile')->nullable()->comment('รูปโปรไฟล์');
            $table->string('email')->comment('ต้องเป็นอีเมลล์ของมหาวิทยาลัยเท่านั้น');
            $table->string('tel_number')->comment('เบอร์โทรศัพท์');
            $table->string('occupation')->comment('อาชีพของบุคคลากร');
            $table->string('position')->comment('ตำแหน่งของบุคลากร');
            $table->string('position_type')->comment('ประเภทของตำแหน่งของบุคลากร');
            $table->string('faculty')->default('คณะวิทยาศาสตร์')->comment('คณะที่สังกัด');
            $table->string('edu_level')->comment('ระดับการศึกษา');
            $table->string('edu_course_name')->comment('ชื่อหลักสูตรที่สำเร็จการศึกษา');
            $table->string('edu_major')->comment('สาขาวิชาที่สำเร็จการศึกษา');
            $table->string('edu_institute')->comment('จบมาจากสถาบันการศึกษา');
            $table->string('work_status')->comment('สถานะการทำงาน');
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
        Schema::dropIfExists('personnels');
    }
};
