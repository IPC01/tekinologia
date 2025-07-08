<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Inserção inicial de categorias comuns para produtos digitais
        DB::table('categories')->insert([
            [
                'name' => 'Aplicativo',
                'description' => 'Produtos digitais desenvolvidos para dispositivos móveis ou desktops.'
            ],
            [
                'name' => 'Website',
                'description' => 'Páginas web acessíveis por navegadores com finalidades diversas.'
            ],
            [
                'name' => 'Portfólio',
                'description' => 'Projetos voltados à apresentação de competências, experiências e trabalhos anteriores.'
            ],
            [
                'name' => 'E-commerce',
                'description' => 'Plataformas para compra e venda de produtos ou serviços online.'
            ],
            [
                'name' => 'Landing Page',
                'description' => 'Página única, geralmente para capturar leads ou divulgar algo específico.'
            ],
            [
                'name' => 'Dashboard',
                'description' => 'Painéis para visualização de métricas e relatórios de sistemas.'
            ],
            [
                'name' => 'Sistema de Gestão',
                'description' => 'Softwares para controlar operações administrativas, financeiras ou de RH.'
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
