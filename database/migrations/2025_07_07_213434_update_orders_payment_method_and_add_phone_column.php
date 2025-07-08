<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersPaymentMethodAndAddPhoneColumn extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Altere de enum para string (mais flexível)
            $table->string('payment_method')->change();

            // Adiciona coluna de telefone, se ainda não existir
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone')->nullable()->after('payment_method');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Reverte a coluna payment_method para enum
            $table->enum('payment_method', ['paypal', 'stripe'])->default('paypal')->change();

            // Remove o número de telefone
            $table->dropColumn('phone');
        });
    }
}
