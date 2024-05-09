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
            table{
                width: 100%;
                table-layout: fixed;
            }
        </style>
    </head>
    <body>
        <x-app-layout>
            <div>
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
                        <div class="hidden xl:block">
                            <div class="flex items-center text-white mb-4" style="width: 100%;">
                                <div class="flex-none bg-darkBlue" style="width: 70%; height: 40px; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: start; align-items: center;">
                                    <h3 class="text-lg font-semibold">Projetos Em Desenvolvimento</h3>
                                </div>
                                <div class="flex-none ml-4" style="width: 29%; height: 30px; background-color: #f0f1f0; color: black; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: center; align-items: center;">
                                    <p id="selectedDateLabel" class="text-sm font-medium">
                                        Data da Semana: {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }} - {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-[#d5d4d5]">
                                        <tr>
                                            <th scope="col" class="text-left border w-[3%]">
                                                Nº
                                            </th>
                                            <th scope="col" class="text-left border w-[18%]">
                                                Cliente
                                            </th>
                                            <th scope="col" class="text-left border w-[15%]">
                                                Tipo
                                            </th>
                                            <th scope="col" class="text-left border w-[15%]">
                                                Projeto
                                            </th>
                                            <th scope="col" class="text-left border w-[8%]">
                                                Prioridade
                                            </th>
                                            <th scope="col" class="text-left border w-[17%]">
                                                Observações
                                            </th>
                                            <th scope="col" class="text-left border w-[8%]">
                                                Tempo
                                            </th>
                                            <th scope="col" class="text-left w-[8%]">
                                                Estado
                                            </th>
                                            <th scope="col" class="opacity-0 hover:cursor-none w-[8%]">
                                                
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="block xl:hidden">
                            <div class="flex items-center text-white mb-4 w-fit">
                                <div class="flex-none w-fit p-4 rounded-[0.2rem] bg-darkBlue" style="height: 40px; display: flex; justify-content: start; align-items: center;">
                                    <h3 class="text-lg font-semibold">Desenvolvimento</h3>
                                </div>
                            </div>
                            <div>
                                <div class="space-y-3 h-fit">
                                    <div id="responsiveDesenvolvimento" class="space-y-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tabelaProjetosPendentes" class="mb-8">
                        <div class="hidden xl:block">
                            <div class="relative mb-4">
                                <div class="flex-none text-white w-[70%] h-[40px] p-[1rem] flex items-center bg-[rgb(249,109,35)]" style="border-radius: 0.2rem; justify-content: start;">
                                    <h3 class="text-lg font-semibold">Projetos Pendentes</h3>
                                </div>
                            </div>
                            <div>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-[#d5d4d5]">
                                        <tr>
                                            <th scope="col" class="text-left w-[3%]">

                                            </th>
                                            <th scope="col" class="text-left border border-l-0 w-[18%]">
                                                Cliente
                                            </th>
                                            <th scope="col" class="text-left border w-[15%]">
                                                Tipo
                                            </th>
                                            <th scope="col" class="text-left border w-[15%]">
                                                Projeto
                                            </th>
                                            <th scope="col" class="text-left border w-[8%]">
                                                Prioridade
                                            </th>
                                            <th scope="col" class="text-left w-[17%]">

                                            </th>
                                            <th scope="col" class="text-left w-[8%]">

                                            </th>
                                            <th scope="col" class="text-left border border-r-0 w-[8%]">
                                                Estado
                                            </th>
                                            <th scope="col" class="text-left w-[8%]">

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="block xl:hidden">
                            <div class="flex items-center text-white mb-4 w-fit">
                                <div class="flex-none w-fit p-4 rounded-[0.2rem] bg-[rgb(249,109,35)]" style="height: 40px; display: flex; justify-content: start; align-items: center;">
                                    <h3 class="text-lg font-semibold">Pendentes</h3>
                                </div>
                            </div>
                            <div>
                                <div class="space-y-3 h-fit">
                                    <div id="responsivePendentes" class="space-y-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tabelaProjetosOutrosColaboradores" class="mb-8">
                        <div class="hidden xl:block">
                            <div class="relative mb-4">
                                <div class="flex-none text-white" style="width: 70%; height: 40px; background-color: #641885; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: start; align-items: center;">
                                    <h3 class="text-lg font-semibold">Projetos com Outros Colaboradores</h3>
                                </div>
                            </div>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-[#d5d4d5]">
                                    <tr>
                                        <th scope="col" class="text-left w-[3%]">

                                        </th>
                                        <th scope="col" class="text-left border border-l-0 w-[18%]">
                                            Cliente
                                        </th>
                                        <th scope="col" class="text-left border w-[15%]">
                                            Tipo
                                        </th>
                                        <th scope="col" class="text-left border w-[15%]">
                                            Projeto
                                        </th>
                                        <th scope="col" class="text-left border w-[8%]">
                                            Prioridade
                                        </th>
                                        <th scope="col" class="text-left border w-[25%]">
                                            Colaboradores
                                        </th>
                                        <th scope="col" class="text-left border border-r-0 w-[8%]">
                                            Estado
                                        </th>
                                        <th scope="col" class="text-left w-[8%]">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                </tbody>
                            </table>
                        </div>
                        <div class="block xl:hidden">
                            <div class="flex items-center text-white mb-4 w-fit">
                                <div class="flex-none w-fit p-4 rounded-[0.2rem]" style="height: 40px; background-color: #641885; display: flex; justify-content: start; align-items: center;">
                                    <h3 class="text-lg font-semibold">Com outros</h3>
                                </div>
                            </div>
                            <div>
                                <div class="space-y-3 h-fit">
                                    <div id="responsiveComOutros" class="space-y-3">
                                    </div>
                                </div>
                            </div>
                        </div>
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
        var responsiveDesenvolvimento = document.getElementById('responsiveDesenvolvimento');
        responsiveDesenvolvimento.innerHTML = '';
        tbody.innerHTML = ''; // Limpa o conteúdo atual da tabela

        projetos.forEach((projeto, index) => {
            // Para separação do design para computador / mobile
            if(true){
                var linha = tbody.insertRow(); // Insere uma nova linha na tabela
                var userId = document.getElementById('colaborador').value;
                // Adiciona borda a cada célula
                for (let i = 0; i < 8; i++) {
                    var celula = linha.insertCell();
                    celula.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap'); // Adiciona classes de estilo
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
                celulaEstadoProjeto.classList.remove('border');
                celulaEstadoProjeto.innerHTML = projeto.estado_projeto ? 
                    `<div style="background-color: ${projeto.estado_projeto.cor};" class="m-auto size-7 rounded-full"></div>` :
                    'Estado não especificado';
            }
            if(true){
                var userProjeto = projeto.users.find(user => user.id === parseInt(userId));
                var prioridade = userProjeto.pivot.prioridade ? userProjeto.pivot.prioridade : 'N/A';
                var linha1 = `
                <div class="flex justify-between">
                    <h1 class="font-black">
                        Prioridade: ${prioridade}
                    </h1>
                    <div class="flex space-x-3 mr-5">
                        <a href="/projetos/${projeto.id}/edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <form action="/projetos/${projeto.id}/destroy" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            </button>
                        </form>
                    </div>
                </div>
                `;

                var linha2 = `
                <div class="mt-3 flex items-start space-x-2">
                    <h2 class="font-semibold">
                        Cliente: ${projeto.cliente.nome}
                    </h2>
                    :
                    <h2 class="font-semibold">
                        ${projeto.tipo_cliente.nome}
                    </h2>
                </div>`
                ;

                var linha3 = `
                <div class="mt-3">
                    <h2 class="font-semibold">
                        ${projeto.nome}
                    </h2>
                </div>
                `;

                var descricaoTarefas = projeto.tarefas.map(tarefa => `<div>${tarefa.descricao}</div>`).join("");
                var linha4 = `
                <div class="mt-4 flex items-center">
                    <div>
                        <a class="bg-darkBlue text-white py-2 px-4 rounded mr-4 hover:cursor-pointer" onclick="openModal('modal_${projeto.id}')">
                            Tarefas
                        </a>
                        <div id="modal_${projeto.id}" class="modal fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 m-auto ">
                            <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white w-fit">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('modal_${projeto.id}')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6 pt-0 text-center">
                                    <div>
                                        ${descricaoTarefas}
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                var observacoes = userProjeto.pivot.observacoes ? userProjeto.pivot.observacoes : 'Sem observações';
                var linha5 = `
                <div class="mt-4">
                    <input disabled value='${observacoes}' title='${observacoes}' class="form-input observacoes bg-transparent w-full resize-none h-16 text-start" name='observacoes' autocomplete=off/>
                </div>
                `;

                var linha6 = `
                <div class="mt-5 flex w-full">
                    <input value='${userProjeto.pivot.tempo_gasto}' disabled class="w-fit bg-transparent rounded-md p-2 tempo-gasto" autocomplete="off" pattern="[0-9]{0,4}:[0-5][0-9]" type="text" placeholder="${tempoGasto}" name="tempoGasto">
                    
                    <div style="background-color: ${projeto.estado_projeto.cor};" class="mt-2 ml-2 size-7 rounded-full">
                    </div>
                </div>
                `;

                responsiveDesenvolvimento.innerHTML += `
                <div class="min-h-fit w-fit flex items-start shadow-lg border-4 py-4 pl-4 pr-12 responsiveElement" data-id='${projeto.id}'>
                    <div class="w-full">
                        ${linha1}
                        
                        ${linha2}
                        
                        ${linha3}
                        
                        ${linha4}

                        ${linha5}

                        ${linha6}
                    </div>
                </div>
                `;
            }
        });
    }

    function atualizarTabelaProjetosPendentes(projetos) {
    // Se não for um array, não prosseguir
        if (!Array.isArray(projetos)) {
            console.error('Erro: a entrada não é um array.');
            return;
        }

        var tbody = document.querySelector('#tabelaProjetosPendentes tbody');
        var responsivePendentes = document.getElementById('responsivePendentes');
        responsivePendentes.innerHTML = '';
        tbody.innerHTML = ''; // Limpa o conteúdo atual da tabela

        projetos.forEach((projeto, index) => {
            // Para separação do design para computador / mobile
            if(true){
                var linha = tbody.insertRow(); // Insere uma nova linha na tabela

                // Adiciona borda a cada célula
                for (let i = 0; i < 9; i++) {
                    var celula = linha.insertCell();
                    celula.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap');
                }
                // Coluna invisivel
                linha.cells[0].classList.remove('border');
                // Coluna de Cliente
                linha.cells[1].innerHTML = projeto.cliente && projeto.cliente.nome ? projeto.cliente.nome : 'Cliente não especificado';
                linha.cells[1].classList.add('border-l-0');
                // Coluna de Tipo de Cliente
                linha.cells[2].innerHTML = projeto.tipo_cliente && projeto.tipo_cliente.nome ? projeto.tipo_cliente.nome : 'Tipo não especificado';
                // Coluna de Nome do Projeto
                linha.cells[3].innerHTML = projeto.nome;
                // Coluna de Tarefas
                linha.cells[4].innerHTML = projeto.tarefas.map(tarefa => `<div>${tarefa.descricao}</div>`).join("");
                // Coluna invisivel
                linha.cells[5].classList.remove('border');
                // Coluna invisivel
                linha.cells[6].classList.remove('border');
                // Coluna de Estado do Projeto
                linha.cells[7].classList.add('border-r-0')
                linha.cells[7].innerHTML = projeto.estado_projeto ? 
                    `<div style="background-color: ${projeto.estado_projeto.cor};" class="m-auto size-7 rounded-full"></div>` :
                    'Estado não especificado';
                // Coluna invisivel
                linha.cells[8].classList.remove('border');
            }
            if(true){
                var linha1 = `
                <div class="mt-3 flex items-start space-x-2">
                    <h2 class="font-semibold">
                        Cliente: ${projeto.cliente.nome}
                    </h2>
                    :
                    <h2 class="font-semibold">
                        ${projeto.tipo_cliente.nome}
                    </h2>
                </div>`
                ;

                var linha2 = `
                <div class="mt-3 flex">
                    <h2 class="font-semibold">
                        ${projeto.nome}
                    </h2>
                    <div style="background-color: ${projeto.estado_projeto.cor};" class="ml-3 size-6 rounded-full">
                    </div>


                </div>
                `;

                var descricaoTarefas = projeto.tarefas.map(tarefa => `<div>${tarefa.descricao}</div>`).join("");
                var linha3 = `
                <div class="mt-5 mb-4 flex items-center">
                    <div>
                        <a class="bg-darkBlue text-white py-2 px-4 rounded mr-4 hover:cursor-pointer" onclick="openModal('modal_${projeto.id}')">
                            Tarefas
                        </a>
                        <div id="modal_${projeto.id}" class="modal fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 m-auto ">
                            <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white w-fit">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('modal_${projeto.id}')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6 pt-0 text-center">
                                    <div>
                                        ${descricaoTarefas}
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                responsivePendentes.innerHTML += `
                <div class="min-h-fit w-fit flex items-start shadow-lg border-4 py-4 pl-4 pr-12 responsiveElement" data-id='${projeto.id}'>
                    <div class="w-full">
                        ${linha1}
                        
                        ${linha2}
                        
                        ${linha3}
                    </div>
                </div>
                `;
            }
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
                // Para separação do design para computador / mobile
                if(true){
                    var linha = tbody.insertRow();

                    for (let i = 0; i < 8; i++) {
                        var celula = linha.insertCell();
                        celula.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
                    }
                    linha.cells[0].classList.remove('border');
                    linha.cells[1].innerHTML = projeto.cliente && projeto.cliente.nome ? projeto.cliente.nome : 'Cliente não especificado';
                    linha.cells[1].classList.add('border-l-0');
                    linha.cells[2].innerHTML = projeto.tipo_cliente && projeto.tipo_cliente.nome ? projeto.tipo_cliente.nome : 'Tipo não especificado';
                    linha.cells[3].innerHTML = projeto.nome;
                    linha.cells[4].innerHTML = projeto.tarefas.map(tarefa => `<p>${tarefa.descricao}</p>`).join("");
                    // Lista os nomes dos colaboradores
                    var colaboradores = projeto.users.map(user => `<p>${user.name}</p>`).join("");
                    linha.cells[5].innerHTML = colaboradores;
                    linha.cells[6].classList.add('border-r-0');
                    linha.cells[6].innerHTML = projeto.estado_projeto ? 
                    `<div style="background-color: ${projeto.estado_projeto.cor};" class="m-auto size-7 rounded-full"></div>` :
                    'Estado não especificado';
                    linha.cells[7].classList.remove('border');
                }
                if(true){
                        var linha1 = `
                        <div class="mt-3 flex items-start space-x-2">
                            <h2 class="font-semibold">
                                Cliente: ${projeto.cliente.nome}
                            </h2>
                            :
                            <h2 class="font-semibold">
                                ${projeto.tipo_cliente.nome}
                            </h2>
                        </div>`
                        ;

                        var linha2 = `
                        <div class="mt-3 flex">
                            <h2 class="font-semibold">
                                ${projeto.nome}
                            </h2>
                            <div style="background-color: ${projeto.estado_projeto.cor};" class="ml-3 size-6 rounded-full">
                            </div>
                        </div>
                        `;

                        var descricaoTarefas = projeto.tarefas.map(tarefa => `<div>${tarefa.descricao}</div>`).join("");
                        var linha3 = `
                        <div class="mt-5">
                            <div>
                                <a class="bg-darkBlue text-white py-2 px-4 rounded mr-4 hover:cursor-pointer" onclick="openModal('modal_${projeto.id}')">
                                    Tarefas
                                </a>
                                <div id="modal_${projeto.id}" class="modal fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 m-auto ">
                                    <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white w-fit">
                                        <div class="flex justify-end p-2">
                                            <button onclick="closeModal('modal_${projeto.id}')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-6 pt-0 text-center">
                                            <div>
                                                ${descricaoTarefas}
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;

                        var nomeColaboradores = projeto.users.map(user => '<div>'+user.name+'</div>').join("");
                        var linha4 = `
                        <div class="mt-5 mb-4 flex items-center">
                            <div>
                                <a class="bg-darkBlue text-white py-2 px-4 rounded mr-4 hover:cursor-pointer" onclick="openModal('modal_${projeto.id}/colab')">
                                    Colaboradores
                                </a>
                                <div id="modal_${projeto.id}/colab" class="modal fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 m-auto ">
                                    <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white w-fit">
                                        <div class="flex justify-end p-2">
                                            <button onclick="closeModal('modal_${projeto.id}/colab')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-6 pt-0 text-center">
                                            <div>
                                                ${nomeColaboradores}
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;


                        responsiveComOutros.innerHTML += `
                        <div class="min-h-fit w-fit flex items-start shadow-lg border-4 py-4 pl-4 pr-12 responsiveElement" data-id='${projeto.id}'>
                            <div class="w-full">
                                ${linha1}
                                
                                ${linha2}
                                
                                ${linha3}

                                ${linha4}
                            </div>
                        </div>
                        `;
                    }
            }
        });
    }

    function convertObjectToArray(obj){
        return Object.keys(obj).map(key => ({
            key: key,
            ...obj[key]
        }));
    }

    window.openModal = function(modalId) {
        document.getElementById(modalId).style.display = 'block'
        document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden')
    }

    window.closeModal = function(modalId) {
        document.getElementById(modalId).style.display = 'none'
        document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
    }

    // Close all modals when press ESC
    document.onkeydown = function(event) {
        event = event || window.event;
        if (event.keyCode === 27) {
            document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
            let modals = document.getElementsByClassName('modal');
            Array.prototype.slice.call(modals).forEach(i => {
                i.style.display = 'none'
            })
        }
    };
</script>

    