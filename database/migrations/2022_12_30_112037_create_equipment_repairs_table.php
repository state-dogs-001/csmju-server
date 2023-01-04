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
        Schema::create('equipment_repairs', function (Blueprint $table) {
            $table->id();
            $table->string('equip_id')->nullable()->comment('รหัสอุปกรณ์');
            $table->string('equip_name')->comment('ชื่ออุปกรณ์');
            $table->string('room')->comment('รหัสห้อง');
            $table->foreign('room')->references('room_id')->on('rooms')->onDelete('cascade');
            $table->text('initial_symptoms')->comment('อาการเบื้องต้น');
            $table->string('image')->nullable()->comment('รูปภาพ');
            $table->string('notifier_name')->comment('ชื่อผู้แจ้ง');
            $table->string('is_repaired')->default('waiting')->comment('สถานะการซ่อม');
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
        Schema::dropIfExists('equipment_repairs');
    }
};
