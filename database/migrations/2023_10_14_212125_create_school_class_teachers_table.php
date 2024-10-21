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
        Schema::create('school_class_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_class_id')->unique();
            $table->unsignedBigInteger('teacher_id');            
            $table->timestamps();

            $table->unique(['school_class_id', 'teacher_id']);

            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('school_class_id')->references('id')->on('school_classes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_class_teacher');
    }
};
