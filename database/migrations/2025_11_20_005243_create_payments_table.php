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
            $table->foreignId('parking_id')->nullable()->constrained()->onDelete('cascade'); 
            $table->foreignId('member_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade'); 
            
            $table->integer('amount');      // total pembayaran
            $table->integer('cash');        // uang tunai
            $table->integer('change');      // kembalian

            $table->enum('type', ['member', 'non_member']);      
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
