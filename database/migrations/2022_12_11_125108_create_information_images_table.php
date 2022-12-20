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
        Schema::create('information_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('information_id');
            $table->foreign('information_id')->references('id')->on('information')->onDelete('cascade');
            $table->string('image')->comment('รูปภาพข่าวสาร');
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
        Schema::dropIfExists('information_images');
    }
};
