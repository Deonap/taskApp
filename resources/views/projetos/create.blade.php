<html lang="en">
    <head>
        <style>
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }
        
            .card {
                background-color: #f9f9f9;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                padding: 30px;
            }
        
            .form-group {
                margin-bottom: 25px;
            }
        
            .form-label {
                display: block;
                font-size: 16px;
                color: #333;
                font-weight: 600;
                margin-bottom: 8px;
            }
        
            .form-input,
            .form-select {
                width: 100%;
                padding: 12px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
        
            .btn {
                padding: 12px 24px;
                font-size: 16px;
                font-weight: 600;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
        
            .btn-primary {
                background-color: #4CAF50;
            }
        
            .btn-primary:hover {
                background-color: #45a049;
            }
        
            .btn-danger {
                background-color: #f44336;
            }
        
            .btn-danger:hover {
                background-color: #da190b;
            }
            
            .remover-tarefa {
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <x-app-layout>
            <div>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center text-darkBlue">
                        <h2 class="text-xl font-black ">
                            Projeto >
                        </h2>
                        <div class="ml-2">
                            Adicionar
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <form method="POST" action="{{ route('projetos.store') }}">
                        @csrf

                        @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                        @endif

                        <div class="bg-white shadow-md rounded px-5 py-6 mb-4 border w-fit">
                            <div class="mb-4 flex items-center space-x-3 w-full">
                                <div class="flex items-center space-x-3 w-1/2">
                                    <label for="cliente_id">
                                        Cliente
                                    </label>
                                    <select name="cliente_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        @foreach($clientes as $cliente)
                                            <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-center space-x-3 w-1/2">    
                                    <label for="tipo_cliente_id">
                                        Tipo
                                    </label>
                                    <select name="tipo_cliente_id" class="shadow appearance-none border rounded w-full py-2 pl-3 pr-8 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="tipo_cliente_id" required>
                                        <option value="" class="text-start" selected disabled>Tipo de Cliente</option>
                                        @foreach($tiposClientes as $tipoCliente)
                                            <option value="{{ $tipoCliente->id }}">{{ $tipoCliente->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4 flex items-center space-x-3 w-full">
                                <div class="flex items-center space-x-3 w-full">
                                    <label for="nome">
                                        Nome
                                    </label>
                                    <input id="nome" type="text" class="shadow appearance-none border rounded w-full py-2 pl-3 pr-8 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nome" placeholder="Nome do projeto" required>
                                </div>
                            </div>
                            <div class="mb-4 flex items-center space-x-3 w-full">
                                <div class="flex items-center space-x-3 w-full">
                                    <label for="estado_projeto_id" >
                                        Estado
                                    </label>
                                    <select name="estado_projeto_id" class="shadow appearance-none border rounded py-2 pl-3 pr-8 w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="tipo_cliente_id" name="estado_projeto_id" required>
                                        <option value="" selected disabled>Selecione o Estado do Projeto</option>
                                        @foreach($estadosProjetos as $estadoProjeto)
                                            <option value="{{ $estadoProjeto->id }}">{{ $estadoProjeto->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4 flex items-center space-x-3 w-full">
                                <div class="flex items-center space-x-3 w-full">
                                    <label for="tarefas">
                                        Tarefas
                                    </label>
                                    <div id="tarefas-container" class="w-full">
                                        <div class="tarefa-row flex items-center space-x-3 mb-2">
                                            <input type="text" name="tarefas[]" class="shadow appearance-none border rounded w-full py-2 pl-3 pr-8 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nome da tarefa" required>
                                            <button type="button" id="adicionar-tarefa" class="bg-darkBlue whitespace-nowrap max-h-[150px] hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                                Adicionar Tarefa
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="mb-4 flex items-center space-x-3 w-full">
                                <div class="flex items-center space-x-3 w-full">
                                    <label for="notas_iniciais" class="whitespace-nowrap"> 
                                        Notas Iniciais
                                    </label>
                                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="notas_iniciais" placeholder="Digite as notas iniciais" name="notas_iniciais"></textarea>
                                </div>
                            </div>

                            <div class="mb-4 flex items-center space-x-3 w-full">
                                <div class="flex items-center space-x-3 w-full">
                                    <label for="tempo_previsto" class="whitespace-nowrap">
                                        Tempo Previsto
                                    </label>
                                    <input id="tempo_previsto" type="text" class="form-input" name="tempo_previsto" required>
                                    @error('tempo_previsto')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 flex items-center space-x-3 w-full">
                                <div class="flex items-center space-x-3 w-full">
                                    <div>
                                        Colaboradores:
                                    </div>
                                    <div class="border shadow-md px-4 py-2 border-gray-300 w-fit h-fit max-h-[150px] overflow-y-scroll flex flex-wrap space-y-1">
                                        @foreach($users as $user)
                                            @if($user->tipo == "colaborador")
                                                <div class="w-1/2 flex items-center">
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="users[]" value="{{$user->id}}">
                                                        <div class="ml-2">
                                                            {{$user->name}}
                                                        </div>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="flex flex-row-reverse mb-4 px-8">
                            <button type="submit" class="bg-darkBlue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Adicionar Projeto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const podeRemover = @json(auth()->user()->tipo == 'admin');
        const adicionarTarefaBtn = document.getElementById('adicionar-tarefa');
        const tarefasContainer = document.getElementById('tarefas-container');

        adicionarTarefaBtn.addEventListener('click', function() {
           
            const novaTarefaRow = document.createElement('div');
            novaTarefaRow.classList.add('tarefa-row', 'mb-2');
            novaTarefaRow.innerHTML = `
            <div class="tarefa-row flex items-center space-x-3">
                <input type="text" name="tarefas[]" class="shadow appearance-none border rounded w-full py-2 pl-3 pr-8 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nome da tarefa" required>
                <button type="button" class="bg-red-900 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ${!podeRemover ? 'invisible' : ''}">
                    Remover
                </button>
            </div>
            `;
            tarefasContainer.appendChild(novaTarefaRow);
        });

        tarefasContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('remover-tarefa')) {
                event.target.parentElement.remove();
            }
        });
    });
</script>