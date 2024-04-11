<html lang="en">
    <head>
        <style>
            th{
                /* px-3 py-1 text-left font-bold text-black uppercase tracking-wider border-b */
                padding-left: 0.75rem;
                padding-right: 0.75rem;
                padding-bottom: 0.5rem;
                padding-top: 0.5rem;
                text-align: left;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-bottom-width: 1px;
                font-size: 14px;
            }
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
        </style>
    </head>
    <body>
        <x-app-layout>
            <div class="flex-1 m-20">
                <div>
                    <div class="flex items-center text-darkBlue">
                        <h2 class="text-xl font-black">
                            Histórico
                        </h2>
                    </div>
                    <div class="flex justify-between items-center my-4">
                        <div class="flex justify-between mb-4">
                            <div class="flex items-center">
                                <label for="colaborador" class="block text-sm font-medium "></label>
                                <div class="relative">
                                    <select id="colaborador" name="colaborador" class="appearance-none border rounded-md w-48 py-2 pl-3 pr-10 leading-tight focus:outline-none focus:shadow-outline text-white bg-darkBlue">
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
                            <div class="flex-none bg-[#921111]" style="width: 70%; height: 40px; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: start; align-items: center;">
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
                                            Tipo de Cliente
                                        </th>
                                        <th scope="col">
                                            Nome do Projeto
                                        </th>
                                        <th scope="col">
                                            Tarefas
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
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($projetosEmAberto as $projeto)
                                        <tr data-id="{{ $projeto->id }}" data-user-id="{{ optional($projeto->users->first())->pivot->user_id }}">
                                            <td class="border px-3 py-4 whitespace-nowrap border-b">
                                                {{ $projeto->users->first()->pivot->prioridade }}
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
                                            <td class="border px-3 py-4 whitespace-nowrap border-b w-1/4"> <!-- Ajustando a largura da coluna de tarefas -->
                                                @foreach($projeto->tarefas as $tarefa)
                                                    <div>{{ $tarefa->descricao }}</div>
                                                @endforeach
                                            </td>
                                            <td class="border px-3 py-4 whitespace-nowrap border-b w-1/4"> <!-- Ajustando a largura da coluna de observações -->
                                                <input value='{{$projeto->notas_iniciais}}' title='{{$projeto->notas_iniciais}}' onChange='#' class="border-none form-input bg-transparent w-full resize-none h-16 text-start" name='observacoes' autocomplete='off'/>

                                            </td>
                                            <td class="border px-3 py-4 whitespace-nowrap border-b w-1/12"> <!-- Reduzindo o tamanho da coluna de tempo gasto -->
                                                <input type="text" class="border border-gray-300 rounded-md p-2 w-full" value="{{ $projeto->tempo_gasto }}">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <div style="background-color: {{ $projeto->estadoProjeto->cor }};" class="size-6 m-auto rounded-full"></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="tabelaProjetosPendentes" class="mb-8">
                        <div class="relative mb-4">
                            <div class="flex-none bg-[#311fbd] text-white w-[70%] h-[40px] p-[1rem] flex items-center" style="border-radius: 0.2rem; justify-content: start;">
                                <h3 class="text-lg font-semibold">Projetos Pendentes</h3>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-[#d5d4d5]">
                                    <tr>
                                        <th scope="col">
                                            Cliente
                                        </th>
                                        <th scope="col">
                                            Tipo de Cliente
                                        </th>
                                        <th scope="col">
                                            Nome do Projeto
                                        </th>
                                        <th scope="col">
                                            Tarefas
                                        </th>
                                        <th scope="col">
                                            Estado
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
                                                {{ $projeto->tipoCliente->nome ?? 'Tipo não especificado' }}
                                            </td>
                                            <td class="border px-6 py-4 whitespace-nowrap">
                                                {{ $projeto->nome }}
                                            </td>
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
                    </div>
                    <div id="tabelaProjetosOutrosColaboradores" class="mb-8">
                        <div class="relative mb-4">
                            <div class="flex-none text-white" style="width: 70%; height: 40px; background-color: #641885; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: start; align-items: center;">
                                <h3 class="text-lg font-semibold">Projetos com Outros Colaboradores</h3>
                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#d5d4d5]">
                                <tr>
                                    <th scope="col">
                                        Cliente
                                    </th>
                                    <th scope="col">
                                        Tipo de Cliente
                                    </th>
                                    <th scope="col">
                                        Nome do Projeto
                                    </th>
                                    <th scope="col">
                                        Tarefas
                                    </th>
                                    <th scope="col">
                                        Estado
                                    </th>
                                    <th scope="col">
                                        Colaboradores
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($projetosComOutros) && count($projetosComOutros) > 0)
                                    @foreach($projetosComOutros as $projeto)
                                        <tr data-id="{{ $projeto->id }}">
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
                                @endif
                            </tbody>
                        </table>
                    </div>
                
                </div>
            </div>
        </x-app-layout>
    </body>
</html>
<script>
    
    document.getElementById('colaborador').addEventListener('change', atualizarTabelas);
    document.getElementById('data_semana').addEventListener('change', atualizarTabelas);

    function atualizarTabelas() {
        var colaboradorId = document.getElementById('colaborador').value;
        var dataSemana = document.getElementById('data_semana').value;

        if (!colaboradorId || !dataSemana) {
            return;
        } // Não fazer nada se o colaborador ou a data não estiverem selecionados

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
        }).catch(error => console.error('Erro ao buscar projetos pendentes:', error));

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
            inputTempoGasto.type = 'text';
            inputTempoGasto.classList.add('border', 'border-gray-300', 'rounded-md', 'p-2', 'w-full');
            //inputTempoGasto.value = projeto.tempo_gasto || '00:00';
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


    document.getElementById('toggleFerias').addEventListener('change',function(){
        document.querySelector('#tabelaProjetosAbertos tbody').classList.toggle('disabledTable');
    });

</script>

    