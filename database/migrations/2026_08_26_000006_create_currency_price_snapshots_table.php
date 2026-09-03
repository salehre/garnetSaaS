<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_price_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete();
            $table->enum('interval_type', ['2h', '6h', '12h', '24h']);
            $table->decimal('price', 18, 2);
            $table->timestamp('snapshotted_at');
            $table->timestamps();

            $table->index(['currency_id', 'interval_type', 'snapshotted_at'], 'cps_currency_interval_time_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_price_snapshots');
    }
};
