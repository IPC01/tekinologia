@extends('admin.layouts.app')
@section('title', 'Pedidos')
@section('page-title', 'Gerenciar Pedidos')

@section('content')
    <div class="space-y-6">

        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Lista de Pedidos</h2>
        </div>

        <div
            class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            @if ($orders->count())
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#
                                Pedido</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Usuário</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Desconto</th>
                           
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Método</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Telefone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Valor Recebido pelo Vendedor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Comissão da Plataforma
                            </th>
                             <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Status</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $order->product->title ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $order->user->name ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">R$
                                    {{ number_format($order->price, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    @if ($order->discount > 0)
                                        R$ {{ number_format($order->discount, 2, ',', '.') }}
                                    @else
                                        —
                                    @endif
                                </td>
                            
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ strtoupper($order->payment_method) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($order->paid_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $order->phone }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $order->payout_amount }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $order->platform_fee }}</td>
                                    <td class="px-6 py-4 text-sm">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $order->status === 'completed'
                                            ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100'
                                            : ($order->status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100'
                                                : 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-box-open text-gray-400 dark:text-gray-500 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhum pedido encontrado</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Nenhum pedido foi registrado ainda.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
