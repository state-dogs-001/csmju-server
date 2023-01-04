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
        Schema::create('equipment_repair_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repair_id')->comment('รหัสการซ่อม');
            $table->foreign('repair_id')->references('id')->on('equipment_repairs')->onDelete('cascade');
            $table->string('repairman_name')->comment('ชื่อผู้ซ่อม');
            $table->text('log')->comment('บันทึกการซ่อม');
            $table->string('spare_part')->nullable()->comment('อะไหล่ที่ใช้');
            $table->float('price')->nullable()->comment('ราคาต่อหน่วย');
            $table->integer('quantity')->nullable()->comment('จำนวน');
            $table->string('image')->nullable()->comment('รูปภาพ');
            $table->text('note')->comment('หมายเหตุ');
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
        Schema::dropIfExists('equipment_repair_logs');
    }
};
