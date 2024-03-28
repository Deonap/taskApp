<x-app-layout>
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
    
    <div class="container">
        <div class="card">
            <h2 class="text-2xl font-semibold mb-6 text-center">Adicionar Novo Projeto</h2>
            
            <form method="POST" action="{{ route('projetos.store') }}">
                @csrf
    
                <div class="form-group">
                    <label for="cliente_id" class="form-label">Cliente:</label>
                    <select name="cliente_id" id="cliente_id" class="form-select">
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="tipo_cliente_id" class="form-label">Tipo de Cliente:</label>
                    <select id="tipo_cliente_id" class="form-select" name="tipo_cliente_id" required>
                        <option value="">Selecione o Tipo de Cliente</option>
                        @foreach($tiposClientes as $tipoCliente)
                            <option value="{{ $tipoCliente->id }}">{{ $tipoCliente->nome }}</option>
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="nome" class="form-label">Nome do Projeto:</label>
                    <input id="nome" type="text" class="form-input" name="nome" required autofocus>
                </div>
    
                <div class="form-group">
                    <label for="estado_projeto_id" class="form-label">Estado do Projeto:</label>
                    <select id="estado_projeto_id" class="form-select" name="estado_projeto_id" required>
                        <option value="">Selecione o Estado do Projeto</option>
                        @foreach($estadosProjetos as $estadoProjeto)
                            <option value="{{ $estadoProjeto->id }}">{{ $estadoProjeto->nome }}</option>
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="tarefas" class="form-label">Tarefas:</label>
                    <div id="tarefas-container">
                        <div class="tarefa-row mb-2">
                            <input type="text" name="tarefas[]" class="form-input" placeholder="Descrição da Tarefa" required>
                        </div>
                    </div>
                    <button type="button" id="adicionar-tarefa" class="btn btn-primary mt-2">Adicionar Tarefa</button>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700  font-bold mb-2" for="notas_iniciais">
                        Notas Iniciais
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="notas_iniciais" placeholder="Digite as notas iniciais" name="notas_iniciais"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="tempo_previsto" class="form-label">Tempo Previsto:</label>
                    <input id="tempo_previsto" type="number" class="form-input" name="tempo_previsto" required>
                    @error('tempo_previsto')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
    
                <div class="form-group">
                    <div>
                        Colaboradores:
                    </div>
                    <div class="border shadow-md px-4 py-2 border-gray-300 w-fit h-fit max-h-[150px] overflow-y-scroll flex flex-wrap space-y-1">
                        @foreach($users as $user)
                            <div class="w-1/2 flex items-center">
                                <label class="flex items-center">
                                    <input type="checkbox" name="users[]" value="{{$user->id}}">
                                    <div class="ml-2">
                                        {{$user->name}}
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
    
                <div class="flex justify-center">
                    <button type="submit" class="btn btn-primary">
                        Adicionar Projeto
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
                <input type="text" name="tarefas[]" class="form-input" placeholder="Descrição da Tarefa" required>
                ${podeRemover ? '<button type="button" class="btn btn-danger remover-tarefa ml-2">Remover</button>' : ''}
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
