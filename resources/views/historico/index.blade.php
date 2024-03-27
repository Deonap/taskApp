<x-app-layout>
    <div class="container mx-auto px-4">
        <div class="mt-8 mb-4 flex">
            <div>
                <label for="colaborador" class="block text-sm font-medium text-gray-700">Escolha um Colaborador:</label>
                <div class="inline-block relative w-64">
                    <select id="colaborador" name="colaborador" class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($colaboradores as $colaborador)
                            <option value="{{ $colaborador->id }}">{{ $colaborador->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="ml-4">
                <label for="data_semana" class="block text-sm font-medium text-gray-700">Escolha uma Semana:</label>
                <input type="date" id="data_semana" name="data_semana" class="border rounded-md py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </div>
        <div class="container mx-auto px-4">
            <div id="tabelaProjetosAbertos" class="mb-8">
                <div class="relative">
                    <div class="bg-blue-800 text-white p-4 rounded-t-lg">
                        <h3 class="text-lg font-semibold">Projetos Em Desenvolvimento</h3>
                    </div>
                    
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Nº</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Cliente</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Tipo de Cliente</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Nome do Projeto</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Tarefas</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Observações</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Tempo Gasto</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Estado</th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        
        @foreach($projetosEmAberto as $projeto)
        <tr data-id="{{ $projeto->id }}" data-user-id="{{ optional($projeto->users->first())->pivot->user_id }}">
                <td class="border px-3 py-4 whitespace-nowrap border-b">{{ $projeto->users->first()->pivot->prioridade }}</td>
    
                <td class="border px-3 py-4 whitespace-nowrap border-b">{{ $projeto->cliente->nome ?? 'Cliente não especificado' }}</td>
                <td class="border px-3 py-4 whitespace-nowrap border-b">{{ $projeto->tipoCliente->nome ?? 'Tipo não especificado' }}</td>
                <td class="border px-3 py-4 whitespace-nowrap border-b">{{ $projeto->nome }}</td>
                <td class="border px-3 py-4 whitespace-nowrap border-b w-1/4"> <!-- Ajustando a largura da coluna de tarefas -->
                    @foreach($projeto->tarefas as $tarefa)
                        <div>{{ $tarefa->descricao }}</div>
                    @endforeach
                </td>
                <td class="border px-3 py-4 whitespace-nowrap border-b w-1/4"> <!-- Ajustando a largura da coluna de observações -->
                    <textarea class="form-input observacoes border border-gray-300 rounded-md w-full resize-none h-16 overflow-y-auto" rows="3" readonly>{{ $projeto->observacoes }}</textarea>
                </td>
                <td class="border px-3 py-4 whitespace-nowrap border-b w-1/12"> <!-- Reduzindo o tamanho da coluna de tempo gasto -->
                    <input type="number" class="border border-gray-300 rounded-md p-2 w-full" value="{{ $projeto->tempo_gasto }}">
                </td>
                <td class="border px-4 py-2">
                        <div style="background-color: {{ $projeto->estadoProjeto->cor }};" class="w-4 h-4 rounded-full"></div>
                    </td>
                
            </tr>
        @endforeach
    </tbody>
    
                </table>
            </div>
        </div>
        
        
        <div id="tabelaProjetosPendentes" class="mb-8">
            <div class="bg-orange-500 text-white p-4 rounded-t-lg">
                <h3 class="text-lg font-semibold">Projetos Pendentes</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Cliente</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome do Projeto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarefas</th>
                           
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($projetosPendentes as $projeto)
                        <tr data-id="{{ $projeto->id }}">
                            <td class="border px-6 py-4 whitespace-nowrap">{{ $projeto->cliente->nome ?? 'Cliente não especificado' }}</td>
                            <td class="border px-6 py-4 whitespace-nowrap">{{ $projeto->tipoCliente->nome ?? 'Tipo não especificado' }}</td>
                            <td class="border px-6 py-4 whitespace-nowrap">{{ $projeto->nome }}</td>
                            <td class="border px-6 py-4 whitespace-nowrap">
                                @foreach($projeto->tarefas as $tarefa)
                                    <div>{{ $tarefa->descricao }}</div>
                                @endforeach
                            </td>
                            <td class="border px-4 py-2">
                        <div style="background-color: {{ $projeto->estadoProjeto->cor }};" class="w-4 h-4 rounded-full"></div>
                    </td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="tabelaProjetosOutrosColaboradores" class="mb-8">
                <div class="bg-purple-500 text-white p-4 rounded-t-lg">
                    <h3 class="text-lg font-semibold">Projetos com Outros Colaboradores</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Cliente</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome do Projeto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarefas</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Colaboradores</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                        @if(isset($projetosComOutros) && count($projetosComOutros) > 0)
    @foreach($projetosComOutros as $projeto)
        <tr data-id="{{ $projeto->id }}">
                            <td class="border px-6 py-4 whitespace-nowrap">{{ $projeto->cliente->nome ?? 'Cliente não especificado' }}</td>
                            <td class="border px-6 py-4 whitespace-nowrap">{{ $projeto->tipoCliente->nome ?? 'Tipo não especificado' }}</td>
                            <td class="border px-6 py-4 whitespace-nowrap">{{ $projeto->nome }}</td>
                            <td class="border px-6 py-4 whitespace-nowrap">
                                @foreach($projeto->tarefas as $tarefa)
                                    <div>{{ $tarefa->descricao }}</div>
                                @endforeach
                            </td>
                            <td class="border px-4 py-2">
                        <div style="background-color: {{ $projeto->estadoProjeto->cor }};" class="w-4 h-4 rounded-full"></div>
                    </td>
                            <td class="border px-6 py-4 whitespace-nowrap">
                                @foreach($projeto->users as $user)
                                    <div>{{ $user->name }}</div>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                        @else
    
@endif
                    </tbody>
                </table>
            </div>
            
           
    </div>

    <script>
        
    document.getElementById('colaborador').addEventListener('change', atualizarTabelas);
    document.getElementById('data_semana').addEventListener('change', atualizarTabelas);





    function atualizarTabelas() {
    var colaboradorId = document.getElementById('colaborador').value;
    var dataSemana = document.getElementById('data_semana').value;

    if (!colaboradorId || !dataSemana) return; // Não fazer nada se o colaborador ou a data não estiverem selecionados

    var inicioSemana = new Date(dataSemana);
    inicioSemana.setDate(inicioSemana.getDate() - inicioSemana.getDay() + 1);
    var fimSemana = new Date(inicioSemana);
    fimSemana.setDate(fimSemana.getDate() + 6);

    var inicioSemanaFormatado = inicioSemana.toISOString().split('T')[0];
    var fimSemanaFormatado = fimSemana.toISOString().split('T')[0];

    fetch(`/api/historico/projetos-em-aberto?colaborador_id=${colaboradorId}&inicio_semana=${inicioSemanaFormatado}&fim_semana=${fimSemanaFormatado}`)
        .then(response => response.json())
        .then(data => atualizarTabelaProjetos('tabelaProjetosAbertos', data))
        .catch(error => console.error('Erro ao buscar projetos em aberto:', error));

    // Fetch para projetos pendentes
    fetch(`/api/historico/projetos-pendentes?colaborador_id=${colaboradorId}&inicio_semana=${inicioSemanaFormatado}&fim_semana=${fimSemanaFormatado}`)
        .then(response => response.json())
        .then(data => {
        // Se a resposta não for um array, converte em um array
        if (!Array.isArray(data)) {
            data = [data];
        }
        atualizarTabelaProjetosPendentes(data);
    })
        .catch(error => console.error('Erro ao buscar projetos pendentes:', error));

    // Fetch para projetos com outros colaboradores
    fetch(`/api/historico/projetos-com-outros?colaborador_id=${colaboradorId}&inicio_semana=${inicioSemanaFormatado}&fim_semana=${fimSemanaFormatado}`)
        .then(response => response.json())
        .then(data => atualizarTabelaProjetosOutrosColaboradores('tabelaProjetosOutrosColaboradores',data))
        .catch(error => console.error('Erro ao buscar projetos com outros colaboradores:', error));
}
function atualizarTabelaProjetos(idTabela, projetos) {
    var tbody = document.querySelector(`#${idTabela} tbody`);
    tbody.innerHTML = ''; // Limpa o conteúdo atual da tabela
    
    projetos.forEach((projeto, index) => {
        var linha = tbody.insertRow(); // Insere uma nova linha na tabela

        // Adiciona borda a cada célula
        for (let i = 0; i < 8; i++) {
            var celula = linha.insertCell();
            celula.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b'); // Adiciona classes de estilo
        }

        // Coluna de Número (Prioridade)
        linha.cells[0].innerHTML = projeto.users && projeto.users.length > 0 ? projeto.users[0].pivot.prioridade : 'N/A';

        // Coluna de Cliente
        linha.cells[1].innerHTML = projeto.cliente && projeto.cliente.nome ? projeto.cliente.nome : 'Cliente não especificado';

        // Coluna de Tipo de Cliente
        linha.cells[2].innerHTML = projeto.tipo_cliente && projeto.tipo_cliente.nome ? projeto.tipo_cliente.nome : 'Tipo não especificado';

        // Coluna de Nome do Projeto
        linha.cells[3].innerHTML = projeto.nome;

        // Coluna de Tarefas
        linha.cells[4].innerHTML = projeto.tarefas.map(tarefa => `<div>${tarefa.descricao}</div>`).join("");

        // Coluna de Observações
        var celulaObservacoes = linha.cells[5];
        var textareaObservacoes = document.createElement('textarea');
        textareaObservacoes.classList.add('form-input', 'observacoes', 'border', 'border-gray-300', 'rounded-md', 'w-full', 'resize-none', 'h-16', 'overflow-y-auto');
        textareaObservacoes.setAttribute('rows', '3');
        textareaObservacoes.readOnly = true;
        textareaObservacoes.value = projeto.observacoes || '';
        celulaObservacoes.appendChild(textareaObservacoes);

        // Coluna de Tempo Gasto
        var celulaTempoGasto = linha.cells[6];
        var inputTempoGasto = document.createElement('input');
        inputTempoGasto.type = 'number';
        inputTempoGasto.classList.add('border', 'border-gray-300', 'rounded-md', 'p-2', 'w-full');
        inputTempoGasto.value = projeto.tempo_gasto || '';
        celulaTempoGasto.appendChild(inputTempoGasto);

        // Coluna de Estado do Projeto
        var celulaEstadoProjeto = linha.cells[7];
        celulaEstadoProjeto.innerHTML = projeto.estado_projeto ? 
            `<div style="background-color: ${projeto.estado_projeto.cor};" class="w-4 h-4 rounded-full"></div>` :
            'Estado não especificado';
    });
}

    


    function atualizarTabelaProjetosPendentes(projetos) {
    

    // Se não for um array, não prosseguir
    if (!Array.isArray(projetos)) {
        console.error('Erro: a entrada não é um array.');
        return;
    }

    var tbody = document.querySelector('#tabelaProjetosPendentes tbody');
    tbody.innerHTML = ''; // Limpa o conteúdo atual da tabela

    projetos.forEach((projeto, index) => {
        var linha = tbody.insertRow(); // Insere uma nova linha na tabela

        // Adiciona borda a cada célula
        for (let i = 0; i < 5; i++) {
            var celula = linha.insertCell();
            celula.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
        }

        // Coluna de Cliente
        linha.cells[0].innerHTML = projeto.cliente && projeto.cliente.nome ? projeto.cliente.nome : 'Cliente não especificado';

        // Coluna de Tipo de Cliente
        linha.cells[1].innerHTML = projeto.tipo_cliente && projeto.tipo_cliente.nome ? projeto.tipo_cliente.nome : 'Tipo não especificado';

        // Coluna de Nome do Projeto
        linha.cells[2].innerHTML = projeto.nome;

        // Coluna de Tarefas
        linha.cells[3].innerHTML = projeto.tarefas.map(tarefa => `<div>${tarefa.descricao}</div>`).join("");

        // Coluna de Estado do Projeto
        linha.cells[4].innerHTML = projeto.estado_projeto ? 
            `<div style="background-color: ${projeto.estado_projeto.cor};" class="w-4 h-4 rounded-full"></div>` :
            'Estado não especificado';
    });
}


function atualizarTabelaProjetosOutrosColaboradores(projetos) {
    var tbody = document.querySelector('#tabelaProjetosOutrosColaboradores tbody');
    tbody.innerHTML = '';

    projetos.forEach(projeto => {
        // Verifica se o projeto tem mais de um colaborador
        if (projeto.users && projeto.users.length > 1) {
            var linha = tbody.insertRow();

            linha.insertCell().innerHTML = projeto.cliente && projeto.cliente.nome ? projeto.cliente.nome : 'Cliente não especificado';
            linha.insertCell().innerHTML = projeto.tipo_cliente && projeto.tipo_cliente.nome ? projeto.tipo_cliente.nome : 'Tipo não especificado';
            linha.insertCell().innerHTML = projeto.nome;
            linha.insertCell().innerHTML = projeto.tarefas.map(tarefa => `<div>${tarefa.descricao}</div>`).join("");
            linha.insertCell().innerHTML = projeto.estado_projeto ? projeto.estado_projeto.nome : 'Estado não especificado';


            // Lista os nomes dos colaboradores
            var colaboradores = projeto.users.map(user => user.name).join(", ");
            linha.insertCell().innerHTML = colaboradores;
        }
    });
}




</script>

    
</x-app-layout>