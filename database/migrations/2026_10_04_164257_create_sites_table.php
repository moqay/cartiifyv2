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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('name', 60);
            $table->string('subdomain', 30)->unique();
            $table->string('template', 20);
            $table->string('currency', 3)->default('EGP');
            $table->string('color', 7);
            $table->string('headline');
            $table->json('hidden');
            $table->json('gateways');
            $table->json('shipping');
            $table->json('plugins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
