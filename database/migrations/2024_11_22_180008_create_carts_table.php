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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session', 255)->unique();
            $table->string('currency', 3);
            $table->float('price_without_vat', 52);
            $table->float('price_with_vat', 52);
            $table->unsignedTinyInteger('delivery_id')->nullable();
            $table->unsignedTinyInteger('payment_id')->nullable();
            $table->string('promo_code', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('carts_items', function (Blueprint $table) {
            $table->id();
            $table->string('session', 255)->unique();
            $table->string('code', 6);
            $table->string('title', 255);
            $table->unsignedInteger('count');
            $table->unsignedTinyInteger('vat');
            $table->float('price_without_vat', 52);
            $table->float('price_with_vat', 52);

        });

        Schema::create('carts_comments', function (Blueprint $table) {
            $table->id();
            $table->string('session', 255)->unique();
            $table->string('comment', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
        Schema::dropIfExists('carts_items');
        Schema::dropIfExists('carts_comments');
    }
};
