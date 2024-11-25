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
        Schema::create('welcomes_locales', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 3);
            $table->string('title', 255)->nullable();
            $table->text('content', 255)->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
        });

        Schema::create('welcomes_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 3);
            $table->string('file', 255);
            $table->unsignedSmallInteger('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcomes_locales');
        Schema::dropIfExists('welcomes_sliders');
    }
};
