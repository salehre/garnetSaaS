<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 18, 2); // stored in Toman (provider's native unit)
            $table->timestamp('fetched_at'); // provider's TimeRead, not our now()
            $table->timestamps();

            $table->index(['currency_id', 'fetched_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_prices');
    }
};
