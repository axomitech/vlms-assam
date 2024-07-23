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
        Schema::create('action_sents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('act_dept_id')->index('forward-act')->comment('Forward action from action department to a receiver of a department.');
            $table->unsignedBigInteger('sender_id')->index('forward-send')->comment('Sender of forwarded action.');
            $table->unsignedBigInteger('receiver_id')->index('forward-receive')->comment('Receiver of forwarded action.');
            $table->unsignedBigInteger('letter_id')->index('forward-letter')->comment('Letter for which action is forwarded.');
            $table->boolean('status')->default(0)->comment('reciver\'s disposal action on forwared actions. 0 for not disposed and 1 for disposed.');
            $table->foreign('act_dept_id')->references('id')->on('action_department_maps');
            $table->foreign('sender_id')->references('id')->on('user_departments');
            $table->foreign('receiver_id')->references('id')->on('user_departments');
            $table->foreign('letter_id')->references('id')->on('letters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_sents');
    }
};
