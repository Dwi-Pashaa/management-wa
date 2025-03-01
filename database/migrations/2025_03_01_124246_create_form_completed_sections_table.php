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
        Schema::create('form_completed_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_completed_id')->references('id')->on('form_completeds')->onDelete('CASCADE');
            $table->foreignId('sections_id')->references('id')->on('sections')->onDelete('CASCADE');
            $table->string('type');
            $table->string('section_text')->nullable();
            $table->string('section_number')->nullable();
            $table->string('section_email')->nullable();
            $table->date('section_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_completed_sections');
    }
};
