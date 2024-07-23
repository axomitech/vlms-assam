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
        Schema::create('letter_action_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('act_dept_map_id')->index('dept-acts')->comment('Action of a letter directed to a department.');
            $table->unsignedBigInteger('user_id')->index('act-user')->comment('User to response to an action of a letter directed to a department of the user.');
            $table->text('action_remarks')->comment('Remarks of a user on action directed to his or her department.');
            $table->text('response_attach')->comment('Response document supporting remarks of a user on action directed to his or her department.');
            $table->timestamps();
            $table->foreign('act_dept_map_id')->references('id')->on('action_department_maps');
            $table->foreign('user_id')->references('id')->on('user_departments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_action_responses');
    }
};
