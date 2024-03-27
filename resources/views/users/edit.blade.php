<x-app-layout>
    
@if(auth()->user() && auth()->user()->tipo == 'admin')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-lg">
            <div class="md:flex">
                <div class="w-full p-4">
                    <div class="mb-4">
                        <h1 class="text-xl font-semibold">Editar Usuário</h1>
                    </div>
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- Nome --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-input mt-1 block w-full" required>
                        </div>
                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-input mt-1 block w-full" required>
                        </div>
                        {{-- Tipo --}}
                        <div class="mb-4">
                            <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                            <select id="tipo" name="tipo" class="form-select mt-1 block w-full">
                                <option value="colaborador" {{ $user->tipo == 'colaborador' ? 'selected' : '' }}>Colaborador</option>
                                <option value="admin" {{ $user->tipo == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Atualizar Usuário</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
</x-app-layout>