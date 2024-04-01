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
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            //course_id
            $table->unsignedBigInteger('course_id');
            //bab_id
            $table->unsignedBigInteger('bab_id');
            //name
            $table->string('name');
            //jenis
            $table->string('jenis');
            //isi
            $table->text('isi');
            //status
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
