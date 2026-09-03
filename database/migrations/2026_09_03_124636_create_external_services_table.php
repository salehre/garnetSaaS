<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('external_services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // e.g. "shahkar-lite", used in the API call param
            $table->string('label'); // Persian display name
            $table->decimal('price', 18, 2); // cost per call, charged to the customer's wallet, in Toman
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_services');
    }
};