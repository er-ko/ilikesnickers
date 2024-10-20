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
        Schema::create('address_books_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_book_id')->constrained('address_books');
            $table->string('code', 4);
            $table->string('company_name', 128)->nullable();
            $table->string('company_id', 8)->nullable();
            $table->string('vat_id', 12)->nullable();
            $table->string('first_name', 128);
            $table->string('last_name', 128);
            $table->string('address', 255);
            $table->string('address_ext', 255)->nullable();
            $table->string('postcode', 12);
            $table->string('city', 128);
            $table->string('phonecode', 3);
            $table->string('phone', 9);
            $table->string('email', 128);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_books_branch');
    }
};
