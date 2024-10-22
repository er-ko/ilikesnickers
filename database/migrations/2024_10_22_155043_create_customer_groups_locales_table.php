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
        Schema::create('customer_groups_locales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('customer_groups');
            $table->string('locale', 3);
            $table->string('title', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_groups_locales');
    }
};
