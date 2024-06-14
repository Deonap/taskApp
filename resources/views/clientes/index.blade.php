<html lang="en">    
    <head>
        <style>
            th {
                padding: 0.5rem 1rem 0.5rem 1rem;
                text-align: left;
                font-weight: 800;
            }
            td {
                padding: 0.5rem 1rem 0.5rem 1rem;
            }
            form {
                margin: auto;
            }
            table {
                width: 100%;
                table-layout: fixed;
            }
        </style>
    </head>
    <?php
        $hasPermissions = auth()->user() && auth()->user()->tipo == 'admin';
    ?>
    <body>
        <x-app-layout>
            @if(session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        alert('Clientes com projetos associados não podem ser removidos.');
                    });
                </script>
            @endif
            @if($errors->any())
                {{ implode('', $errors->all(':message')) }}
            @endif
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
                    <div class="flex justify-between items-center mb-4 mt-[1.75rem]">
                        <div>
                            <input id='searchFilter' type="text" placeholder="Pesquisar..." class="rounded-md border-gray-300 focus:border-darkBlue h-[40px]"/>
                        </div>
                        <div>
                            <button id="btnAdicionarLinha" class="bg-darkBlue hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-md">
                                Adicionar
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <table class="table-auto w-full" id="clientTable">
                        <thead>
                            <tr class="bg-gray-300">
                                <th scope="col" class="1/4">
                                    <div class="flex space-x-3 hover:cursor-pointer w-fit" onclick="sortByName()">
                                        <div>
                                            Nome
                                        </div>
                                        <div class="m-auto hidden" id="sortByDefault">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                            </svg>
                                        </div>
                                        <div class="m-auto hidden" id="sortByNameAsc">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                            </svg>
                                        </div>
                                        <div class="m-auto" id="sortByNameDesc">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                            </svg>
                                        </div>
                                    </div>
                                </th>
                                <th scope="col" class="w-1/4">
                                    Email
                                </th>
                                <th scope="col" class="w-1/4">
                                    Telefone
                                </th>
                                <th scope="col" class="w-1/4 text-right pr-[5rem]">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hidden avoidFilter" id="newClientRow">
                                <form method="POST" action="{{ route('clientes.store') }}" autocomplete="off">
                                @csrf
                                    <td>
                                        <div class="p-2">
                                            <input name="nome" class="bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                        </div>
                                    </td>
                                    <td class="hidden lg:table-cell">
                                        <input name="email" class="bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                    </td>
                                    <td class="hidden lg:table-cell"> 
                                        <input name="telefone" class="border-none bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                    </td>
                                    <td class="flex justify-end pr-[3rem]">
                                        <button type="submit" onclick="this.form.submit()" class="font-bold py-2 px-4 rounded bg-darkBlue text-white hover:cursor-pointer">Adicionar</button>
                                    </td>
                                </form>
                            </tr>
                            @foreach ($clientes as $cliente)
                                <tr class="border-b border-gray-200">
                                    <td>
                                        <div class="p-2">
                                            <a href="{{ route('clientes.show', $cliente->id) }}" title="Ver">
                                                {{ $cliente->nome }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="hidden lg:table-cell">
                                        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input name="email" value='{{ $cliente->email }}' class="border-none bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                        </form>
                                    </td>
                                    <td class="hidden lg:table-cell">
                                        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input name="telefone" value='{{ $cliente->telefone }}' class="border-none bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                        </form>
                                    </td>
                                    <td>
                                        <div class="flex justify-end pr-[2rem] space-x-3">
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
                                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Tem a certeza?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" {{$hasPermissions ? "" : 'disabled'}} class="disabled:cursor-not-allowed">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500 {{$hasPermissions ? "" : "hover:text-red-700"}}">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterInput = document.getElementById("searchFilter");
        var tableRows = document.querySelectorAll("#clientTable tbody tr:not(.avoidFilter)");

        filterInput.addEventListener("input", function () {
            const filterValue = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, '').trim();
            tableRows.forEach(function (row) {
                const name = row.querySelector("td:first-child").textContent.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, '');
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

    document.getElementById('btnAdicionarLinha').addEventListener('click', () => {
        document.getElementById('newClientRow').classList.remove("hidden");
    })

    function sortByName(){
        var defaultSort = document.getElementById('sortByDefault');
        var asc = document.getElementById('sortByNameAsc');
        var desc = document.getElementById('sortByNameDesc');
        var table = document.getElementById('clientTable');
        var shouldSwitch, x, y;

        if(!defaultSort.classList.contains("hidden")){
            defaultSort.classList.add('hidden');
            asc.classList.remove("hidden");
        }

        var switching = true;
        while(switching){
            switching = false;
            rows = table.rows;
            for(var i = 2; i < rows.length - 1; i++){
                shouldSwitch = false;
                x = rows[i].getElementsByTagName('a')[0].textContent.toLowerCase().trim();
                y = rows[i + 1].getElementsByTagName('a')[0].textContent.toLowerCase().trim();
                if(desc.classList.contains('hidden') && x > y || asc.classList.contains('hidden') && x < y){
                    shouldSwitch = true;
                    break;
                }
            }

            if(shouldSwitch){
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
        
        asc.classList.toggle('hidden');
        desc.classList.toggle('hidden');
    }
</script>