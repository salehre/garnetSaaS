<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('currency_price_snapshots', function (Blueprint $table) {
            $table->dropColumn('price');

            $table->decimal('entry_price', 18, 2)->after('interval_type');
            $table->decimal('exit_price', 18, 2)->after('entry_price');
            $table->decimal('min_price', 18, 2)->after('exit_price');
            $table->decimal('max_price', 18, 2)->after('min_price');
            $table->decimal('avg_price', 18, 2)->after('max_price');
        });
    }

    public function down(): void
    {
        Schema::table('currency_price_snapshots', function (Blueprint $table) {
            $table->dropColumn(['entry_price', 'exit_price', 'min_price', 'max_price', 'avg_price']);
            $table->decimal('price', 18, 2)->after('interval_type');
        });
    }
};