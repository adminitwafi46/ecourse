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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            //course name
            $table->string('name');
            //course description
            $table->text('description');
            //course price
            $table->integer('price');
            //instructor id
            $table->foreignId('instructor_id')->constrained('users');
            $table->string('image');
            $table->string('level');
            $table->string('category');
            //course date
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
