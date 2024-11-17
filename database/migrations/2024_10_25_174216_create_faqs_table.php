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

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('priority')->default(false);
            $table->timestamps();
        });

        Schema::create('faqs_locales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_id')->constrained('faqs');
            $table->string('locale', 3);
            $table->string('question', 255);
            $table->string('answer', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('faqs_locales');
    }
};
