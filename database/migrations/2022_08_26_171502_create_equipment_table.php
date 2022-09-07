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
            $table->string('equip_id')->unique()->comment('รหัสครุภัณฑ์');
            $table->string('serial_number')->nullable()->comment('ซีเรียลนัมเบอร์');
            $table->string('name')->comment('ชื่อครุภัณฑ์');
            $table->string('model')->nullable()->comment('รุ่น/ยี่ห้อ');
            $table->text('detail')->nullable()->comment('รายละเอียด');
            $table->double('price')->comment('ราคา');
            $table->string('quantity')->comment('จำนวน');
            $table->string('main_type')->comment('ประเภทครุภัณฑ์');
            $table->string('sub_type')->nullable()->comment('ประเภทย่อย');
            $table->date('purchase_date')->comment('วันที่ซื้อ');
            $table->string('purchase_from')->nullable()->comment('ซื้อจาก');
            $table->string('budget')->comment('งบประมาณจาก');
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
