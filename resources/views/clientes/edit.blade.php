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
            <div class="flex-1 m-20">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center text-darkBlue">
                        <h2 class="text-xl font-black ">
                            Clientes >
                        </h2>
                        <div class="ml-2">
                            Editar
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                        @csrf
                        <div class="bg-white shadow-md rounded px-8  py-6 mb-4 border">
                            <div class="mb-4">
                                <div class="flex items-center space-x-3">
                                    <label for="nome">
                                        Nome
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" autocomplete='off' type="text" name="nome" value={{$cliente->nome}}>
                                </div>
                            </div>
                            <div class="mb-4 flex items-center space-x-3">
                                <div class="flex items-center space-x-3">
                                    <label for="email">
                                        Email
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" autocomplete='off' type="email" name="email" value={{$cliente->email}}>
                                </div>
                                <div class="flex items-center space-x-3">    
                                    <label for="telefone">
                                        Telefone 
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telefone" autocomplete='off' type="text" name="telefone" value={{$cliente->telefone}}>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row-reverse mb-4 px-8">
                            <button class="bg-darkBlue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Atualizar
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>