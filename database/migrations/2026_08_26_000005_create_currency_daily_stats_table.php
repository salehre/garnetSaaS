<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_daily_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('open', 18, 2);   // first price seen that day
            $table->decimal('close', 18, 2);  // most recent price seen that day
            $table->decimal('min', 18, 2);
            $table->decimal('max', 18, 2);
            $table->decimal('avg', 18, 2);    // (min + max) / 2
            $table->timestamps();

            $table->unique(['currency_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_daily_stats');
    }
};
