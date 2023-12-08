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
        Schema::table('rides', function (Blueprint $table) {
            $table->string('source_latitude')->change();
            $table->string('source_longitude')->change();
            $table->string('destination_latitude')->change();
            $table->string('destination_longitude')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->decimal('source_latitude', 18, 15)->change();
            $table->decimal('source_longitude', 18, 15)->change();
            $table->decimal('destination_latitude', 18, 15)->change();
            $table->decimal('destination_longitude', 18, 15)->change();
        });
    }
};
