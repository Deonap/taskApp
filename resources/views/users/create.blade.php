<x-app-layout>
<div class="flex-1 m-20">
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center text-darkBlue">
            <h2 class="hidden md:block text-xl font-black">
                Utilizador >
            </h2>
            <div class="text-xl font-black md:text-base md:font-normal ml-2 flex">
                Adicionar
                <div class="ml-2 block md:hidden">
                    Utilizador
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-between items-center mb-4">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="bg-white shadow-md rounded px-5 py-6 mb-4 border w-fit">
                {{-- Nome --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" name="name" id="name" class="form-input mt-1 block w-full" required>
                </div>
                {{-- Email --}}
                <div class="mb-4 w-[250px]">
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
                    <button type="submit" class="bg-darkBlue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Salvar Usuário</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>