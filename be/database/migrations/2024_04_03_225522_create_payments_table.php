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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            //user_id bigint
            $table->unsignedBigInteger('user_id');
            //course_id bigint
            $table->unsignedBigInteger('course_id');
            //invoice
            $table->text('invoice');
            //status
            $table->string('status');
            //payment_url
            $table->string('payment_url');
            //payment at
            $table->string('payment_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
