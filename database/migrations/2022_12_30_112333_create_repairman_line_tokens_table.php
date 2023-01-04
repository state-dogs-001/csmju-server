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
        Schema::create('repairman_line_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel_id')->comment('รหัสบุคลากร');
            $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade');
            $table->text('line_token')->comment('Line token ของช่างหรือเจ้าหน้าที่');
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
        Schema::dropIfExists('repairman_line_tokens');
    }
};
