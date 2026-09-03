<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('currency_price_snapshots', function (Blueprint $table) {
            $table->dropUnique('cps_unique_bucket');
            $table->dropColumn('bucket_index');

            $table->string('bucket_range', 11)->after('bucket_date'); // e.g. "02:00-04:00"

            $table->unique(
                ['currency_id', 'interval_type', 'bucket_date', 'bucket_range'],
                'cps_unique_bucket_range'
            );
        });
    }

    public function down(): void
    {
        Schema::table('currency_price_snapshots', function (Blueprint $table) {
            $table->dropUnique('cps_unique_bucket_range');
            $table->dropColumn('bucket_range');

            $table->unsignedTinyInteger('bucket_index')->after('bucket_date');
            $table->unique(
                ['currency_id', 'interval_type', 'bucket_date', 'bucket_index'],
                'cps_unique_bucket'
            );
        });
    }
};
