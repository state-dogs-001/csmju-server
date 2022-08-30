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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->comment('อีเมลล์');
            $table->string('password')->comment('รหัสผ่าน');
            $table->string('citizen_id')->unique()->comment('เลขบัตรประชาชนของผู้ใช้งาน');
            $table->string('role')->comment('สิทธิ์การใช้งานระบบ');
            $table->timestamp('email_verified_at')->nullable()->comment('สถานะการยืนยันอีเมลล์');
            $table->rememberToken()->comment('เครื่องหมายอ้างอิงการจดจำรหัสผ่าน');
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
        Schema::dropIfExists('users');
    }
};
