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
        Schema::create('yoyakuusers', function (Blueprint $table) {
            $table->id();
            $table->integer('yoyakujikan_id')->unsigned();
            $table->integer('yoyakutype_id')->default(1);
            $table->string('your_name')->nullable();
            $table->string('your_kana')->nullable();
            $table->string('your_email')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address_line')->nullable();
            $table->string('tel')->nullable();
            $table->string('pet_name')->nullable();
            $table->string('pet_type')->nullable();
            $table->string('pet_year')->nullable();
            $table->string('pet_gender')->nullable();
            $table->string('pet_message')->nullable();
            $table->string('pet_message2')->nullable();
            $table->string('pet_message3')->nullable();
            $table->string('pet_message4')->nullable();
            $table->string('pet_message5')->nullable();
            $table->string('line_userId')->nullable();
            $table->integer('is_cancel')->default(0);
            $table->string('token_id')->nullable();
            $table->integer('yoyaku_status')->default(1)->nullable()->comment('1 => Active, 0 => Canceled by user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yoyakuusers');
    }
};
