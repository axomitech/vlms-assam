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
        Schema::create('letters', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id')->index('letter-user');
            $table->unsignedBigInteger('letter_category_id')->index('letter-cat');
            $table->unsignedBigInteger('letter_priority_id')->index('letter-prio');
            $table->date('letter_date')->comment('Letter date of a letter.');
            $table->date('received_date')->comment('Date of reception of a letter.');
            $table->date('diary_date')->comment('Date of diary entry of a letter.');
            $table->string('letter_no')->unique()->comment('Unique letter number alloted to a letter.');
            $table->text('subject')->comment('Subject of a letter recieved.');
            $table->text('letter_path')->comment('Path of upload of a letter recieved.');
            $table->text('acknowlege_path')->comment('Path of upload of acknowledgement of a letter recieved.')->nullable();
            $table->boolean('acknowlege_status')->comment('Whether ackowlegement generated or not.')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('user_departments');
            $table->foreign('letter_category_id')->references('id')->on('letter_categories');
            $table->foreign('letter_priority_id')->references('id')->on('letter_priorities');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
