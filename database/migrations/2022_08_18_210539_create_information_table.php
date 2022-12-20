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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('หัวข้อข่าวสาร');
            $table->text('detail')->comment('รายละเอียดข่าวสาร');
            $table->string('poster')->comment('โพสเตอร์ข่าวสาร');
            $table->string('link')->nullable()->comment('ลิงค์ข่าวสาร');
            $table->string('type')->comment('ประเภทข่าวสาร');
            $table->boolean('is_show')->default(true)->comment('สถานะแสดงข่าวสาร');
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
        Schema::dropIfExists('information');
    }
};
