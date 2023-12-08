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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->decimal('source_latitude', 18, 15);
            $table->decimal('source_longitude', 18, 15);
            $table->decimal('destination_latitude', 18, 15);
            $table->decimal('destination_longitude', 18, 15);
            $table->unsignedBigInteger('distance')->default(0);
            $table->time('requested_time');
            $table->enum('status', ['pending', 'ongoing', 'picked', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
