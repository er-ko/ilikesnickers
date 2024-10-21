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
        Schema::create('address_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('customer')->default(false);
            $table->boolean('supplier')->default(false);
            $table->boolean('vat_payer')->default(false);
            $table->unsignedTinyInteger('due_date')->default(7);
            $table->string('preferred_payment_method', 8);
            $table->string('income_bank_account', 64)->nullable();
            $table->string('outcome_bank_account', 64)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_books');
    }
};
