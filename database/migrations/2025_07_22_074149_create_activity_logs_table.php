<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action'); // contoh: "create", "update", "delete"
            $table->string('model_type'); // contoh: "Product", "StockTransaction"
            $table->unsignedBigInteger('model_id'); // ID dari entitas yang dimaksud
            $table->text('description')->nullable(); // Penjelasan aktivitas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
