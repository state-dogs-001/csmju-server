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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_code')->unique()->comment('รหัสครุภัณฑ์');
            $table->string('quantity')->nullable()->comment('จำนวนครุภัณฑ์');
            $table->string('name')->nullable()->comment('ชื่อครุภัณฑ์');
            $table->string('brand')->nullable()->comment('ยี่ห้อครุภัณฑ์');
            $table->text('detail')->nullable()->comment('รายละเอียดครุภัณฑ์');
            $table->string('serial_number')->nullable()->comment('หมายเลขครุภัณฑ์');
            $table->double('price')->nullable()->comment('ราคาครุภัณฑ์');
            $table->date('purchase_date')->nullable()->comment('วันที่ซื้อครุภัณฑ์');
            $table->string('purchase_at')->nullable()->comment('ซื้อครุภัณฑ์ที่ไหน');
            $table->string('classroom_code')->nullable()->comment('รหัสห้องเรียนที่ใช้เก็บครุภัณฑ์');
            $table->text('note')->nullable()->comment('หมายเหตุ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
};
