<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('numOfUsers')->default(0);
            $table->integer('numOfProducts')->default(0);
            $table->integer('numOfSizes')->default(0);
            $table->integer('numOfBrands')->default(0);
            $table->integer('numOfColors')->default(0);
            $table->integer('numOfCategories')->default(0);
            $table->integer('numOfOrders')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
