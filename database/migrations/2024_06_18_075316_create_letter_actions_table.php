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
        Schema::create('letter_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('user-act')->comment('User whose Action points associated with a letters.');
            $table->unsignedBigInteger('letter_id')->index('letter-act')->comment('Action points associated with a letters.');
            $table->unsignedBigInteger('letter_priority_id')->index('prior-act')->comment('Action points\' priority associated with a letters.');
            $table->text('action_description')->comment('Action point related to a letter.');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('user_departments');
            $table->foreign('letter_id')->references('id')->on('letters');
            $table->foreign('letter_priority_id')->references('id')->on('letter_priorities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_actions');
    }
};
