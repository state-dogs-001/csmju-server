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
        Schema::create('project_libraries', function (Blueprint $table) {
            $table->id();
            $table->string('project_code')->unique()->comment('รหัสโครงงาน');
            $table->string('name')->comment('ชื่อโครงงาน');
            $table->string('years')->comment('ปีการศึกษา');
            $table->string('file')->comment('ไฟล์เอกสารการทำโครงงาน');
            $table->text('detail')->comment('รายละเอียดของโครงงาน');
            $table->unsignedBigInteger('chairman')->comment('ไอดีบุคลากรผู้เป็นประธานกรรมการโครงงาน');
            $table->foreign('chairman')->references('id')->on('personnels')->onDelete('cascade');
            $table->unsignedBigInteger('director_1')->nullable()->comment('ไอดีบุคลากรผู้เป็นกรรมการโครงงานคนที่ 1');
            $table->foreign('director_1')->references('id')->on('personnels')->onDelete('cascade');
            $table->unsignedBigInteger('director_2')->nullable()->comment('ไอดีบุคลากรผู้เป็นกรรมการโครงงานคนที่ 2');
            $table->foreign('director_2')->references('id')->on('personnels')->onDelete('cascade');
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
        Schema::dropIfExists('project_libraries');
    }
};
