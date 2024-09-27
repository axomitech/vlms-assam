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
        Schema::create('letter_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_id')->index('letter-assign')->comment('Letter assigned to a HOD of a department');
            $table->unsignedBigInteger('user_id')->index('letter-assigne')->comment('HOD or Diarizer of a department from whome letter is assigned.');
            $table->unsignedBigInteger('receiver_id')->index('letter-receiver')->comment('HOD of a department to whome letter is assigned.');
            $table->boolean('in_hand')->comment('Letter in hand after assignment.')->default(true);
            $table->text('remarks')->comment('Remarks on letter assignment.');
            $table->timestamps();
            $table->foreign('letter_id')->references('id')->on('letters');
            $table->foreign('user_id')->references('id')->on('user_departments');
            $table->foreign('receiver_id')->references('id')->on('user_departments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_assigns');
    }
};
