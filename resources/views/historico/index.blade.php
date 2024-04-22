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
                                <label for="colaborador"></label>
                                <div class="relative">
                                    <select id="colaborador" name="colaborador" class="appearance-none border rounded-md w-48 py-2 pl-3 pr-10 leading-tight focus:outline-none focus:shadow-outline text-white bg-darkBlue">
                                        @foreach($colaboradores as $colaborador)
                                            <option value="{{ $colaborador->id }}">{{ $colaborador->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="ml-4">
                                    <label for="data_semana"></label>
                                    <input type="date" id="data_semana" name="data_semana" class="border rounded-md py-2 px-3"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div id="tabelaProjetosAbertos" class="mb-8">
                        <div class="flex items-center text-white  mb-4" style="width: 100%;">
                            <div class="flex-none" style="background-color: {{$corDesenvolvimento}}; width: 70%; height: 40px; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: start; align-items: center;">
                                <h3 class="text-lg font-semibold">Projetos Em Desenvolvimento</h3>
                            </div>
                            <div class="flex-none ml-4" style="width: 29%; height: 30px; background-color: #f0f1f0; color: black; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: center; align-items: center;">
                                <p id="selectedDateLabel" class="text-sm font-medium">
                                    Data da Semana: {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }} - {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="">
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
                                        <th scope="col">
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
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
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
                        <div>
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
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
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
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
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

    document.getElementById('data_semana').addEventListener('change', function(){
        var selectedDateLabel = document.getElementById('selectedDateLabel');
        var date = new Date(this.value);
        var startDate = new Date(date);
        var endDate = new Date(date);
        startDate.setDate(startDate.getDate() - startDate.getDay() + 1); // Get Monday of the week
        endDate.setDate(endDate.getDate() - endDate.getDay() + 7); // Get Sunday of the week
        var formattedStartDate = formatDate(startDate);
        var formattedEndDate = formatDate(endDate);
        selectedDateLabel.textContent = "Data da Semana: " + formattedStartDate + " - " + formattedEndDate;
    });

    function formatDate(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        return (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + year;
    }

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
            .then(data => atualizarTabelaProjetosOutrosColaboradores(data))
            .catch(error => console.error('Erro ao buscar projetos com outros colaboradores:', error));
    }

    function atualizarTabelaProjetos(idTabela, projetos) {
        var tbody = document.querySelector(`#${idTabela} tbody`);
        tbody.innerHTML = ''; // Limpa o conteúdo atual da tabela

        projetos.forEach((projeto, index) => {
            var linha = tbody.insertRow(); // Insere uma nova linha na tabela
            var userId = document.getElementById('colaborador').value;
            // Adiciona borda a cada célula
            for (let i = 0; i < 8; i++) {
                var celula = linha.insertCell();
                celula.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b'); // Adiciona classes de estilo
            }


            var u;
            for(var i = 0; i < projeto.users.length; i++){
                if(projeto.users[i].id == userId){
                    u = projeto.users[i];
                }
            }
            // Coluna de Número (Prioridade)
            linha.cells[0].innerHTML = u.pivot.prioridade;

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
            textareaObservacoes.value = u.pivot.observacoes || '';
            celulaObservacoes.appendChild(textareaObservacoes);

            // Coluna de Tempo Gasto
            var celulaTempoGasto = linha.cells[6];

            var div = document.createElement('div');
            var tempoGasto = u.pivot.tempo_gasto;
            div.innerHTML = 
            `
                <input value='${tempoGasto}' disabled class="border-none bg-transparent rounded-md p-2 w-full tempo-gasto text-center" autocomplete="off" pattern="[0-9]{0,4}:[0-5][0-9]" type="text" placeholder="${tempoGasto}" name="tempoGasto">
            `;
            celulaTempoGasto.appendChild(div);


            // Coluna de Estado do Projeto
            var celulaEstadoProjeto = linha.cells[7];
            celulaEstadoProjeto.innerHTML = projeto.estado_projeto ? 
                `<div style="background-color: ${projeto.estado_projeto.cor};" class="m-auto size-7 rounded-full"></div>` :
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
                `<div style="background-color: ${projeto.estado_projeto.cor};" class="m-auto size-7 rounded-full"></div>` :
                'Estado não especificado';
        });
    }

    function atualizarTabelaProjetosOutrosColaboradores(projetos) {
        var tbody = document.querySelector('#tabelaProjetosOutrosColaboradores tbody');
        tbody.innerHTML = '';
        if(!Array.isArray(projetos)) {
            projetos = convertObjectToArray(projetos);
        }
        projetos.forEach(projeto => {
            
            // Verifica se o projeto tem mais de um colaborador
            if (projeto.users && projeto.users.length > 1) {
                var linha = tbody.insertRow();

                for (let i = 0; i < 6; i++) {
                    var celula = linha.insertCell();
                    celula.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
                }

                linha.cells[0].innerHTML = projeto.cliente && projeto.cliente.nome ? projeto.cliente.nome : 'Cliente não especificado';
                linha.cells[1].innerHTML = projeto.tipo_cliente && projeto.tipo_cliente.nome ? projeto.tipo_cliente.nome : 'Tipo não especificado';
                linha.cells[2].innerHTML = projeto.nome;
                linha.cells[3].innerHTML = projeto.tarefas.map(tarefa => `<p>${tarefa.descricao}</p>`).join("");
                // Lista os nomes dos colaboradores
                var colaboradores = projeto.users.map(user => `<p>${user.name}</p>`).join("");
                linha.cells[4].innerHTML = colaboradores;
                linha.cells[5].innerHTML = projeto.estado_projeto ? 
                `<div style="background-color: ${projeto.estado_projeto.cor};" class="m-auto size-7 rounded-full"></div>` :
                'Estado não especificado';
            }
        });
    }

    function convertObjectToArray(obj){
        return Object.keys(obj).map(key => ({
            key: key,
            ...obj[key]
        }));
    }
</script>

    