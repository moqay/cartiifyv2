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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_demo')->default(false);
        });
        Schema::table('sites', function (Blueprint $table) {
            $table->unsignedInteger('visits')->default(0);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->json('items')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('address')->nullable();
            $table->string('payment', 10)->default('cod');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn('is_demo'));
        Schema::table('sites', fn (Blueprint $t) => $t->dropColumn('visits'));
        Schema::table('orders', fn (Blueprint $t) => $t->dropColumn(['items', 'phone', 'address', 'payment']));
    }
};
