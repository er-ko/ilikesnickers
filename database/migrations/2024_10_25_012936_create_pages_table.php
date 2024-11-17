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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('public')->default(false);
            $table->string('slug', 255);
            $table->timestamps();
        });

        Schema::create('pages_locales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages');
            $table->string('locale', 3);
            $table->string('title', 255);
            $table->string('title_h1', 255);
            $table->text('content', 255)->nullable();
            $table->string('meta_title', 255);
            $table->string('meta_description', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('pages_locales');
    }
};
