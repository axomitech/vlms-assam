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
        Schema::create('senders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_id')->index('letter-send');
            $table->string('sender_name')->comment('Name of a sender of a letter.');
            $table->string('sender_designation')->comment('Designation of a sender of a letter.');
            $table->string('sender_phone',10)->comment('Phone no. of a sender of a letter.');
            $table->string('sender_email')->comment('Email id of a sender of a letter.');
            $table->string('sms_to',10)->nullable()->comment('Phone no. of a sender of a letter.');
            $table->string('email_to')->nullable()->comment('Email id of a sender of a letter.');
            $table->string('organinzation')->comment('Organizatipon id of a sender of a letter.');
            $table->text('address')->comment('Address id of a sender of a letter.');
            $table->timestamps();
            $table->foreign('letter_id')->references('id')->on('letters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senders');
    }
};
