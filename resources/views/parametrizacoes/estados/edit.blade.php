<x-app-layout>
    <div class="flex-1 m-20">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center text-darkBlue">
                <h2 class="text-xl font-black ">
                    Projeto >
                </h2>
                <div class="ml-2">
                    Editar
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('estado-projetos.update', $estadoProjeto->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white shadow-md rounded px-5 py-6 mb-4 border w-fit">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nome">
                            Nome do Estado
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" type="text" name="nome" value="{{ $estadoProjeto->nome }}">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="cor">
                            Cor
                        </label>
                        <input class="shadow border rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cor" type="color" name="cor" value="{{ $estadoProjeto->cor }}">
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-darkBlue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Atualizar Estado
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>