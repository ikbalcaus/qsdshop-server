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
        Schema::create('authentication_token', function (Blueprint $table) {
            $table->id();
            $table->string('token_value',512);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade'); //foreign key
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authentication_token');
    }
};
