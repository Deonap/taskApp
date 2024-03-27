<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-lg">
        <div class="md:flex">
            <div class="w-full p-4">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold">Adicionar Novo Usuário</h1>
                </div>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    {{-- Nome --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                        <input type="text" name="name" id="name" class="form-input mt-1 block w-full" required>
                    </div>
                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="form-input mt-1 block w-full" required>
                    </div>
                    {{-- Senha --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                        <input type="password" name="password" id="password" class="form-input mt-1 block w-full" required>
                    </div>
                    {{-- Tipo --}}
                    <div class="mb-4">
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                        <select id="tipo" name="tipo" class="form-select mt-1 block w-full">
                            <option value="colaborador">Colaborador</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar Usuário</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>