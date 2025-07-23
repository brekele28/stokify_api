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
    Schema::create('stock_transactions', function (Blueprint $table) {
        $table->id();
        $table->enum('type', ['in', 'out']); // transaksi masuk / keluar
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->integer('quantity');
        $table->text('note')->nullable();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // pencatat
        $table->timestamps();
    });
}

};
