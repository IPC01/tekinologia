@extends('admin.layouts.app')
@section('title', 'Categorias')
@section('page-title', 'Gerenciar Categorias')

@section('content')
    <div class="space-y-6">
        <!-- Ações -->
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Categorias Cadastradas</h2>
            <button type="button" onclick="openCategoryModal()" class="inline-flex items-center px-4 py-2 bg-[#d4d5ff] text-[#5855eb] hover:bg-[#c2c3f0] dark:bg-[#3d3fbf] dark:text-[#a7a9ff] dark:hover:bg-[#2f31a5] rounded-lg shadow-sm transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Nova Categoria
            </button>
        </div>

        <!-- Tabela de Categorias -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            @if ($categories->count() > 0)
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Descrição</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($categories as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $category->description ?? '—' }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button type="button" onclick='openCategoryModal(@json($category))' class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Deseja excluir esta categoria?')" class="text-red-600 hover:text-red-900 dark:hover:text-red-400" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-10">
                    <i class="fas fa-folder-open text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-300">Nenhuma categoria cadastrada.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para Criar/Editar Categoria -->
    <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 w-full max-w-lg mx-auto rounded-xl shadow p-6 relative">
            <button type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-900 dark:hover:text-white" onclick="closeCategoryModal()">
                <i class="fas fa-times"></i>
            </button>
            <h2 id="modalTitle" class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Nova Categoria</h2>

            <form id="categoryForm" method="POST" action="{{ route('categories.store') }}">
                @csrf
                <input type="hidden" id="methodInput" name="_method" value="POST">

                <!-- Nome -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome *</label>
                    <input type="text" name="name" id="name"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white" required>
                </div>

                <!-- Descrição -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white mr-2">Cancelar</button>
                    <button type="submit" class="px-6 py-2 bg-[#d4d5ff] text-[#5855eb] hover:bg-[#c2c3f0] dark:bg-[#3d3fbf] dark:text-[#a7a9ff] dark:hover:bg-[#2f31a5] rounded-lg shadow-sm transition">Salvar</button>
                </div>
            </form>
        </div>
    </div>
  
<script>
    function openCategoryModal(category = null) {
        const modal = document.getElementById('categoryModal');
        const form = document.getElementById('categoryForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('methodInput');

        form.reset();

        if (category) {
            title.innerText = 'Editar Categoria';
            form.action = `/admin/categories/${category.id}`;
            methodInput.value = 'PUT';
            document.getElementById('name').value = category.name ?? '';
            document.getElementById('description').value = category.description ?? '';
        } else {
            title.innerText = 'Nova Categoria';
            form.action = "{{ route('categories.store') }}";
            methodInput.value = 'POST';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCategoryModal() {
        const modal = document.getElementById('categoryModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

@endsection


