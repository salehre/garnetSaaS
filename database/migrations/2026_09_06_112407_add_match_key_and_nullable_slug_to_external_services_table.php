<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('external_services', function (Blueprint $table) {
            $table->string('slug')->nullable()->change();
            $table->string('match_key')->nullable()->after('slug');
        });

        Schema::table('external_services', function (Blueprint $table) {
            $table->unique('match_key');
        });
    }

    public function down(): void
    {
        Schema::table('external_services', function (Blueprint $table) {
            $table->dropUnique(['match_key']);
            $table->dropColumn('match_key');
            $table->string('slug')->nullable(false)->change();
        });
    }
};