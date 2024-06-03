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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('address');
            $table->string('city');
            $table->integer('zip');
            $table->string('phone');
            $table->string('full_name');
            $table->decimal('total_price',10,2);
            $table->string('comment')->nullable();
            $table->enum('status', [1, 2, 3, 4])
                ->comment('1 - pending, 2 - processing, 3 - delivered, 4 - cancelled')
                ->default(1);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
