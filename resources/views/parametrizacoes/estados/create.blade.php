<x-app-layout>

    <div>
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center text-darkBlue">
                <h2 class="hidden md:block text-xl font-black">
                    Estado >
                </h2>
                <div class="text-xl font-black md:text-base md:font-normal ml-2 flex">
                    Criar
                    <div class="block md:hidden ml-2">
                        Estado
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('estado-projetos.store') }}" method="POST">
                @csrf
                <div class="bg-white shadow-md rounded px-5 py-6 mb-4 border w-fit">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nome">
                            Nome do Estado
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" type="text" placeholder="Nome do Estado" name="nome">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="cor">
                            Cor
                        </label>
                        <input class="shadow border rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cor" type="color" name="cor">
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-darkBlue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Adicionar Estado
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>