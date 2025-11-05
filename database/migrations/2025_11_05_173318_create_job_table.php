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
        Schema::create('job', function (Blueprint $table) {
            $table->id();
            $table->string('start_address');
            $table->string('destination_address');
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->enum('status', ['Assigned', 'InProgress', 'Successful', 'Failed']);
            $table->string('driver_email');

            $table->foreign('driver_email')
                  ->references('email')
                  ->on('user')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job');
    }
};
