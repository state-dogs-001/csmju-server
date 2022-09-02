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
        Schema::table('personnels', function (Blueprint $table) {
            $table->unsignedBigInteger('work_status')->comment('สถานะการทำงาน');
            $table->foreign('work_status')->references('id')->on('personnel_status');
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
        Schema::table('personnels', function (Blueprint $table) {
            $table->dropForeign(['work_status']);
            $table->dropColumn('work_status');
            $table->dropColumn('is_del');
            $table->dropTimestamps();
        });
    }
};
