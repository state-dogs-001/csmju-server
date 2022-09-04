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
        Schema::table('equipment', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->comment('สถานะของครุภัณฑ์');
            $table->foreign('status_id')->references('id')->on('equipment_status')->onDelete('cascade');
            $table->unsignedBigInteger('personnel_id')->comment('ผู้รับผิดชอบครุภัณฑ์');
            $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade');
            $table->string('room_id')->comment('ห้องที่เก็บครุภัณฑ์');
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
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
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
            $table->dropForeign(['personnel_id']);
            $table->dropColumn('personnel_id');
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
            $table->dropColumn('is_del');
            $table->dropTimestamps();
        });
    }
};
