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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('company_name', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('opening_hours', 255)->nullable();
            $table->string('phone', 13)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('web', 255)->nullable();
            $table->string('map', 255)->nullable();
            $table->string('whatsapp', 13)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('tiktok', 255)->nullable();
            $table->string('google', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
