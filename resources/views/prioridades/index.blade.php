<html lang="en">
    <head>
        <style>
            #toggleFerias:checked+.toggle-line {
                background-color: rgb(10, 56, 87);
                /* Change this to your desired color when toggle is active */
            }

            #toggleFerias:checked+.toggle-line+.toggle-dot {
                transform: translateX(100%);
            }

            .toggle-line,
            .toggle-dot {
                transition-duration: 1s;
                /* Adjust the duration as needed */
            }
            th{
                /* px-3 py-1 text-left font-bold text-black uppercase tracking-wider border-b */
                padding: 0.25rem 0.75rem 0.25rem 0.75rem;
                text-align: left;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-bottom-width: 1px;
                font-size: 14px;
            }

            .disabledTable{
                pointer-events: none !important;
            }
        </style>
        @vite(['resources/js/prioridades/script.js'])

    </head>
    <body>
        <x-app-layout>
            <div class="flex-1 m-20">
                <div>
                    <div class="flex items-center text-darkBlue">
                        <h2 class="text-xl font-black">
                            Prioridades >
                        </h2>
                        <div class="ml-2">
                            Definir
                        </div>
                    </div>
                    <div class="flex justify-between items-center my-4">
                        <div class="flex justify-between mb-4">
                            <div class="flex items-center">
                                <label for="colaborador" class="block text-sm font-medium "></label>
                                <div class="relative">
                                    <select id="colaborador" name="colaborador" class="appearance-none border  rounded-md w-48 py-2 pl-3 pr-10  leading-tight focus:outline-none focus:shadow-outline text-white bg-darkBlue">
                                        @foreach($colaboradores as $colaborador)
                                            <option value="{{ $colaborador->id }}">{{ $colaborador->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="toggleFerias" class="flex items-center cursor-pointer">
                                        <div class="mx-3 text-gray-700 font-medium">
                                            Férias
                                        </div>
                                        <div class="relative">
                                            <input id="toggleFerias" type="checkbox" class="hidden" />
                                            <div class="toggle-line w-10 h-4 bg-gray-400 rounded-full shadow-inner transition-colors">
                                            </div>
                                            <div class="toggle-dot absolute w-6 h-6 bg-white rounded-full shadow inset-y-0 left-0 transition-transform border" style="top: -4px;">
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div id="tabelaProjetosAbertos" class="mb-8">
                        <div class="flex items-center text-white  mb-4" style="width: 100%;">
                            <div class="flex-none" style="width: 70%; height: 40px; background-color: {{$corDesenvolvimento}}; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: start; align-items: center;">
                                <h3 class="text-lg font-semibold">Projetos Em Desenvolvimento</h3>
                            </div>
                            <div class="flex-none ml-4" style="width: 29%; height: 30px; background-color: #f0f1f0; color: black; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: center; align-items: center;">
                                <p class="text-sm font-medium">
                                    Data da Semana: {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }} - {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-[#d5d4d5]">
                                    <tr>
                                        <th scope="col">
                                            Nº
                                        </th>
                                        <th scope="col">
                                            Cliente
                                        </th>
                                        <th scope="col">
                                            Tipo
                                        </th>
                                        <th scope="col">
                                            Projeto
                                        </th>
                                        <th scope="col" style="font-size: 14px;border-right: 2px solid #bbbaba;">
                                            Prioridade
                                        </th>
                                        <th scope="col">
                                            Observações
                                        </th>
                                        <th scope="col">
                                            Tempo
                                        </th>
                                        <th scope="col">
                                            Estado
                                        </th>
                                        <th scope="col">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($projetosEmAberto as $projeto)
                                        @php
                                            if($colaboradores[0] && $colaboradores[0]->tipo == "colaborador"){
                                                $colaboradorProjeto = $colaboradores[0];
                                            } else{
                                                $colaboradorProjeto = NULL;
                                            }
                                        @endphp
                                        <tr data-id="{{ $projeto->id }}" data-user-id="{{ optional($projeto->users->first())->id }}">
                                            <td class="border px-3 py-4 whitespace-nowrap border-b">
                                                @if($projeto->users->isNotEmpty())
                                                    {{ $projeto->users->first()->pivot->prioridade }}
                                                @else
                                                    {{ 'Sem prioridade definida' }}
                                                @endif
                                            </td>
                                            <td class="border px-3 py-4 whitespace-nowrap border-b">
                                                {{ $projeto->cliente->nome ?? 'Cliente não especificado' }}
                                            </td>
                                            <td class="border px-3 py-4 whitespace-nowrap border-b">
                                                {{ $projeto->tipoCliente->nome ?? 'Tipo não especificado' }}
                                            </td>
                                            <td class="border px-3 py-4 whitespace-nowrap border-b">
                                                {{ $projeto->nome }}
                                            </td>
                                            <td class="border px-3 py-4 whitespace-nowrap border-b w-1/4" style="border-right: 2px solid #bbbaba;">
                                                <!-- Ajustando a largura da coluna de tarefas -->
                                                @foreach($projeto->tarefas as $tarefa)
                                                    <div>
                                                        {{ $tarefa->descricao }}
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td class="border px-3 py-4 whitespace-nowrap border-b w-1/4">
                                                <textarea class="form-input observacoes border border-gray-300 rounded-md w-full resize-none h-16 overflow-hidden text-start hover:cursor-default" rows="3" readonly>
                                            </textarea>
                                            </td>
                                            <td class="border px-3 py-4 whitespace-nowrap border-b w-1/12">
                                                <input class="border border-gray-300 rounded-md p-2 w-full tempo-gasto text-center" autocomplete="off" pattern="[0-9]{0,4}:[0-5][0-9]" type="text" placeholder="--:--" name="tempoPrevisto">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <div style="background-color: {{ $projeto->estadoProjeto->cor }}; margin: auto;" class="w-7 h-7 rounded-full">
                                                </div>
                                            </td>
                                            <td class="border px-3 py-4 whitespace-nowrap border-b">
                                                <div class="flex justify-center items-center space-x-4">
                                                    <!-- Botão Editar -->
                                                    <a href="{{ route('projetos.edit', $projeto->id) }}" title="Editar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                    </a>
                                            
                                                    <!-- Botão Excluir -->
                                                    @if(auth()->user() && auth()->user()->tipo == 'admin')
                                                        <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST">
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

                    <div id="tabelaProjetosPendentes" class="mb-8">
                        <div class="relative mb-4">
                            <div class="flex-none text-white w-[70%] h-[40px] p-[1rem] flex items-center" style="background-color: {{$corPendente}}; border-radius: 0.2rem; justify-content: start;">
                                <h3 class="text-lg font-semibold">Projetos Pendentes</h3>
                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#d5d4d5]">
                                <tr>
                                    <th scope="col">
                                        Cliente
                                    </th>
                                    <th scope="col">
                                        Tipo
                                    </th>
                                    <th scope="col">
                                        Projeto
                                    </th>
                                    <th scope="col">
                                        Prioridade
                                    </th>
                                    <th scope="col">
                                        Estado
                                    </th>
                                    <th scope="col">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($projetosPendentes as $projeto)
                                    <tr data-id="{{ $projeto->id }}">
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->cliente->nome ?? 'Cliente não especificado' }}
                                        </td>
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->tipoCliente->nome ?? 'Tipo não especificado'}}
                                        </td>
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->nome }}
                                        </td>
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            @foreach($projeto->tarefas as $tarefa)
                                                <div>
                                                    {{ $tarefa->descricao }}
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="border px-4 py-2">
                                            <div style="background-color: {{ $projeto->estadoProjeto->cor }}; margin: auto;" class="w-7 h-7 rounded-full">
                                            </div>
                                        </td>
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center items-center">
                                                <a href="{{ route('projetos.edit', $projeto->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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

                    <div id="tabelaProjetosOutrosColaboradores" class="mb-8">
                        <div class="relative mb-4">
                            <div class="flex-none text-white" style="width: 70%; height: 40px; background-color: #641885; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: start; align-items: center;">
                                <h3 class="text-lg font-semibold">Projetos com Outros Colaboradores</h3>
                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#d5d4d5]">
                                <th scope="col">
                                    Cliente
                                </th>
                                <th scope="col">
                                    Tipo
                                </th>
                                <th scope="col">
                                    Projeto
                                </th>
                                <th scope="col">
                                    Prioridade
                                </th>
                                <th scope="col">
                                    Colaboradores
                                </th>
                                <th scope="col">
                                    Estado
                                </th>
                                <th scope="col">
                                    Ações
                                </th>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($projetosComOutros as $projeto)
                                    <tr>
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->cliente->nome ?? 'Cliente não especificado' }}
                                        </td>
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->tipoCliente->nome ?? 'Tipo não especificado' }}
                                        </td>
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->nome }}
                                        </td>
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            @foreach ($projeto->tarefas as $tarefa)
                                                <div>
                                                    {{ $tarefa->descricao }}
                                                </div>
                                            @endforeach
                                        </td>
                                        
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            @foreach ($projeto->users as $user)
                                                <span>{{ $user->name }}</span>{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </td>
                                        
                                        <td class="border px-4 py-2">
                                            <div style="background-color: {{ $projeto->estadoProjeto->cor }};" class="w-7 h-7 rounded-full m-auto">
                                            </div>
                                        </td>
                                        <td class="border px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center items-center">
                                                <a href="{{ route('projetos.edit', $projeto->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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
                    <div class="flex justify-end mb-8">
                        <button id="salvarPrioridades" class="bg-[#0a3857] text-white py-3 px-6 text-lg rounded w-40 mb-4">Guardar</button>
                    </div>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>