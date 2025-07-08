<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('commission_rate', 5, 2)->default(20.00); // Ex: 20%
            $table->string('currency', 3)->default('USD');
            $table->decimal('payout_minimum', 10, 2)->default(50.00);
            $table->integer('payout_delay_days')->default(7);
            $table->string('support_email')->nullable();
            $table->string('site_name')->default('Loja Digital');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
}
