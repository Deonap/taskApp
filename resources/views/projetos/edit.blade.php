<x-app-layout>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
    
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
    
        .form-group {
            margin-bottom: 20px;
        }
    
        .form-label {
            display: block;
            font-size: 16px;
            color: #333;
            font-weight: 500;
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
            padding: 10px 20px;
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
            font-size: 14px;
        }
    </style>
    
    <div class="container">
        <div class="card">
            <h2 class="text-2xl font-semibold mb-6">Editar Projeto</h2>
            <form method="POST" action="{{ route('projetos.update', ['projeto' => $projeto->id]) }}">
                @csrf
                @method('PUT')
    
                <div class="form-group">
                    <label for="cliente_id" class="form-label">Cliente:</label>
                    <select name="cliente_id" id="cliente_id" class="form-select">
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ $projeto->cliente_id == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="tipo_cliente_id" class="form-label">Tipo de Cliente:</label>
                    <select id="tipo_cliente_id" class="form-select" name="tipo_cliente_id" required>
                        <option value="">Selecione o Tipo de Cliente</option>
                        @foreach($tiposClientes as $tipoCliente)
                            <option value="{{ $tipoCliente->id }}" {{ $projeto->tipo_cliente_id == $tipoCliente->id ? 'selected' : '' }}>
                                {{ $tipoCliente->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
            
    
                <div class="form-group">
                    <label for="nome" class="form-label">Nome do Projeto:</label>
                    <input id="nome" type="text" name="nome" value="{{ $projeto->nome }}" class="form-input" required>
                </div>
    
                <div class="form-group">
                    <label for="estado_projeto_id" class="form-label">Estado do Projeto:</label>
                    <select id="estado_projeto_id" class="form-select" name="estado_projeto_id" required>
                        <option value="">Selecione o Estado do Projeto</option>
                        @foreach($estadosProjetos as $estadoProjeto)
                            <option value="{{ $estadoProjeto->id }}" {{ $projeto->estado_projeto_id == $estadoProjeto->id ? 'selected' : '' }}>
                                {{ $estadoProjeto->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
    
                <div class="form-group">
                    <label for="tarefas" class="form-label">Tarefas:</label>
                    <div id="tarefas-container">
                        @foreach($projeto->tarefas as $tarefa)
                            <div class="tarefa-row mb-2">
                                <input type="text" name="tarefas[{{ $tarefa->id }}]" class="form-input" placeholder="Descrição da Tarefa" value="{{ $tarefa->descricao }}" required>
                                @if(auth()->user()->tipo == 'admin')
                                <button type="button" class="btn btn-danger remover-tarefa ml-2">Remover</button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="adicionar-tarefa" class="btn btn-primary mt-2">Adicionar Tarefa</button>
                </div>
                
                
                <div class="form-group">
                    <label for="tempo_previsto" class="form-label">Tempo Previsto:</label>
                    <input id="tempo_previsto" type="text" name="tempo_previsto" class="form-input" value="{{ $projeto->tempo_previsto }}" required>
                </div>
                
                
                <div class="form-group">
                    <div>
                        Colaboradores:
                    </div>
                    <div class="border shadow-md px-4 py-2 border-gray-300 w-fit h-fit max-h-[150px] overflow-y-scroll flex flex-wrap space-y-1">
                        @foreach($users as $user)
                            @if($user->tipo == "colaborador")
                                <div class="w-1/2 flex items-center">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="users[]" value="{{$user->id}}" {{in_array($user->id, $projeto->users->pluck('id')->toArray())? 'checked' : ''}}>
                                        <div class="ml-2">
                                            {{$user->name}}
                                        </div>
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                    <!-- Campo de Observações -->
                <div class="form-group">
                    <label for="observacoes" class="form-label">Observações:</label>
                    <textarea id="observacoes" name="observacoes" class="form-input" rows="4">{{ $projeto->observacoes }}</textarea>
                </div>
    
                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-darkBlue text-white py-2 px-4 rounded mr-4">
                        Atualizar Projeto
                    </button>
                </div>
            </form>
        </div>
    </div>
    
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
                    <button type="button" class="bg-darkBlue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ${!podeRemover ? 'invisible' : ''}">
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
    
    
</x-app-layout>
