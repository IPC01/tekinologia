@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Products -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                    <i class="fas fa-box text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total de Produtos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 dark:bg-green-900/50 rounded-lg">
                    <i class="fas fa-shopping-cart text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total de Pedidos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        
        <!-- Today Sales -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
                    <i class="fas fa-clock text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Vendas Hoje</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $todaySales }}</p>
                </div>
            </div>
        </div>
        
        <!-- Monthly Sales -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 dark:bg-orange-900/50 rounded-lg">
                    <i class="fas fa-chart-line text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Vendas Este Mês</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $monthSales }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Sales Chart -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Vendas Mensais</h3>
            <canvas id="monthlySalesChart" height="250"></canvas>
        </div>
        
        <!-- Order Status Chart -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status dos Pedidos</h3>
            <canvas id="orderStatusChart" height="250"></canvas>
        </div>
    </div>
    
    <!-- Recent Orders & Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pedidos Recentes</h3>
                    <a href="{{ route('orders.myorders') }}" 
                       class="text-primary-600 dark:text-primary-400 hover:text-primary-500 text-sm font-medium">
                        Ver todos
                    </a>
                </div>
            </div>
            
            <div class="p-6">
                @if($recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-receipt text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white">Pedido #{{ $order->order_number }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->product->title }}</p>
                                    <p class="text-xs mt-1">
                                        <span class="px-2 py-1 rounded-full text-xs 
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $order->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart text-gray-400 dark:text-gray-500 text-3xl mb-3"></i>
                        <p class="text-gray-600 dark:text-gray-400">Nenhum pedido encontrado</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Top Products -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Produtos Mais Vendidos</h3>
                    <a href="{{ route('products.index') }}" 
                       class="text-primary-600 dark:text-primary-400 hover:text-primary-500 text-sm font-medium">
                        Ver todos
                    </a>
                </div>
            </div>
            
            <div class="p-6">
                @if($topProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($topProducts as $product)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center overflow-hidden">
                                    @if($product->coverImage)
                                        <img src="{{ $product->coverImage->path }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-image text-gray-400 dark:text-gray-500"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $product->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $product->category->name ?? 'Sem categoria' }}</p>
                                </div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $product->orders_count }} vendas
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-box text-gray-400 dark:text-gray-500 text-3xl mb-3"></i>
                        <p class="text-gray-600 dark:text-gray-400">Nenhum produto encontrado</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    // Monthly Sales Chart
    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    const monthlySalesChart = new Chart(monthlySalesCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                label: 'Vendas Mensais',
                data: @json(array_values($monthlySales->toArray())),
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderColor: 'rgba(79, 70, 229, 0.8)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Order Status Chart
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    const orderStatusChart = new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($orderStatuses->keys()),
            datasets: [{
                data: @json($orderStatuses->values()),
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)', // completed - green
                    'rgba(245, 158, 11, 0.8)', // pending - yellow
                    'rgba(239, 68, 68, 0.8)',  // cancelled - red
                    'rgba(99, 102, 241, 0.8)', // other - indigo
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
</script>

@endsection