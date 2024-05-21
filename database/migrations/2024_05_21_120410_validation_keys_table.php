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

        Schema::create('validation_keys', function (Blueprint $table) {
            $table->id();
            $table->integer('validationKey');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade'); //foreign key
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};