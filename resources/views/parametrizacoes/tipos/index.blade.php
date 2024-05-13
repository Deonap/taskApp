<html lang="en">
    <head>
        <style>
            th{
                padding: 0.5rem 1rem 0.5rem 1rem;
                text-align: left;
                font-weight: 800;
            }
            td{
                padding: 0.5rem 1rem 0.5rem 1rem;
            }
            form{
                margin:auto;
            }
            table{
                width: 100%;
                table-layout: fixed;
            }
        </style>
    </head>
    <body>
        <x-app-layout>
            <div>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center text-darkBlue">
                        <h2 class="hidden md:block text-xl font-black">
                            Parametrizações >
                        </h2>
                        <div class="text-xl font-black md:text-base md:font-normal ml-2">
                            Tipo de Cliente
                        </div>
                    </div>
                    <btn id="btnAdicionarLinha" class="bg-darkBlue hover:bg-blue-700 hover:cursor-pointer text-white font-semibold py-2 px-4 rounded-md shadow-md">
                        Adicionar
                    </btn>
                </div>
                
                <div class="bg-white shadow-md rounded px-2 md:px-8 pt-6 pb-8 mb-4 border">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-300">
                                <th scope="col" class="w-1/3">
                                    Nome
                                </th>
                                <th scope="col" class="w-1/3">
                                    Cor
                                </th>
                                <th scope="col" class="w-1/3 text-center">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tipos as $tipo)
                            <tr class="border-b">
                                <td>
                                    <form action="{{route('tipo-clientes.update', $tipo->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input name="nome" value='{{ $tipo->nome }}' onchange="this.form.submit()" class="border-none bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route('tipo-clientes.update', $tipo->id)}}" class="ml-2 size-6" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input class="w-full" id="cor" onchange="this.form.submit()" type="color" name="cor" value="{{ $tipo->cor }}">
                                    </form>
                                </td>
                                <td>
                                    <div class="flex justify-center space-x-3">
                                        <a href="{{ route('tipo-clientes.edit', $tipo->id) }}" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        @if(auth()->user() && auth()->user()->tipo == 'admin')
                                            <form action="{{ route('tipo-clientes.destroy', $tipo->id) }}" method="POST" onsubmit="return confirm('Tem a certeza?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="hidden" id="newTypeRow">
                                <form method="POST" action="{{ route('tipo-clientes.store') }}" autocomplete="off">
                                @csrf
                                    <td>
                                        <input name="nome" class="bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                    </td>
                                    <td>
                                        <div class="ml-2 size-6">
                                            <input class="w-full" id="cor" value="#000000" type="color" name="cor">
                                        </div>
                                    </td>
                                    <td class="flex items-center">
                                        <button type="submit" onclick="this.form.submit()" class="m-auto font-bold py-2 px-4 rounded bg-darkBlue text-white hover:cursor-pointer">Adicionar</button>
                                    </td>
                                </form>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>
<script>
    document.getElementById('btnAdicionarLinha').addEventListener('click', () => {
        document.getElementById('newTypeRow').classList.remove("hidden");
    })
</script>