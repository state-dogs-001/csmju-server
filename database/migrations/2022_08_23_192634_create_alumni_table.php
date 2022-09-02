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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ชื่อ-นามสกุล');
            $table->string('generation')->comment('รุ่น');
            $table->text('work_place')->comment('สถานที่ทำงาน');
            $table->string('job_title')->comment('ตำแหน่งงาน');
            $table->text('caption')->nullable()->comment('แคปชั่น');
            $table->string('image_profile')->nullable()->comment('รูปภาพ');
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
        Schema::dropIfExists('alumni');
    }
};
