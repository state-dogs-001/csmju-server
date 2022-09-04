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
        Schema::create('cv_personnels', function (Blueprint $table) {
            $table->id();
            $table->string('citizen_id', 13)->unique()->comment('เลขประจำตัวประชาชน');
            $table->foreign('citizen_id')->references('citizen_id')->on('personnels')->onDelete('cascade');
            $table->text('bachelor_degree')->comment('ปริญญาตรี');
            $table->text('masters_degree')->nullable()->comment('ปริญญาโท');
            $table->text('doctoral_degree')->nullable()->comment('ปริญญาเอก');
            $table->text('bio')->nullable()->comment('ประวัติโดยย่อ');
            $table->text('experience')->nullable()->comment('ประสบการณ์การทำงาน');
            $table->text('expertise')->nullable()->comment('ความเชี่ยวชาญ');
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
        Schema::dropIfExists('cv_personnels');
    }
};
