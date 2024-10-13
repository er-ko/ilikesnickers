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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('priority');
            $table->boolean('public')->default(false);
            $table->boolean('default')->default(false);
            $table->string('locale', 2);
            $table->string('locale_3', 3);
            $table->string('name', 64);
            $table->string('localname', 64);
            $table->string('flag', 255);
            $table->string('decimal_point', 1);
            $table->string('thousand_separator', 6);
            $table->string('time_format', 2);
            $table->string('date_format', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
