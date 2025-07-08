@extends('admin.layouts.app')
@section('title', 'Saldo e Saques')
@section('page-title', 'Gerenciar Saldo e Saques')

@section('content')
    <div class="space-y-6">
        <!-- Cards de Resumo -->
        @if ($account)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Saldo Atual -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-wallet text-green-500 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Saldo Atual</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($account->balance, 2, ',', '.') }} MT</p>
                        </div>
                    </div>
                </div>

                <!-- Total Acumulado -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line text-blue-500 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Acumulado</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($account->amount, 2, ',', '.') }} MT</p>
                        </div>
                    </div>
                </div>

                <!-- Total Sacado -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-money-bill-wave text-red-500 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Sacado</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($withdrawals->sum('amount'), 2, ',', '.') }} MT</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-percentage text-red-500 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Comissao da plataforma(%)</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($setting->commission_rate, 2, ',', '.') }} MT</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Histórico de Saques</h2>
                <button type="button" onclick="openWithdrawalModal()"
                    class="inline-flex items-center px-4 py-2 bg-[#d4d5ff] text-[#5855eb] hover:bg-[#c2c3f0] dark:bg-[#3d3fbf] dark:text-[#a7a9ff] dark:hover:bg-[#2f31a5] rounded-lg shadow-sm transition-colors duration-200">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    Novo Saque
                </button>
            </div>

            <!-- Tabela de Saques -->
            <div
                class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                @if ($withdrawals->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Data</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Conta</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Telefone</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Método</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Valor</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($withdrawals as $withdrawal)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $withdrawal->created_at->format('d/m/Y H:i') }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $withdrawal->account_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $withdrawal->phone_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if ($withdrawal->payment_method == 'M-Pesa') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($withdrawal->payment_method == 'E-Mola') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 @endif">
                                            {{ $withdrawal->payment_method }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($withdrawal->amount, 2, ',', '.') }} MT</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
    bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Concluído
                                        </span>

                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button type="button" onclick='viewWithdrawal(@json($withdrawal))'
                                            class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400"
                                            title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if ($withdrawal->status == 'pending')
                                            <form action="{{ route('withdrawals.cancel', $withdrawal->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    onclick="return confirm('Deseja cancelar este saque?')"
                                                    class="text-red-600 hover:text-red-900 dark:hover:text-red-400"
                                                    title="Cancelar">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-10">
                        <i class="fas fa-money-bill-wave text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-300">Nenhum saque realizado.</p>
                    </div>
                @endif
            </div>
    </div>

    <!-- Modal para Novo Saque -->
    <div id="withdrawalModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 w-full max-w-lg mx-auto rounded-xl shadow p-6 relative">
            <button type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-900 dark:hover:text-white"
                onclick="closeWithdrawalModal()">
                <i class="fas fa-times"></i>
            </button>
            <h2 id="modalTitle" class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Novo Saque</h2>

            <form id="withdrawalForm" method="POST" action="{{ route('finance.store') }}">
                @csrf

                <!-- Account ID -->
                <div class="mb-4">
                    <input type="hidden" name="account_id" id="account_id" value="{{ $account->id }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        required>
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número
                        de Telefone *</label>
                    <input type="tel" name="phone_number" id="phone_number" placeholder="ex: 841234567"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        required>
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <label for="payment_method"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Método de Pagamento
                        *</label>
                    <select name="payment_method" id="payment_method"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        required>
                        <option value="">Selecione um método</option>
                        <option value="mPesa">M-Pesa</option>
                        <option value="eMola">E-Mola</option>
                    </select>
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor
                        (MT) *</label>
                    <input type="number" name="amount" id="amount" step="0.01"
                        min="{{ $setting->payout_minimum }}" min="{{ $account->balance }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        required>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Saldo disponível:
                        {{ number_format($account->balance, 2, ',', '.') }} MT </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"> Valor minimo de saque:
                        {{ number_format($setting->payout_minimum, 2, ',', '.') }} MT </p>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeWithdrawalModal()"
                        class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white mr-2">Cancelar</button>
                    <button type="submit"
                        class="px-6 py-2 bg-[#d4d5ff] text-[#5855eb] hover:bg-[#c2c3f0] dark:bg-[#3d3fbf] dark:text-[#a7a9ff] dark:hover:bg-[#2f31a5] rounded-lg shadow-sm transition">Sacar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Visualizar Saque -->
    <div id="viewWithdrawalModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 w-full max-w-lg mx-auto rounded-xl shadow p-6 relative">
            <button type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-900 dark:hover:text-white"
                onclick="closeViewWithdrawalModal()">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Detalhes do Saque</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ID da Conta</label>
                    <p id="viewAccountId" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número de
                        Telefone</label>
                    <p id="viewPhoneNumber" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Método de
                        Pagamento</label>
                    <p id="viewPaymentMethod" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor</label>
                    <p id="viewAmount" class="text-gray-900 dark:text-white font-semibold"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <p id="viewStatus" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data</label>
                    <p id="viewDate" class="text-gray-900 dark:text-white"></p>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeViewWithdrawalModal()"
                    class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Fechar</button>
            </div>
        </div>
    </div>
@else
    <div class="text-center py-10">
        <i class="fas fa-money-bill-wave text-gray-400 text-4xl mb-4"></i>
        <p class="text-gray-600 dark:text-gray-300">Nenhum historico iniciado</p>
    </div>
    @endif
    <script>
        function openWithdrawalModal() {
            const modal = document.getElementById('withdrawalModal');
            const form = document.getElementById('withdrawalForm');

            form.reset();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeWithdrawalModal() {
            const modal = document.getElementById('withdrawalModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function viewWithdrawal(withdrawal) {
            const modal = document.getElementById('viewWithdrawalModal');

            document.getElementById('viewAccountId').textContent = withdrawal.account_id;
            document.getElementById('viewPhoneNumber').textContent = withdrawal.phone_number;
            document.getElementById('viewPaymentMethod').textContent = withdrawal.payment_method;
            document.getElementById('viewAmount').textContent = new Intl.NumberFormat('pt-MZ', {
                style: 'currency',
                currency: 'MZN'
            }).format(withdrawal.amount);

            const statusMap = {
                'completed': 'Concluído',
                'pending': 'Pendente',
                'cancelled': 'Cancelado'
            };
            document.getElementById('viewStatus').textContent = statusMap[withdrawal.status] || withdrawal.status;

            const date = new Date(withdrawal.created_at);
            document.getElementById('viewDate').textContent = date.toLocaleString('pt-MZ');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeViewWithdrawalModal() {
            const modal = document.getElementById('viewWithdrawalModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

@endsection
