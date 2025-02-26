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
        Schema::create('yoyakutypes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('yoyakutype_category')->nullable()->comment('1-> 診察、 2=> trimming');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yoyakutypes');
    }
};
