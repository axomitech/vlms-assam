<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assign_deligates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deligate_id')->index('user-dept-deligate')->comment('Deligate assigned to a department.');
            $table->unsignedBigInteger('hod_id')->index('user-dept-hod')->comment('HOD of a department to whome deligate is assigned.');
            $table->timestamps();
            $table->foreign('deligate_id')->references('id')->on('user_departments');
            $table->foreign('hod_id')->references('id')->on('user_departments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_deligates');
    }
};
