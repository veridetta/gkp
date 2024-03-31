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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            //invoice_id, user_id, description, amount
            $table->foreignId('category_id')->constrained();
            $table->foreignId('residence_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('amount');
            //date
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
