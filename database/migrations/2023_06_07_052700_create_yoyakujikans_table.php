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
        Schema::create('yoyakujikans', function (Blueprint $table) {
            $table->id();
            $table->integer('yoyakubi_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('is_active')->default(1);
            $table->integer('type')->default(1); //delete this after
            $table->integer('yoyakutype_category')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yoyakujikans');
    }
};
