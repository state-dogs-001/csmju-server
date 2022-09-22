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
            $table->text('workplace')->nullable()->comment('สถานที่ทำงาน');
            $table->text('bio')->nullable()->comment('ประวัติโดยย่อ');
            $table->json('skills')->nullable()->comment('ทักษะ');
            $table->json('experts')->nullable()->comment('ความเชี่ยวชาญ');
            $table->json('experiences')->nullable()->comment('ประสบการณ์การทำงาน');
            $table->json('researches')->nullable()->comment('ผลงาน / งานวิจัย');
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
