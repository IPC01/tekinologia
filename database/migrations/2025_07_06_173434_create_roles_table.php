<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Criação da tabela de roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Inserção dos papéis iniciais
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'seller'],
            ['name' => 'client'],
            
        ]);

        // Adiciona a coluna role_id à tabela users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                  ->nullable()
                  ->constrained('roles')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Remove a foreign key e a coluna
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });

        // Remove a tabela de roles
        Schema::dropIfExists('roles');
    }
};
