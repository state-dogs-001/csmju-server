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
            $table->string('citizen_id', 13)->unique()->nullable()->comment('รหัสบัตรประชาชน');
            $table->string('name_title')->nullable()->comment('คำนำหน้าชื่อ');
            $table->string('name_th')->comment('ชื่อไทย');
            $table->string('name_en')->comment('ชื่ออังกฤษ');
            $table->text('position_academic')->nullable()->comment('ตำแหน่งทางวิชาการ');
            $table->text('position_manager')->nullable()->comment('ตำแหน่งทางบริหาร');
            $table->string('image_profile')->nullable()->comment('รูปโปรไฟล์');
            $table->string('email')->nullable()->comment('อีเมล');
            $table->string('tel_number')->nullable()->comment('เบอร์โทรศัพท์');
            $table->text('education')->nullable()->comment('ประวัติการศึกษา');
            //? อาจารย์ หรือ เจ้าหน้าที่
            $table->string('personnel_type')->comment('ประเภทของบุคลากร');
            //? ข้าราชการ หรือ พนักงานมหาวิทยาลัย
            $table->string('academic_type')->nullable()->comment('ประเภททางมหาวิทยาลัย');
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
