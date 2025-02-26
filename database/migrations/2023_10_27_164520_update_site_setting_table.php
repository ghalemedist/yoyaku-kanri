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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('liffId_waiting')->nullable();
            $table->date('yoyaku_date')->nullable();
            $table->string('yoyaku_title')->nullable();
            $table->text('yoyaku_content')->nullable();
            $table->string('yoyaku_title_premium')->nullable();
            $table->text('yoyaku_content_premium')->nullable();
            $table->text('yoyaku_content_email')->nullable();
            $table->text('yoyaku_content_line')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('liffId_waiting');
            $table->dropColumn('yoyaku_date');
            $table->dropColumn('yoyaku_title');
            $table->dropColumn('yoyaku_content');
            $table->dropColumn('yoyaku_title_premium');
            $table->dropColumn('yoyaku_content_premium');
            $table->dropColumn('yoyaku_content_email');
            $table->dropColumn('yoyaku_content_line');
        });
    }
};
