<html lang='en'>
    <head>
        <style>.content-margin {
            margin: 50px;
            /* Outros estilos conforme necessário */
        }
        .btn-selecionar-colaborador,
        .btn-adicionar-colaborador {
            margin-left: 5px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
        }
        th{
            padding: 0.75rem 1.5rem 0.75rem 1.5rem;
            text-align: left;
            font-weight: 800;
        }
        td{
            padding: 0.75rem 1.5rem 0.75rem 1.5rem;
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
                            Ver Cliente
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mb-4 flex items-center space-x-3 w-full">
                        <div class="flex items-center space-x-3 w-full">
                            <label for="nome">
                                Nome
                            </label>
                            <input disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" autocomplete='off' type="text" name="nome" placeholder="{{$cliente->nome}}">
                        </div>
                        <div class="flex items-center space-x-3 w-full">
                            <label for="email">
                                Email
                            </label>
                            <input disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" autocomplete='off' type="email" name="email" placeholder={{$cliente->email}}>
                        </div>
                        <div class="flex items-center space-x-3 w-full">    
                            <label for="telefone">
                                Telefone 
                            </label>
                            <input disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telefone" autocomplete='off' type="text" name="telefone" placeholder={{$cliente->telefone}}>
                        </div>
                    </div>
                    <div class="my-10">
                        <button id="btnProjetosAbertos" class="bg-darkBlue text-white py-2 px-4 rounded mr-4">
                            Projetos Abertos/Pendentes
                        </button>
                        <button id="btnProjetosConcluidos" class="bg-gray-400 text-white py-2 px-4 rounded">
                            Projetos Concluídos
                        </button>
                    </div>

                    <div id="tabelaProjetosAbertos" class="bg-white p-4 rounded shadow-md border mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="bg-gray-300">
                                        <th>
                                            Tipo
                                        </th>
                                        <th>
                                            Projeto
                                        </th>
                                        <th>
                                            Notas Iniciais
                                        </th>
                                        <th>
                                            Tempo Previsto
                                        </th>
                                        <th>
                                            Colaborador
                                        </th>
                                        <th>
                                            Tempo Investido
                                        </th>
                                        @if(auth()->user() && auth()->user()->tipo == 'admin')
                                            <th class="text-center">
                                                Ações
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($projetosAbertos as $projeto)
                                        <tr>
                                            <td>
                                                {{ $projeto->tipoCliente->nome }}
                                            </td>
                                            <td>
                                                {{ $projeto->nome }} -> 
                                                {{$projeto->id}}
                                            </td>
                                            <td>
                                                <!-- Descrição de cada tarefa do projeto -->
                                                @foreach($projeto->tarefas as $tarefa)
                                                    {{ $tarefa->descricao }}
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                {{ $projeto->tempo_previsto }}
                                            </td>
                                            <td>
                                                <div class="flex items-end">
                                                    <div id="colaboradorCell/{{$projeto->id}}" class="colaboradorCell">
                                                        @foreach($projeto->users as $user)
                                                            <form action="{{ route('projetos.colaboradores.atualizar', $projeto->id) }}" method="POST" class="my-0 py-0">
                                                            @csrf
                                                            @method('PUT')
                                                                <div class="flex items-center @if(!$loop->last) border-b border-gray-400 @endif p-1">
                                                                    <select name="novoColaborador" id={{$projeto->id}} onchange="this.form.submit()" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                                                        @foreach($colaboradores as $colaborador)
                                                                            @if(!$projeto->users->contains($colaborador) || $colaborador->id == $user->id)
                                                                                <option value="{{$colaborador->id}}/{{$user->id}}" class="w-fit" {{$colaborador->id == $user->id ? 'selected' : ''}}>{{ $colaborador->name }} -> {{$colaborador->id}}</option>        
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </form>
                                                        @endforeach
                                                    </div>
                                                    <div class="my-0 mx-3 {{$projeto->users->count() == $colaboradores->count() ? 'hidden' : ''}}">
                                                        <button id="{{$projeto->id}}"class="btn-adicionar-colaborador">
                                                            <!-- + -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                                            </svg>                                                                      
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div>
                                                    @foreach($projeto->users as $user)
                                                        <div class="text-center @if(!$loop->last) border-b border-gray-400 @endif p-1">
                                                            {{ $user->tempoGasto($projeto) }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            @if(auth()->user() && auth()->user()->tipo == 'admin')
                                                <td>
                                                    <div class="flex justify-center space-x-3">
                                                        <a href="{{ route('projetos.edit', $projeto->id) }}" title="Editar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </a>
                                                        <form method="POST" action="{{ route('projetos.destroy', $projeto->id) }}" title="Remover">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Tem a certeza?')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="tabelaProjetosConcluidos" class="bg-white p-4 rounded shadow-md border mb-8 hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="bg-gray-300">
                                        <th>
                                            Tipo
                                        </th>
                                        <th>
                                            Projeto
                                        </th>
                                        <th>
                                            Notas Iniciais
                                        </th>
                                        <th class="text-center">
                                            Tempo Previsto
                                        </th>
                                        <th>
                                            Colaborador
                                        </th>
                                        <th class="text-center">
                                            Tempo Investido
                                        </th>
                                        <th>

                                        </th>
                                        @if(auth()->user() && auth()->user()->tipo == 'admin')
                                            <th class="text-center">
                                                Ações
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($projetosConcluidos as $projeto)
                                        <tr>
                                            <td>
                                                {{ $projeto->tipoCliente->nome }}
                                            </td>
                                            <td>
                                                {{ $projeto->nome }}
                                            </td>
                                            <td>
                                                {{ $projeto->notas_iniciais }}
                                            </td>
                                            <td class="text-center">
                                                {{ $projeto->tempo_previsto }}
                                            </td>
                                            <td>
                                                @foreach($projeto->users as $user)
                                                    @if(!$loop->last)
                                                        {{$user->name}}
                                                        <br>
                                                    @else
                                                        {{$user->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                @foreach($projeto->users as $user)
                                                    <div class="text-center @if(!$loop->last) border-b border-gray-400 @endif">
                                                        {{$user->tempoGasto($projeto)}}
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>
                                                <?php
                                                    $tempoGasto = $projeto->totTempoGasto();

                                                    $tempoPrevisto = explode(":", $projeto->tempo_previsto);
                                                    $tempoPrevistoP1 = $tempoPrevisto[0];
                                                    $tempoPrevistoP2 = $tempoPrevisto[1];

                                                    $tempo_previsto_minutes = intval($tempoPrevistoP1) * 60 + intval($tempoPrevistoP2);

                                                    if ($tempoGasto < $tempo_previsto_minutes) {
                                                        $bgColor = 'green-300';
                                                    } elseif ($tempoGasto == $tempo_previsto_minutes) {
                                                        $bgColor = 'blue-500';
                                                    } else {
                                                        $bgColor = 'red-300';
                                                    }
                                                ?>
                                                <div class="rounded-full bg-{{$bgColor}} size-6">
                                                    
                                                </div>
                                            </td>
                                            @if(auth()->user() && auth()->user()->tipo == 'admin')
                                            <td>
                                                <div class="flex justify-center space-x-3">
                                                    <a href="{{ route('projetos.edit', $projeto->id) }}" title="Editar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('projetos.destroy', $projeto->id) }}" title="Remover">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Tem a certeza?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a href="{{ route('projetos.create', ['cliente_id' => $cliente->id]) }}" class="bg-darkBlue text-white py-2 px-4 rounded mr-4">
                        Adicionar Projeto
                    </a>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<script>
    var btnPA = document.getElementById('btnProjetosAbertos');
    var btnPC = document.getElementById('btnProjetosConcluidos');

    document.getElementById('btnProjetosAbertos').addEventListener('click', () => {
        btnPA.classList.add('bg-darkBlue');
        btnPA.classList.remove('bg-gray-400');
        btnPC.classList.add('bg-gray-400');
        btnPC.classList.remove('bg-darkBlue');

        document.getElementById('tabelaProjetosAbertos').classList.remove('hidden');
        document.getElementById('tabelaProjetosConcluidos').classList.add('hidden');
    });

    document.getElementById('btnProjetosConcluidos').addEventListener('click', () => {
        btnPC.classList.add('bg-darkBlue');
        btnPC.classList.remove('bg-gray-400');
        btnPA.classList.add('bg-gray-400');
        btnPA.classList.remove('bg-darkBlue');

        document.getElementById('tabelaProjetosConcluidos').classList.remove('hidden');
        document.getElementById('tabelaProjetosAbertos').classList.add('hidden');
    });

    var colaboradorCell = document.getElementsByClassName("colaboradorCell");
    var btnAdicionarColaborador = document.getElementsByClassName("btn-adicionar-colaborador");

    for(var i = 0; i <btnAdicionarColaborador.length;i++){
        btnAdicionarColaborador[i].addEventListener('click', addNewColaboradorField);
    }

    function addNewColaboradorField(){
        var colaboradorCell = document.getElementById("colaboradorCell/" + this.id);
        //$projeto->users->count() != $colaboradores->count()
        colaboradorCell.innerHTML += `
        @if(true)
            <div>
                <form action="{{ route('projetos.colaboradores.adicionar', $projeto->id) }}" method="POST">
                @csrf
                    <div class="flex items-center border-t border-gray-400 p-1">
                        <select name="novoColaboradorId" id={{$projeto->id}} onchange="this.form.submit()" class="w-fit pl-2 pr-8 border-none focus:border-none">
                            <option disabled selected>...</option>
                            @foreach($colaboradores as $colaborador)
                                    <option value="{{$colaborador->id}}" class="w-fit">{{ $colaborador->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        @endif
        `;
    }
</script>