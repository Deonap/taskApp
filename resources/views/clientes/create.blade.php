<html lang='en'>
    <head>
        <style>
            label{
                display: block;
                font-size: 0.875rem;
                line-height: 1.25rem;
                margin-bottom: 0.5rem;
                font-weight: 700;
                 color: rgb(0 40 91);
            }
        </style>
    </head>
    <body>
        <x-app-layout>
            <div>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center text-darkBlue">
                        <h2 class="hidden md:block text-xl font-black">
                            Clientes >
                        </h2>
                        <div class="text-xl font-black md:text-base md:font-normal ml-2 flex">
                            Adicionar
                            <div class="block md:hidden ml-2">
                                Cliente
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @csrf
                        <div class="bg-white shadow-md rounded px-8 py-6 mb-4 border">
                            <div class="mb-4">
                                <div class="flex items-center space-x-3">
                                    <label for="nome">
                                        Nome
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" autocomplete='off' type="text" name="nome">
                                </div>
                            </div>

                            <div class="mb-4 lg:flex lg:items-center">
                                <div class="flex items-center space-x-3">
                                    <label for="email">
                                        Email
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" autocomplete='off' type="email" name="email">
                                </div>
                                <div class="flex lg:ml-3 mt-4 lg:mt-0 items-center space-x-3">    
                                    <label for="telefone">
                                        Telefone 
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telefone" autocomplete='off' type="text" name="telefone">
                                </div>
                            </div>
                            
                        </div>
                        <div class="flex flex-row-reverse mb-4 px-8">
                            <button class="bg-darkBlue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>