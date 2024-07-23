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
        Schema::create('action_department_maps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_action_id')->index('dept-act')->comment('Action of a letter directed to a department.');
            $table->unsignedBigInteger('department_id')->index('letter-dept')->comment('Department to which action is directed.');
            $table->boolean('action_status')->default(0)->comment('Status of a directed action 0 for pending and 1 for completed.');
            $table->timestamps();
            $table->foreign('letter_action_id')->references('id')->on('letter_actions');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_department_maps');
    }
};
