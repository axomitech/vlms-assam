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
        Schema::create('recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_id')->index('letter-recipient');
            $table->string('recipient_name')->comment('Name of the recipient of the letter.');
            $table->string('recipient_designation')->comment('Designation of the recipient of the letter.');
            $table->string('recipient_phone',10)->comment('Phone no. of the recipient of the letter.');
            $table->string('recipient_email')->comment('Email id of the recipient of the letter.');
            $table->string('sms_to',10)->nullable()->comment('Phone no. of the recipient of the letter.');
            $table->string('email_to')->nullable()->comment('Email id of the recipient of the letter.');
            $table->string('organization')->comment('Organizatipon id of the recipient of the letter.');
            $table->text('address')->comment('Address id of the recipient of the letter.');
            $table->timestamps();
            $table->foreign('letter_id')->references('id')->on('letters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipients');
    }
};
