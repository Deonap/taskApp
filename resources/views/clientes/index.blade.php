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
                margin: auto;
            }
        </style>
    </head>
    <body>
        <x-app-layout>
            <div>
                <div>
                    <div class="flex items-center text-darkBlue">
                        <h2 class="hidden md:block text-xl font-black">
                            Clientes >
                        </h2>
                        <div class="text-xl font-black md:text-base md:font-normal ml-2 flex">
                            Listagem
                        </div>
                    </div>
                    <div class="flex justify-between items-center my-4">
                        <div>
                            <input id='searchFilter' type="text" placeholder="Pesquisar..." class="rounded-md border-gray-300 focus:border-darkBlue"/>
                        </div>
                        <a href="{{ route('clientes.create') }}" class="bg-darkBlue hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-md">
                            Adicionar
                        </a>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 my-4 border">
                    <div class="table-responsive">
                        <table class="table-auto w-full" id="clientTable">
                            <thead>
                                <tr class="bg-gray-300">
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Telefone
                                    </th>
                                    <th class="text-center">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr class="border-b border-gray-200">
                                        <td>
                                            {{ $cliente->nome }}
                                        </td>
                                        <td>
                                            {{ $cliente->email }}
                                        </td>
                                        <td>
                                            {{ $cliente->telefone }}
                                        </td>
                                        <td>
                                            <div class="flex justify-center items-center space-x-4">
                                                <!-- Botão Visualizar -->
                                                <a href="{{ route('clientes.show', $cliente->id) }}" title="Ver">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-green-800 hover:text-green-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                </a>

                                                <!-- Botão Editar -->
                                                <a href="{{ route('clientes.edit', $cliente->id) }}" title="Editar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                        
                                                <!-- Botão Excluir -->
                                                @if(auth()->user() && auth()->user()->tipo == 'admin')
                                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const filterInput = document.getElementById("searchFilter");
    const tableRows = document.querySelectorAll("#clientTable tbody tr");

    filterInput.addEventListener("input", function () {
        const filterValue = this.value.toLowerCase().trim();
        tableRows.forEach(function (row) {
            const name = row.querySelector("td:first-child").textContent.toLowerCase();
            if (name.includes(filterValue)) {
                row.style.display = "";
                row.classList.remove("hidden");
            } else {
                row.style.display = "none";
                row.classList.add("hidden");
            }
        });
    });
});
</script>