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
            .disabledTable *{
                pointer-events: none;
                background-color: rgb(207 207 207);
            }
            .chosenDraggable * {
                /* background: rgb(150 150 150); */
                opacity: 1;
            }
            table {
                width:100%;
                table-layout: fixed;
            }
        </style>
    </head>
    <body>
        <x-app-layout>
            <div>
                <div>
                    <div class="items-center text-darkBlue">
                        <div class="hidden xl:flex">
                            <h2 class="text-xl font-black">
                                Prioridades >
                            </h2>
                            <div class="ml-2">
                                Definir
                            </div>
                        </div>
                        <div class="block xl:hidden">
                            <h2 class="text-xl font-black">
                                Projetos
                            </h2>
                        </div>
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
                                        <div class="mx-3 ml-10 text-gray-700 font-black">
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
                        <div class="hidden xl:block">
                            <div class="flex items-center text-white mb-4" style="width: 100%;">
                                <div class="flex-none bg-darkBlue" style="width: 70%; height: 40px; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: start; align-items: center;">
                                    <h3 class="text-lg font-semibold">Projetos Em Desenvolvimento</h3>
                                </div>
                                <div class="flex-none ml-4" style="width: 29%; height: 30px; background-color: #f0f1f0; color: black; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: center; align-items: center;">
                                    <p class="text-sm font-medium">
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
                                            <th scope="col" class="text-left border border-r-4 border-r-[#A3A2A3] w-[8%]">
                                                Prioridade
                                            </th>
                                            <th scope="col" class="text-left border w-[17%]">
                                                Observações
                                            </th>
                                            <th scope="col" class="text-left border w-[8%]">
                                                Tempo
                                            </th>
                                            <th scope="col" class="text-left border w-[8%]">
                                                Estado
                                            </th>
                                            <th scope="col" class="text-left border w-[8%]">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="xl:hidden block">
                            <div class="flex items-center text-white mb-4 w-fit">
                                <div class="flex-none w-fit p-4 rounded-[0.2rem] bg-darkBlue" style="height: 40px; display: flex; justify-content: start; align-items: center;">
                                    <h3 class="text-lg font-semibold">Desenvolvimento</h3>
                                </div>
                                <div class="flex-none ml-4 w-fit" style="height: 30px; background-color: #f0f1f0; color: black; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: center; align-items: center;">
                                    <p class="text-sm font-medium">
                                        Semana: {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }} - {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-3 h-fit">
                                <div id="responsiveDesenvolvimento" class="space-y-3">
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
                                            <th scope="col" class="opacity-0 hover:cursor-default w-[3%]">
                                                Nº
                                            </th>
                                            <th scope="col" class="text-left w-[18%]">
                                                Cliente
                                            </th>
                                            <th scope="col" class="text-left border w-[15%]">
                                                Tipo
                                            </th>
                                            <th scope="col" class="text-left border w-[15%]">
                                                Projeto
                                            </th>
                                            <th scope="col" class="text-left border border-r-4 border-r-[#A3A2A3]  w-[8%]">
                                                Prioridade
                                            </th>
                                            <th scope="col" class="opacity-0 hover:cursor-default w-[17%]">
                                                Observações
                                            </th>
                                            <th scope="col" class="opacity-0 hover:cursor-default w-[8%]">
                                                Tempo
                                            </th>
                                            <th scope="col" class="text-left border w-[8%]">
                                                Estado
                                            </th>
                                            <th scope="col" class="text-left border w-[8%]">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="xl:hidden block">
                            <div class="flex items-center text-white mb-4 w-fit">
                                <div class="flex-none w-fit p-4 rounded-[0.2rem] bg-[rgb(249,109,35)]" style="height: 40px; display: flex; justify-content: start; align-items: center;">
                                    <h3 class="text-lg font-semibold">Pendentes</h3>
                                </div>
                            </div>
                            <div class="space-y-3 h-fit">
                                <div id="responsivePendentes" class="space-y-3">
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
                            <div>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-[#d5d4d5]">
                                        <th scope="col" class="opacity-0 hover:cursor-default w-[3%]">
                                            Nº
                                        </th>
                                        <th scope="col" class="text-left w-[18%]">
                                            Cliente
                                        </th>
                                        <th scope="col" class="text-left border w-[15%]">
                                            Tipo
                                        </th>
                                        <th scope="col" class="text-left border w-[15%]">
                                            Projeto
                                        </th>
                                        <th scope="col" class="text-left border border-r-4 border-r-[#A3A2A3] w-[8%]">
                                            Prioridade
                                        </th>
                                        <th scope="col" class="text-left border w-[25%]">
                                            Colaboradores
                                        </th>
                                        <th scope="col" class="text-left border w-[8%]">
                                            Estado
                                        </th>
                                        <th scope="col" class="text-left border w-[8%]">
                                            Ações
                                        </th>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="xl:hidden block">
                            <div class="flex items-center text-white mb-4 w-fit">
                                <div class="flex-none w-fit p-4 rounded-[0.2rem]" style="height: 40px; background-color: #641885; display: flex; justify-content: start; align-items: center;">
                                    <h3 class="text-lg font-semibold">Com outros</h3>
                                </div>
                            </div>
                            <div class="space-y-3 h-fit">
                                <div id="responsiveComOutros" class="space-y-3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mb-8">
                        <a href="/emailTest/{{$colaboradores[0]->id}}" id='emailAnchor'>
                            <button id="btnGuardar" class="bg-darkBlue hover:bg-blue-700 text-white p-5 rounded">
                                Enviar notificação
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var userId = document.getElementById('colaborador').value;
        atualizarTabelas(userId);
    });

    document.getElementById('colaborador').addEventListener('change', function () {
        var userId = this.value;
        atualizarTabelas(userId);

        var $userId = userId;
        document.getElementById('emailAnchor').href = '/emailTest/' + $userId;

    });

    function atualizarTabelaProjetosEmAberto(userId) {
        var tdClassList = [ 'px-3', 'py-4', 'whitespace-nowrap', 'border', 'border-b'];

        fetch('/filtrar/projetos?colaborador_id=' + userId)
            .then(response => response.json())
            .then(data => {
                var tbody = document.querySelector('#tabelaProjetosAbertos tbody');
                var responsiveDesenvolvimento = document.getElementById('responsiveDesenvolvimento');
                responsiveDesenvolvimento.innerHTML = '';
                tbody.innerHTML = '';

                data.forEach((projeto) => {
                    // Para separação do design para computador / mobile
                    if(true){
                        var linha = tbody.insertRow();
                        linha.setAttribute('data-id', projeto.id);
                        // Encontra o usuário específico e sua prioridade
                        var userProjeto = projeto.users.find(user => user.id === parseInt(userId));
                        var prioridade = userProjeto.pivot.prioridade ? userProjeto.pivot.prioridade : 'N/A';

                        var celulaN_Prioridade = linha.insertCell(0);
                        celulaN_Prioridade.classList.add(...tdClassList);
                        celulaN_Prioridade.classList.add('text-center');
                        celulaN_Prioridade.innerHTML = prioridade;

                        var celulaNomeCliente = linha.insertCell(1);
                        celulaNomeCliente.classList.add(...tdClassList);
                        celulaNomeCliente.innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="/projetos/${projeto.id}/cliente/atualizar" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <select name="novoCliente" id="novoCliente/${projeto.id}" onchange="this.form.submit()" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($clientes as $cliente)
                                            <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;

                        var celulaTipoCliente = linha.insertCell(2);
                        celulaTipoCliente.classList.add(...tdClassList);
                        nomeTipoCliente = projeto.tipo_cliente.nome;
                        celulaTipoCliente.innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="{{route('projetos.tipoCliente.create')}}" id="formNovoTipoCliente" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="text" name="nome" id="newTipoClienteInput/${projeto.id}" class="w-fit" onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoCliente/atualizar" id="formAlterarTipoCliente/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <select name="novoTipoCliente" id="novoTipoCliente/${projeto.id}" onchange="handleTipoClienteForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($tiposCliente as $tC)
                                            <option value="{{$tC->id}}">{{$tC->nome}}</option>
                                        @endforeach
                                        <option value="-1" class="font-black">Novo</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;

                        var celulaTipoProjeto = linha.insertCell(3);
                        celulaTipoProjeto.classList.add(...tdClassList);
                        celulaTipoProjeto.innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="{{route('projetos.tipoProjeto.create')}}" id="formNovoTipoProjeto" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="text" name="nome" id="newTipoProjetoInput/${projeto.id}" onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoProjeto/atualizar" id="formAlterarTipoProjeto/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <select name="novoTipoProjeto" id="novoTipoProjeto/${projeto.id}" onchange="handleTipoProjetoForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($tiposProjeto as $tP)
                                            <option value="{{$tP->id}}">{{$tP->nome}}</option>
                                        @endforeach
                                        <option value="-1" class="font-black">Novo</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;

                        var celulaTarefas = linha.insertCell(4);
                        celulaTarefas.innerHTML = projeto.tarefas.map(tarefa => `<p>${tarefa.descricao}</p>`).join("");
                        celulaTarefas.classList.add(...tdClassList);
                        celulaTarefas.classList.add("border-r-4", 'border-r-[#A3A2A3]');

                        var celulaObservacoes = linha.insertCell(5);
                        var userProjeto = projeto.users.find(user => user.id == userId);
                        if(userProjeto){
                            observacoes = userProjeto.pivot.observacoes ? userProjeto.pivot.observacoes : 'Sem observações';
                        }
                        celulaObservacoes.classList.add(...tdClassList);
                        var div = document.createElement('div');
                        div.innerHTML =
                        `   
                            <form action="/projetos/${projeto.id}/${userId}/updateObs" method="POST" class="m-auto justify-center flex flex-wrap">
                                @csrf
                                @method('PUT')
                                <input value='${observacoes}' title='${observacoes}' onTextChange='this.form.submit()' class="border-none form-input observacoes bg-transparent w-full resize-none h-16 text-start" name='observacoes' autocomplete=off/>
                            </form>
                        `;
                        celulaObservacoes.appendChild(div);

                        var celulaTempoGasto = linha.insertCell(6);
                        var tempoGasto = userProjeto ? userProjeto.pivot.tempo_gasto : '--:--';
                        celulaTempoGasto.classList.add(...tdClassList);
                        var div = document.createElement('div');
                        div.innerHTML = `
                        <form action="/projetos/${projeto.id}/${userId}/updateTimeSpent" method="POST" class="m-auto w-[100px] justify-center">
                            @csrf
                            @method('PUT')
                            <input value='${tempoGasto}' onChange='${this.submit}' class="border-none bg-transparent rounded-md p-2 w-full tempo-gasto text-center" autocomplete="off" pattern="[0-9]{0,4}:[0-5][0-9]" type="text" placeholder="${tempoGasto}" name="tempoGasto">
                        </form>
                        `;
                        celulaTempoGasto.appendChild(div);

                        var celulaEstadoProjeto = linha.insertCell(7);
                        celulaEstadoProjeto.classList.add(...tdClassList);
                        
                        var tempoGastoMins = 0;
                        projeto.users.forEach(user => {
                            var tempoGasto = user.pivot.tempo_gasto.split(":");
                            var tempoGastoP1 = parseInt(tempoGasto[0]);
                            var tempoGastoP2 = parseInt(tempoGasto[1]);
                            tempoGastoMins += tempoGastoP1 * 60 + tempoGastoP2;
                        });

                        var tempoPrevisto = projeto.tempo_previsto.split(":");
                        var tempoPrevistoP1 = parseInt(tempoPrevisto[0]);
                        var tempoPrevistoP2 = parseInt(tempoPrevisto[1]);

                        var tempoPrevistoMinutes = tempoPrevistoP1 * 60 + tempoPrevistoP2;

                        var bgColor;
                        if (tempoGastoMins < tempoPrevistoMinutes) {
                            bgColor = '122,166,77';
                        } else if (tempoGastoMins === tempoPrevistoMinutes) {
                            bgColor = '10,57,86';
                        } else {
                            bgColor = '231,81,91';
                        }

                        celulaEstadoProjeto.innerHTML = `
                        <div style="background-color: rgb(${bgColor});" class="m-auto size-7 rounded-full">
                        </div>
                        `;


                        var celulaAcoes = linha.insertCell(8);
                        celulaAcoes.classList.add(...tdClassList);
                        celulaAcoes.innerHTML = `
                        <div class="flex justify-center items-center space-x-4">
                            <a href="/projetos/${projeto.id}/edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            @if(auth()->user() && auth()->user()->tipo == 'admin')
                                <form action="/projetos/${projeto.id}/destroy" method="POST" class="m-0">
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
                        `;

                        var select = document.querySelector(`#novoCliente\\/${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.cliente.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }

                        var select = document.querySelector(`#novoTipoCliente\\/${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.tipo_cliente.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }

                        var select = document.querySelector(`#novoTipoProjeto\\/${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.tipo_projeto.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }
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

                        var linha5 = `
                        <div class="mt-4">
                            <form action="/projetos/${projeto.id}/${userId}/updateObs" method="POST" class=" justify-center flex flex-wrap">
                                @csrf
                                @method('PUT')
                                <input value='${observacoes}' title='${observacoes}' onTextChange='this.form.submit()' class="form-input observacoes bg-transparent w-full resize-none h-16 text-start" name='observacoes' autocomplete=off/>
                            </form>
                        </div>
                        `;

                        var linha6 = `
                        <div class="mt-5 flex w-full">
                            <form action="/projetos/${projeto.id}/${userId}/updateTimeSpent" method="POST" class="w-fit">
                                @csrf
                                @method('PUT')
                                <input value='${userProjeto.pivot.tempo_gasto}' onChange='${this.submit}' class="w-fit bg-transparent rounded-md p-2 tempo-gasto" autocomplete="off" pattern="[0-9]{0,4}:[0-5][0-9]" type="text" placeholder="${tempoGasto}" name="tempoGasto">
                            </form>
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
            });
    }

    function atualizarTabelaProjetosPendentes(userId) {
        var tdClassList = [ 'px-3', 'py-4', 'whitespace-nowrap', 'border', 'border-b'];

        fetch('/filtrar/projetospendentes?colaborador_id=' + userId)
            .then(response => response.json())
            .then(data => {
                var tbodyPendentes = document.querySelector('#tabelaProjetosPendentes tbody');
                var responsivePendentes = document.getElementById('responsivePendentes');
                responsivePendentes.innerHTML = '';
                tbodyPendentes.innerHTML = '';

                data.forEach((projeto) => {
                    // Para separação do design para computador / mobile
                    if(true){
                        var linha = tbodyPendentes.insertRow();
                        linha.setAttribute('data-id', projeto.id);
                        linha.classList.add('border-b'); // Adiciona borda à linha

                        var celulas = [];

                        for (let i = 0; i < 9; i++) {
                            celulas[i] = linha.insertCell(i);
                            celulas[i].classList.add(...tdClassList);
                        }
                        celulas[0].classList.add('border-r-0');
                        celulas[1].innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="/projetos/${projeto.id}/cliente/atualizar" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <select name="novoCliente" id="novoCliente/${projeto.id}" onchange="this.form.submit()" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($clientes as $cliente)
                                            <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;
                        celulas[1].classList.add('border-l-0')
                        celulas[2].innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="{{route('projetos.tipoCliente.create')}}" id="formNovoTipoCliente" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="text" name="nome" id="newTipoClienteInput/${projeto.id}"  onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoCliente/atualizar" id="formAlterarTipoCliente/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <select name="novoTipoCliente" id="novoTipoCliente/${projeto.id}" onchange="handleTipoClienteForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($tiposCliente as $tC)
                                            <option value="{{$tC->id}}">{{$tC->nome}}</option>
                                        @endforeach
                                        <option value="-1" class="font-black">Novo</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;
                        celulas[3].innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="{{route('projetos.tipoProjeto.create')}}" id="formNovoTipoProjeto" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="text" name="nome" id="newTipoProjetoInput/${projeto.id}" onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoProjeto/atualizar" id="formAlterarTipoProjeto/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <select name="novoTipoProjeto" id="novoTipoProjeto/${projeto.id}" onchange="handleTipoProjetoForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($tiposProjeto as $tP)
                                            <option value="{{$tP->id}}">{{$tP->nome}}</option>
                                        @endforeach
                                        <option value="-1" class="font-black">Novo</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;

                        var tarefas = projeto.tarefas.map(tarefa => `<p>${tarefa.descricao}</p>`).join("");
                        celulas[4].classList.add(...tdClassList);
                        celulas[4].classList.add("border-r-4", 'border-r-[#A3A2A3]');
                        celulas[4].innerHTML = tarefas;

                        celulas[5].classList.add('border-r-0');
                        celulas[6].classList.add('border-l-0');

                        var celulaEstadoProjeto = celulas[7];
                        var tempoGastoMins = 0;
                        projeto.users.forEach(user => {
                            var tempoGasto = user.pivot.tempo_gasto.split(":");
                            var tempoGastoP1 = parseInt(tempoGasto[0]);
                            var tempoGastoP2 = parseInt(tempoGasto[1]);
                            tempoGastoMins += tempoGastoP1 * 60 + tempoGastoP2;
                        });

                        var tempoPrevisto = projeto.tempo_previsto.split(":");
                        var tempoPrevistoP1 = parseInt(tempoPrevisto[0]);
                        var tempoPrevistoP2 = parseInt(tempoPrevisto[1]);

                        var tempoPrevistoMinutes = tempoPrevistoP1 * 60 + tempoPrevistoP2;

                        var bgColor;
                        if (tempoGastoMins < tempoPrevistoMinutes) {
                            bgColor = '122,166,77';
                        } else if (tempoGastoMins === tempoPrevistoMinutes) {
                            bgColor = '10,57,86';
                        } else {
                            bgColor = '231,81,91';
                        }
                        celulaEstadoProjeto.innerHTML =
                            `<div style="background-color: rgb(${bgColor});" class="m-auto size-7 rounded-full">
                            </div>`;
                            

                        var celulaAcoes = celulas[8];
                        celulaAcoes.innerHTML = `
                        <div class="flex justify-center items-center space-x-4">
                            <a href="/projetos/${projeto.id}/edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            @if(auth()->user() && auth()->user()->tipo == 'admin')
                                <form action="/projetos/${projeto.id}/destroy" method="POST" class="m-0">
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
                        `;

                        var select = document.querySelector(`#novoCliente\\/${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.cliente.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }

                        var select = document.querySelector(`#novoTipoCliente\\/${projeto.id}`);
                        var options = select.options;

                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.tipo_cliente.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }

                        var select = document.querySelector(`#novoTipoProjeto\\/${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.tipo_projeto.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }
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
            });
    }

    function atualizarTabelaProjetosComOutrosColaboradores(userId) {
        fetch('/filtrar/projetos-outros-colaboradores/' + userId)
            .then(response => response.json())
            .then(data => {
                var tbodyOutrosColaboradores = document.querySelector('#tabelaProjetosOutrosColaboradores tbody');
                var responsiveComOutros = document.getElementById('responsiveComOutros');
                responsiveComOutros.innerHTML = '';
                tbodyOutrosColaboradores.innerHTML = '';

                data.forEach((projeto) => {
                    // Para separação do design para computador / mobile
                    if(true){
                        var linha = tbodyOutrosColaboradores.insertRow();
                        linha.classList.add('border-b'); // Adiciona borda à linha

                        var celulas = [];

                        for (let i = 0; i < 8; i++) {
                            celulas[i] = linha.insertCell(i);
                            celulas[i].classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap');
                        }

                        celulas[0].classList.add('border-r-0', 'invisible');
                        celulas[1].innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="/projetos/${projeto.id}/cliente/atualizar" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <select name="novoCliente" id="novoCliente/colab/${projeto.id}" onchange="this.form.submit()" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($clientes as $cliente)
                                            <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;
                        celulas[1].classList.add('border-l-0');
                        
                        celulas[2].innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="{{route('projetos.tipoCliente.create')}}" id="formNovoTipoCliente" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="text" name="nome" id="newTipoClienteInput/${projeto.id}"  onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoCliente/atualizar" id="formAlterarTipoCliente/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <select name="novoTipoCliente" id="novoTipoCliente/colab/${projeto.id}" onchange="handleTipoClienteForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($tiposCliente as $tC)
                                            <option value="{{$tC->id}}">{{$tC->nome}}</option>
                                        @endforeach
                                        <option value="-1" class="font-black">Novo</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;

                        celulas[3].innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="{{route('projetos.tipoProjeto.create')}}" id="formNovoTipoProjeto" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="text" name="nome" id="newTipoProjetoInput/${projeto.id}" onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoProjeto/atualizar" id="formAlterarTipoProjeto/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <select name="novoTipoProjeto" id="novoTipoProjeto/colab/${projeto.id}" onchange="handleTipoProjetoForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($tiposProjeto as $tP)
                                            <option value="{{$tP->id}}">{{$tP->nome}}</option>
                                        @endforeach
                                        <option value="-1" class="font-black">Novo</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;

                        var tarefas = projeto.tarefas.map(tarefa => `<p>${tarefa.descricao}</p>`).join("");
                        celulas[4].classList.add("border-r-4", 'border-r-[#A3A2A3]');
                        celulas[4].innerHTML = tarefas;

                        // Lista todos os colaboradores associados ao projeto
                        var colaboradores = projeto.users.map(user => '<p>'+user.name+'</p>').join("");
                        celulas[5].innerHTML = colaboradores;

                        var celulaEstadoProjeto = celulas[6];

                        var tempoGastoMins = 0;
                        projeto.users.forEach(user => {
                            var tempoGasto = user.pivot.tempo_gasto.split(":");
                            var tempoGastoP1 = parseInt(tempoGasto[0]);
                            var tempoGastoP2 = parseInt(tempoGasto[1]);
                            tempoGastoMins += tempoGastoP1 * 60 + tempoGastoP2;
                        });

                        var tempoPrevisto = projeto.tempo_previsto.split(":");
                        var tempoPrevistoP1 = parseInt(tempoPrevisto[0]);
                        var tempoPrevistoP2 = parseInt(tempoPrevisto[1]);

                        var tempoPrevistoMinutes = tempoPrevistoP1 * 60 + tempoPrevistoP2;

                        var bgColor;
                        if (tempoGastoMins < tempoPrevistoMinutes) {
                            bgColor = '122,166,77';
                        } else if (tempoGastoMins === tempoPrevistoMinutes) {
                            bgColor = '10,57,86';
                        } else {
                            bgColor = '231,81,91';
                        }


                        celulaEstadoProjeto.innerHTML =
                            `<div style="background-color: rgb(${bgColor});" class="m-auto size-7 rounded-full">
                            </div>`;


                        var celulaAcoes = celulas[7];
                        celulaAcoes.innerHTML = `
                        <div class="flex justify-center items-center space-x-4">
                            <a href="/projetos/${projeto.id}/edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:tet-blue-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            @if(auth()->user() && auth()->user()->tipo == 'admin')
                                <form action="/projetos/${projeto.id}/destroy" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                        `;
                        
                        var select = document.querySelector(`#novoCliente\\/colab\\/${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.cliente.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }

                        var select = document.querySelector(`#novoTipoCliente\\/colab\\/${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.tipo_cliente.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }

                        var select = document.querySelector(`#novoTipoProjeto\\/colab\\/${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.tipo_projeto.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }
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
                });
            });
    }

    function atualizarTabelas(userId){
        atualizarTabelaProjetosEmAberto(userId);
        atualizarTabelaProjetosPendentes(userId);
        atualizarTabelaProjetosComOutrosColaboradores(userId);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('tabelaProjetosAbertos').getElementsByTagName('tbody')[0];
        var sortable = new Sortable(el, {
            chosenClass: 'chosenDraggable',
            group: 'shared',
            ghostClass: 'bg-gray-300',
            animation: 150,
            onAdd: function(evt){
                var item = evt.item;
                var projetosData = [];
                var userId = document.getElementById('colaborador').value; // Obtém o user_id do dropdown de colaboradores

                projetosData.push({
                    id: item.getAttribute('data-id'),
                    user_id: userId,
                    estado: 1
                });
                // Enviar a nova ordem para o servidor
                fetch('/atualizar/estadoProjeto', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ projetos: projetosData })
                }).then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    }).then(data => {
                        console.log('Estado do projeto atualizado com sucesso:', data);
                        atualizarTabelas(userId); // Atualiza a tabela com o usuário atual
                    }).catch(error => {
                        console.error('Erro a mudar estado do projeto:', error);
                    });
            },
            onSort: function (evt) {
                var items = el.getElementsByTagName('tr');
                var projetosData = [];
                var userId = document.getElementById('colaborador').value; // Obtém o user_id do dropdown de colaboradores

                for (var i = 0; i < items.length; i++) {
                    projetosData.push({
                        id: items[i].getAttribute('data-id'),
                        user_id: userId, // Inclui o user_id no objeto
                        prioridade: i + 1 // Nova prioridade baseada na posição
                    });
                }
                // Enviar a nova ordem para o servidor
                fetch('/atualizar/prioridades', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ projetos: projetosData })
                }).then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    }).then(data => {
                        console.log('Ordem atualizada com sucesso:', data);
                        atualizarTabelas(userId);
                    }).catch(error => {
                        console.error('Erro ao atualizar a ordem:', error);
                    });
            }
        });
        
        var el2 = document.getElementById('tabelaProjetosPendentes').getElementsByTagName('tbody')[0];
        var sortable2 = new Sortable(el2,{
            chosenClass: 'chosenDraggable',
            group: 'shared',
            ghostClass: 'bg-gray-300',
            animation: 150,
            sort: false,
            onAdd: function(evt){
                var item = evt.item;
                var projetosData = [];
                var userId = document.getElementById('colaborador').value; // Obtém o user_id do dropdown de colaboradores

                projetosData.push({
                    id: item.getAttribute('data-id'),
                    user_id:userId,
                    estado: 2
                });
                // Enviar a nova ordem para o servidor
                fetch('/atualizar/estadoProjeto', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ projetos: projetosData })
                }).then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    }).then(data => {
                        console.log('Estado do projeto atualizado com sucesso:', data);
                        atualizarTabelas(userId);
                    }).catch(error => {
                        console.error('Erro a mudar estado do projeto:', error);
                    });
            }
        });

        var el3 = document.getElementById('responsiveDesenvolvimento');
        var sortable3 = new Sortable(el3,{
            chosenClass: 'chosenDraggable',
            group: 'responsive',
            ghostClass: 'bg-gray-300',
            animation: 150,
            onAdd: function(evt){
                var item = evt.item;
                var projetosData = [];
                var userId = document.getElementById('colaborador').value; // Obtém o user_id do dropdown de colaboradores

                projetosData.push({
                    id: item.getAttribute('data-id'),
                    user_id: userId,
                    estado: 1
                });
                // Enviar a nova ordem para o servidor
                fetch('/atualizar/estadoProjeto', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ projetos: projetosData })
                }).then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    }).then(data => {
                        console.log('Estado do projeto atualizado com sucesso:', data);
                        atualizarTabelas(userId); // Atualiza a tabela com o usuário atual
                    }).catch(error => {
                        console.error('Erro a mudar estado do projeto:', error);
                    });
            },
            onSort: function (evt) {
                var items = el3.getElementsByClassName('responsiveElement');
                var projetosData = [];
                var userId = document.getElementById('colaborador').value; // Obtém o user_id do dropdown de colaboradores
                for (var i = 0; i < items.length; i++) {
                    projetosData.push({
                        id: items[i].getAttribute('data-id'),
                        user_id: userId, // Inclui o user_id no objeto
                        prioridade: i + 1 // Nova prioridade baseada na posição
                    });
                }
                // Enviar a nova ordem para o servidor
                fetch('/atualizar/prioridades', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ projetos: projetosData })
                }).then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    }).then(data => {
                        console.log('Ordem atualizada com sucesso:', data);
                        atualizarTabelas(userId);
                    }).catch(error => {
                        console.error('Erro ao atualizar a ordem:', error);
                    });
            }
        
        
        
        
        });

        var el4 = document.getElementById('responsivePendentes');
        var sortable4 = new Sortable(el4, {
            chosenClass: 'chosenDraggable',
            group: 'responsive',
            ghostClass: 'bg-gray-300',
            animation: 150,
            sort: false,
            onAdd: function(evt){
                var item = evt.item;
                var projetosData = [];
                var userId = document.getElementById('colaborador').value; // Obtém o user_id do dropdown de colaboradores

                projetosData.push({
                    id: item.getAttribute('data-id'),
                    user_id:userId,
                    estado: 2
                });
                // Enviar a nova ordem para o servidor
                fetch('/atualizar/estadoProjeto', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ projetos: projetosData })
                }).then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    }).then(data => {
                        console.log('Estado do projeto atualizado com sucesso:', data);
                        atualizarTabelas(userId);
                    }).catch(error => {
                        console.error('Erro a mudar estado do projeto:', error);
                    });
            }
        });

    });

    document.getElementById('btnGuardar').addEventListener('click', function () {
        var userId = document.getElementById('colaborador').value; // Obter o user_id do dropdown
        var projetosData = [];

        document.querySelectorAll('#tabelaProjetosAbertos tbody tr').forEach(function (row) {
            var projetoId = row.getAttribute('data-id');
            var observacoes = row.querySelector('.observacoes').value;
            var tempoGasto = row.querySelector('.tempo-gasto').value;
            var prioridade = row.querySelector('.prioridade').value;
            projetosData.push({
                id: projetoId,
                user_id: userId, // Usar o mesmo user_id para todos os projetos
                observacoes: observacoes,
                tempoGasto: tempoGasto,
                prioridade: prioridade, 
            });
        });
        fetch('/salvar/projetos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ projetos: projetosData })
        }).then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Algo deu errado no servidor.');
                }
            })
            .then(data => {
                alert('Projetos atualizados com sucesso!');
            })
            .catch(error => {
                console.error('Erro ao salvar projetos:', error);
            });
    });

    document.getElementById('toggleFerias').addEventListener('change',function(){
        document.querySelector('#tabelaProjetosAbertos tbody').classList.toggle('disabledTable');
        document.getElementById('responsiveDesenvolvimento').classList.toggle('disabledTable');
    });

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
    function handleTipoClienteForms(id){
        var select = document.getElementById(id);
        if(select.value == -1){
            select.classList.add("hidden")
            document.getElementById("formNovoTipoCliente").classList.remove("hidden");
        }else{
            document.getElementById('formAlterarTipoCliente/' + id.split('/')[1]).submit();
        }
    }

    function handleTipoProjetoForms(id){
        var select = document.getElementById(id);

        if(select.value == -1){
            select.classList.add("hidden")
            document.getElementById("formNovoTipoProjeto").classList.remove("hidden");
        }else{
            document.getElementById('formAlterarTipoProjeto/' + id.split('/')[1]).submit();
        }
    }
</script>