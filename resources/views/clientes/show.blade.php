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
        </style>
    </head>
    <body>
        <x-app-layout>
            <div class="content-margin">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden w-full md:w-2/3 lg:w-1/2 mx-auto mb-20">
                    <div class="px-6 py-8">
                        <h2 class="text-2xl leading-8 font-bold text-gray-900 text-center mb-4">{{ $cliente->nome }}</h2>
                        <div class="text-sm text-gray-600 text-center">
                            <p class="mb-2"><strong>Email:</strong> {{ $cliente->email }}</p>
                            <p class="mb-2"><strong>Telefone:</strong> {{ $cliente->telefone }}</p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <a href="" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full transition duration-300">Editar</a>
                            <a href="" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full ml-4 transition duration-300">Excluir</a>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <button id="btnProjetosAbertos" class="bg-blue-500 text-white py-2 px-4 rounded mr-4">
                        Projetos Abertos/Pendentes
                    </button>
                    <button id="btnProjetosConcluidos" class="bg-green-500 text-white py-2 px-4 rounded">
                        Projetos Concluídos
                    </button>
                </div>

                <div id="tabelaProjetosAbertos" class="bg-white p-4 rounded shadow mb-8">
                    <h3 class="text-lg font-semibold mb-4">Projetos Abertos/Pendentes</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo de Cliente
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome do Projeto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Notas Iniciais
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tempo Previsto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Colaboradores
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tempo Gasto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($projetosAbertos as $projeto)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $projeto->tipoCliente->nome }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $projeto->nome }}
                                    </td>
                                    {{-- <td class="px-6 py-4 whitespace-nowrap">@foreach($projeto->tarefas as $tarefa)
                                        {{ $tarefa->descricao }}
                                        @if(!$loop->last), @endif
                                        @endforeach</td> --}}

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $projeto->tempo_previsto }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach($projeto->users as $user)
                                            <div class="flex items-center justify-between mb-2">
                                                {{ $user->name }}
                                                <button class="btn-escolher-colaborador" data-user-id="{{ $user->id }}" data-projeto-id="{{ $projeto->id }}">
                                                    ⬇️
                                                </button>
                                            </div>
                                            <div id="dropdown-escolher-colaborador" class="hidden">
                                                <select class="seletor-colaborador">
                                                    @foreach($colaboradores as $colaborador)
                                                        <option value="{{ $colaborador->id }}">{{ $colaborador->nome }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="confirmar-escolha-colaborador">Confirmar</button>
                                            </div>
                                            <button class="btn-adicionar-colaborador" data-projeto-id="{{ $projeto->id }}">
                                                +
                                            </button>
                                            <select id="dropdownNovoColaborador" class="hidden">
                                                <option value="{{ $colaborador->id }}">{{ $colaborador->nome }}</option>
                                            </select>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach($projeto->users as $user)
                                            {{ $user->name }} - Tempo Gasto: {{ $user->tempoGasto }} {{$user->tempoGasto != 0? 'horas' : ''}}
                                            @if(!$loop->last)
                                                <br>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                        <a href="{{ route('projetos.edit', $projeto->id) }}"
                                            class="text-blue-500 hover:text-blue-700 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <div id="tabelaProjetosConcluidos" class="bg-white p-4 rounded shadow mb-8 hidden">
                    <h3 class="text-lg font-semibold mb-4">Projetos Concluídos</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo de Cliente
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome do Projeto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Notas Iniciais
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tempo Previsto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Colaboradores
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tempo Gasto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($projetosConcluidos as $projeto)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->tipoCliente->nome }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->nome }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->tempo_previsto }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @foreach($projeto->users as $user)
                                                @if(!$loop->last)
                                                    {{$user->name}},
                                                @else
                                                    {{$user->name}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $projeto->tempo_gasto }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('projetos.edit', $projeto->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                                Editar
                                            </a>
                                            <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{{ route('projetos.create', ['cliente_id' => $cliente->id]) }}" class="bg-blue-500 text-white py-2 px-4 rounded mr-4">
                    Adicionar Projeto
                </a>
            </div>
        </x-app-layout>
    </body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<script>
    document.getElementById('btnProjetosAbertos').addEventListener('click', () => {
        document.getElementById('tabelaProjetosAbertos').classList.remove('hidden');
        document.getElementById('tabelaProjetosConcluidos').classList.add('hidden');
    });

    document.getElementById('btnProjetosConcluidos').addEventListener('click', () => {
        document.getElementById('tabelaProjetosConcluidos').classList.remove('hidden');
        document.getElementById('tabelaProjetosAbertos').classList.add('hidden');
    });




    $(document).ready(function () {
        // Evento de clique para mostrar o dropdown
        $('.btn-escolher-colaborador').on('click', function () {
            // Obtenha a posição do botão para posicionar o dropdown
            var btnOffset = $(this).offset();

            // Posicione o dropdown próximo ao botão e exiba-o
            $('#dropdown-escolher-colaborador')
                .css({ top: btnOffset.top, left: btnOffset.left, position: 'absolute' })
                .removeClass('hidden');

            // Defina o usuário atual e o projetoId no dropdown para uso posterior
            $('#dropdown-escolher-colaborador')
                .data('current-user-id', $(this).data('user-id'))
                .data('projeto-id', $(this).data('projeto-id'));
        });

        // Evento de clique para confirmar a escolha de um novo colaborador
        $('.confirmar-escolha-colaborador').on('click', function () {
            var userId = $('#dropdown-escolher-colaborador').data('current-user-id');
            var projetoId = $('#dropdown-escolher-colaborador').data('projeto-id');
            var novoColaboradorId = $('.seletor-colaborador').val();

            $.ajax({
                url: '/projetos/' + projetoId + '/colaboradores/atualizar', // Endpoint que você configurou no Laravel
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // Token CSRF para segurança
                    projetoId: projetoId,
                    userId: userId,
                    novoColaboradorId: novoColaboradorId
                },
                success: function (response) {
                    // Atualize a interface do usuário conforme necessário
                    alert('Colaborador atualizado com sucesso!');
                    // Aqui você pode querer atualizar a lista de colaboradores na view
                },
                error: function (error) {
                    // Trate os erros aqui
                    alert('Erro ao alterar colaborador.');
                }
            });

            // Esconda o dropdown após a seleção
            $('#dropdown-escolher-colaborador').addClass('hidden');
        });

        // Evento de clique para adicionar um novo colaborador
        $('.btn-adicionar-colaborador').on('click', function () {
            var projetoId = $(this).data('projeto-id');
            var novoColaboradorId = $('#dropdownNovoColaborador').val();

            console.log("Projeto ID: " + projetoId); // Debug
            console.log("Novo Colaborador ID: " + novoColaboradorId); // Debug

            if (!novoColaboradorId) {
                alert('Por favor, selecione um colaborador.');
                return;
            }

            $.ajax({
                url: '/projetos/' + projetoId + '/colaboradores/adicionar',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    novoColaboradorId: novoColaboradorId
                },
                success: function (response) {
                    alert('Colaborador adicionado com sucesso!');
                    // Atualizações adicionais na UI
                },
                error: function (error) {
                    alert('Erro ao adicionar colaborador.');
                }
            });
        });
    });
</script>