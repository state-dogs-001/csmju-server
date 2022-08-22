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
            $table->string('type')->comment('ประเภทโครงงาน');
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
