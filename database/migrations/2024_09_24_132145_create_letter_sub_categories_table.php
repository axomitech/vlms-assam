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
        Schema::create('letter_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_category_id')->index('sub_letter_cat')->comment('Letter category to which sub category belongs to.');
            $table->string('sub_category_name',100)->comment('Name of sub category.');
            $table->boolean('active_status')->comment('Activeness of the sub category.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_sub_categories');
    }
};
