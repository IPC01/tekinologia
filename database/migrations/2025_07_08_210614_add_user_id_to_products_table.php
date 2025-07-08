<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Adiciona a coluna user_id como chave estrangeira, nullable caso queira
            $table->unsignedBigInteger('user_id')->nullable()->after('category_id');

            // Se quiser criar a FK e definir a ação on delete:
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove FK antes da coluna
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
