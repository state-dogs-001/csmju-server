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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('personnel_id')->comment('รหัสบุคลากร');
            $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade');
            $table->string('role')->comment('สิทธิ์การใช้งานระบบ');
            $table->rememberToken()->comment('เครื่องหมายอ้างอิงการจดจำรหัสผ่าน');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['personnel_id']);
            $table->dropColumn('personnel_id');
            $table->dropColumn('role');
            $table->dropColumn('remember_token');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
};
