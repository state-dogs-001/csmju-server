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
        Schema::create('activity_docs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id')->comment('ไอดีกิจกรรม');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->string('name')->comment('ชื่อเอกสาร');
            $table->string('docs')->comment('เอกสารรายชื่อผู้เข้าร่วมกิจกรรม');
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
        Schema::dropIfExists('activity_docs');
    }
};
