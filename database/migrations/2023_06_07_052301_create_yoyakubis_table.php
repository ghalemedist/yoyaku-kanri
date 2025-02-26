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
        Schema::create('yoyakubis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date')->unique();
            $table->string('description');
            $table->integer('is_active');
            $table->integer('is_display');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yoyakubis');
    }
};
