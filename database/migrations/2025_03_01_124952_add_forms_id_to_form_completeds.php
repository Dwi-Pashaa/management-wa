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
        Schema::table('form_completeds', function (Blueprint $table) {
            $table->foreignId('forms_id')->references('id')->on('forms')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_completeds', function (Blueprint $table) {
            $table->foreignId('forms_id')->references('id')->on('forms')->onDelete('CASCADE');
        });
    }
};
