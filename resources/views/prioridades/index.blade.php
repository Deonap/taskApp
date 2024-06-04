<html lang="en">
    <head>
        <style>
            #toggleFerias:checked+.toggle-line {
                background-color: rgb(10,56,87);
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
            td{
                font-size: 14px;
                text-align: left;
                border-width: 1px;
            }
            .disabledTable *{
                pointer-events: none;
                background-color: rgb(207 207 207);
            }
            .chosenDraggable * {
                opacity: 1;
            }
            table {
                width:100%;
                table-layout: fixed;
            }
            .collapsible-content {
                transition: height 0.3s ease-in;
                overflow: hidden;
            }
            .plusIcon, .minusIcon {
                display: inline-block;
                width: 24px;
                height: 24px;
                background-position: center;
                background-size: 50% 2px, 2px 50%;
                background-repeat: no-repeat;
            }

            .plusIcon {
                background-image: 
                    linear-gradient(to right, #fff 0%, #fff 100%),
                    linear-gradient(to bottom, #fff 0%, #fff 100%);
            }

            .minusIcon {
                background-image: 
                    linear-gradient(to right, #fff 0%, #fff 100%);
            }
        </style>
    </head>
    <?php
        $hasPermissions = auth()->user() && auth()->user()->tipo == 'admin';
    ?>
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
                                            <option {{$selectedUser == $colaborador->id ? "selected" : ""}} value="{{ $colaborador->id }}">{{ $colaborador->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="ml-[3.75rem]">
                                    <form action="" id="formToggleFerias" method="POST" class="m-auto">
                                        @csrf
                                        @method('PUT')
                                        <input id="redirectToggleFeriasUser" type="hidden" name="user" value="">
                                        <label for="toggleFerias" class="flex items-center cursor-pointer">
                                            <div class="mr-3 text-gray-700 font-black">
                                                Férias
                                            </div>
                                            <div class="relative">
                                                <input name="toggleFerias" value="1" id="toggleFerias" onchange="this.form.submit()" type="checkbox" class="hidden" />
                                                <div class="toggle-line w-10 h-4 bg-gray-400 rounded-full shadow-inner transition-colors">
                                                </div>
                                                <div class="toggle-dot absolute w-6 h-6 bg-white rounded-full shadow inset-y-0 left-0 transition-transform border" style="top: -4px;">
                                                </div>
                                            </div>
                                        </label>
                                    </form>
                                </div>
                                <script>
                                    var selectColab = document.getElementById('colaborador');
                                    selectColab.addEventListener('change', function(){
                                        var options = this.options;
                                        var selectedValue = options[this.selectedIndex].value;
                                        document.getElementById('formToggleFerias').action = "{{route('users.toggleFerias', '')}}/" + selectedValue;
                                        document.getElementById('redirectToggleFeriasUser').value = selectedValue;
                                    });
                                    document.addEventListener('DOMContentLoaded', function(){
                                        var selectColab = document.getElementById('colaborador');
                                        var options = selectColab.options;
                                        var selectedValue = options[selectColab.selectedIndex].value;
                                        document.getElementById('formToggleFerias').action = "{{route('users.toggleFerias', '')}}/" + selectedValue;
                                        document.getElementById('redirectToggleFeriasUser').value = selectedValue;
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    {{-- tabela projetos abertos --}}
                    <div class="mb-8">
                        <div class="hidden xl:block">
                            <div class="flex items-center text-white mb-4" style="width: 100%;">
                                <div class="flex-none text-white bg-projetosDesenvolvimentoBanner" style="width: 70%; height: 40px; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h3 class="text-lg font-semibold">Projetos Em Desenvolvimento</h3>
                                    </div>
                                    <div id="toggleDesenvolvimento" class="text-right collapseIcon minusIcon hover:cursor-pointer">
                                        
                                    </div>
                                </div>
                                <div class="flex-none ml-4" style="width: 29%; height: 30px; background-color: #f0f1f0; color: black; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: center; align-items: center;">
                                    <p class="text-sm font-medium">
                                        Data da Semana: {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }} - {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <div id="tabelaProjetosAbertos" class="collapsible-content">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-[#d5d4d5]">
                                        <tr>
                                            <th scope="col" class="w-[3.8%]">
                                                Nº
                                            </th>
                                            <th scope="col" class="w-[11.5%]">
                                                Cliente
                                            </th>
                                            <th scope="col" class="w-[10.4%]">
                                                Tipo
                                            </th>
                                            <th scope="col" class="w-[9.5%]">
                                                Projeto
                                            </th>
                                            <th scope="col" class="w-[22.2%] border-r-4 border-r-[#A3A2A3]">
                                                Prioridade
                                            </th>
                                            <th scope="col" class="w-[19%]">
                                                Observações
                                            </th>
                                            <th scope="col" class="w-[7.9%] text-center">
                                                Tempo
                                            </th>
                                            <th scope="col" class="w-[8.3%] text-center">
                                                Estado
                                            </th>
                                            <th scope="col" class="w-[7.4%] text-center">
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
                    {{-- tabela projetos pendentes --}}
                    <div class="mb-8">
                        <div class="hidden xl:block">
                            <div class="flex items-center text-white mb-4" style="width: 100%;">
                                <div class="flex-none text-white bg-projetosPendentesBanner"style="width: 70%; height: 40px; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h3 class="text-lg font-semibold">Projetos Pendentes</h3>
                                    </div>
                                    <div>
                                        <div id="togglePendentes" class="text-right collapseIcon minusIcon hover:cursor-pointer">
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tabelaProjetosPendentes" class="collapsible-content">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-[#d5d4d5]">
                                        <tr>
                                            <th scope="col" class="w-[3.8%] opacity-0 hover:cursor-default">
                                                Nº
                                            </th>
                                            <th scope="col" class="w-[11.5%]">
                                                Cliente
                                            </th>
                                            <th scope="col" class="w-[10.4%]">
                                                Tipo
                                            </th>
                                            <th scope="col" class="w-[9.5%]">
                                                Projeto
                                            </th>
                                            <th scope="col" class="w-[22.2%] border-r-4 border-r-[#A3A2A3]">
                                                Prioridade
                                            </th>
                                            <th scope="col" class="w-[19%] opacity-0 hover:cursor-default">
                                                Observações
                                            </th>
                                            <th scope="col" class="w-[7.9%] opacity-0 hover:cursor-default">
                                                Tempo
                                            </th>
                                            <th scope="col" class="w-[8.3%] text-center">
                                                Estado
                                            </th>
                                            <th scope="col" class="w-[7.4%] text-center">
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
                    {{-- tabela projetos concluidos --}}
                    <div class="mb-8">
                        <div class="hidden xl:block">
                            <div class="flex items-center text-white mb-4" style="width: 100%;">
                                <div class="flex-none text-white bg-[rgb(122,166,77)]" style="width: 70%; height: 40px; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: space-between; align-items: center;">
                                    <h3 class="text-lg font-semibold">Projetos Concluídos</h3>
                                    <div id="toggleConcluidos" class="text-right collapseIcon minusIcon hover:cursor-pointer">
                                    </div>
                                </div>
                            </div>
                            <div id="tabelaProjetosConcluidos" class="collapsible-content">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-[#d5d4d5]">
                                        <tr>
                                            <th scope="col" class="w-[3.8%] opacity-0 hover:cursor-default">
                                                Nº
                                            </th>
                                            <th scope="col" class="w-[11.5%]">
                                                Cliente
                                            </th>
                                            <th scope="col" class="w-[10.4%]">
                                                Tipo
                                            </th>
                                            <th scope="col" class="w-[9.5%]">
                                                Projeto
                                            </th>
                                            <th scope="col" class="w-[22.2%] border-r-4 border-r-[#A3A2A3]">
                                                Prioridade
                                            </th>
                                            <th scope="col" class="w-[19%]">
                                                Colaboradores
                                            </th>
                                            <th scope="col" class="w-[7.9%] text-center">
                                                Tempo
                                            </th>
                                            <th scope="col" class="w-[8.3%] text-center">
                                                Estado
                                            </th>
                                            <th scope="col" class="w-[7.4%] text-center">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- tabela projetos com outros colaboradores --}}
                    <div class="mb-8">
                        <div class="hidden xl:block">
                            <div class="flex items-center text-white mb-4" style="width: 100%;">
                                <div class="flex-none text-white bg-projetosOutrosColabBanner" style="width: 70%; height: 40px; padding: 1rem; border-radius: 0.2rem; display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h3 class="text-lg font-semibold">Projetos com Outros Colaboradores</h3>
                                    </div>
                                    <div id="toggleOutrosColabs" class="text-right collapseIcon minusIcon hover:cursor-pointer">
                                        
                                    </div>
                                </div>
                            </div>
                            <div id="tabelaProjetosOutrosColaboradores" class="collapsible-content">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-[#d5d4d5]">
                                        <tr>
                                            <th scope="col" class="w-[3.8%] opacity-0 hover:cursor-default">
                                                Nº
                                            </th>
                                            <th scope="col" class="w-[11.5%]">
                                                Cliente
                                            </th>
                                            <th scope="col" class="w-[10.4%]">
                                                Tipo
                                            </th>
                                            <th scope="col" class="w-[9.5%]">
                                                Projeto
                                            </th>
                                            <th scope="col" class="w-[22.2%] border-r-4 border-r-[#A3A2A3]">
                                                Prioridade
                                            </th>
                                            <th scope="col" class="w-[19%]">
                                                Colaboradores
                                            </th>
                                            <th scope="col" class="w-[7.9%] opacity-0 hover:cursor-default">
                                                Tempo
                                            </th>
                                            <th scope="col" class="w-[8.3%] text-center">
                                                Estado
                                            </th>
                                            <th scope="col" class="w-[7.4%] text-center">
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

    // collapse tables
    document.addEventListener('DOMContentLoaded', function(){            
        const toggleDesenvolvimento = document.getElementById('toggleDesenvolvimento');
        const tabelaProjetosAbertos = document.getElementById('tabelaProjetosAbertos');
        // ------------------------------------------------ //
        const togglePendentes = document.getElementById('togglePendentes');
        const tabelaProjetosPendentes = document.getElementById('tabelaProjetosPendentes');
        // ------------------------------------------------ //
        const toggleConcluidos = document.getElementById('toggleConcluidos');
        const tabelaProjetosConcluidos = document.getElementById('tabelaProjetosConcluidos');
        // ------------------------------------------------ //
        const toggleOutrosColabs = document.getElementById('toggleOutrosColabs');
        const tabelaProjetosOutrosColaboradores = document.getElementById('tabelaProjetosOutrosColaboradores');
        // ------------------------------------------------ //
        toggleDesenvolvimento.addEventListener('click', function () {
            handleTableCollapse(tabelaProjetosAbertos);
            toggleDesenvolvimento.classList.toggle('plusIcon');
            toggleDesenvolvimento.classList.toggle('minusIcon');
        });
        // ------------------------------------------------ //
        togglePendentes.addEventListener('click', function(){
           handleTableCollapse(tabelaProjetosPendentes); 
           togglePendentes.classList.toggle('plusIcon');
           togglePendentes.classList.toggle('minusIcon');
        });

        // ------------------------------------------------ //
        toggleConcluidos.addEventListener('click', function(){
            handleTableCollapse(tabelaProjetosConcluidos);
            toggleConcluidos.classList.toggle('plusIcon');
            toggleConcluidos.classList.toggle('minusIcon');
        });

        //------------------------------------------------ //
        toggleOutrosColabs.addEventListener('click', function(){
            handleTableCollapse(tabelaProjetosOutrosColaboradores);
            toggleOutrosColabs.classList.toggle('plusIcon');
            toggleOutrosColabs.classList.toggle('minusIcon');
        });

    });

    function handleTableCollapse(table){
    if (table.classList.contains('hidden')) {
            table.style.height = '0px';
            table.classList.remove('hidden');
            setTimeout(() => {
                table.style.height = table.scrollHeight + 'px';
            }, 10);
        } else {
            table.style.height = table.scrollHeight + 'px';
            setTimeout(() => {
                table.style.height = '0px';
            }, 10);
            table.addEventListener('transitionend', function handleTransitionEnd() {
                table.classList.add('hidden');
                table.style.height = null; // Reset the height
                table.removeEventListener('transitionend', handleTransitionEnd);
            });
        }
    }

    function handlePageReload(userProjeto) {
        const toggleFerias = document.getElementById('toggleFerias');
        const tabelaProjetosAbertosTbody = document.querySelector('#tabelaProjetosAbertos tbody');
        const responsiveDesenvolvimento = document.getElementById('responsiveDesenvolvimento');
        const disabledClass = 'disabledTable';

        toggleFerias.checked = userProjeto.vacation;

        if (userProjeto.vacation) {
            if (!tabelaProjetosAbertosTbody.classList.contains(disabledClass)) {
                tabelaProjetosAbertosTbody.classList.add(disabledClass);
                responsiveDesenvolvimento.classList.add(disabledClass);
            }
        } else {
            if (tabelaProjetosAbertosTbody.classList.contains(disabledClass)) {
                tabelaProjetosAbertosTbody.classList.remove(disabledClass);
                responsiveDesenvolvimento.classList.remove(disabledClass);
            }
        }
    }

    function textAreaKeyDown(event){
        if(event.key=='Enter' && !event.shiftKey){
            const parent = event.target;
            parent.blur();
            parent.innerHTML.slice(0,-1);
            parent.onchange();
        }
    }

    function atualizarTabelaProjetosEmAberto(userId) {
        var tdClassList = ['py-3', 'border', 'border-b'];
        
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

                        handlePageReload(userProjeto);

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
                                    <input type="hidden" name="user" value="${userProjeto.id}">
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
                                <form action="{{route('projetos.tipoCliente.create')}}" id="formNovoTipoCliente/${projeto.id}" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <input type="text" name="nome" id="newTipoClienteInput/${projeto.id}" class="w-fit" onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoCliente/atualizar" id="formAlterarTipoCliente/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
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
                                <form action="{{route('projetos.tipoProjeto.create')}}" id="formNovoTipoProjeto/${projeto.id}" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <input type="text" name="nome" id="newTipoProjetoInput/${projeto.id}" onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoProjeto/atualizar" id="formAlterarTipoProjeto/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
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
                        celulaTarefas.classList.add(...tdClassList, 'border-r-4', 'border-r-[#A3A2A3]')
                        celulaTarefas.innerHTML = '<div>' + projeto.tarefas.map(tarefa => `<p class="pl-2 break-words">${tarefa.descricao}</p>`).join("") + "</div>";

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
                                <textarea onchange='this.form.submit()'  onkeydown='textAreaKeyDown(event)' class="border-none form-input observacoes bg-transparent w-full resize-none h-16 text-start" name='observacoes' autocomplete='off'>${observacoes}</textarea>
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
                            <input value='${tempoGasto}' onChange='${this.submit}' class="border-none bg-transparent rounded-md p-2 w-full tempo-gasto text-center" autocomplete="off" pattern="[0-9]{0,4}:[0-5][0-9]" type="text" placeholder="${tempoGasto}" name="tempoGasto"/>
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
                            bgColor = 'bg-greenStatus';
                        } else if (tempoGastoMins === tempoPrevistoMinutes) {
                            bgColor = 'bg-blueStatus';
                        } else {
                            bgColor = 'bg-redStatus';
                        }
                    
                        celulaEstadoProjeto.innerHTML = `
                        <div class="${bgColor} m-auto size-6 rounded-full">
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
                            <form action="/projetos/${projeto.id}/destroy" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" {{$hasPermissions ? "" : "disabled"}} class="disabled:hover:cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500 {{$hasPermissions ? "" : "hover:text-red-700"}}">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                </button>
                            </form>
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
        var tdClassList = ['py-3', 'border', 'border-b'];

        fetch('/filtrar/projetosPendentes?colaborador_id=' + userId)
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
                        var userProjeto = projeto.users.find(user => user.id === parseInt(userId));
                        linha.setAttribute('data-id', projeto.id);
                        linha.classList.add('border-b'); // Adiciona borda à linha

                        handlePageReload(userProjeto);

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
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <select name="novoCliente" id="novoCliente/${projeto.id}" onchange="this.form.submit()" class="w-fit pl-2 pr-8 border-none focus:border-none">
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
                                <form action="{{route('projetos.tipoCliente.create')}}" id="formNovoTipoCliente/${projeto.id}" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <input type="text" name="nome" id="newTipoClienteInput/${projeto.id}"  onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoCliente/atualizar" id="formAlterarTipoCliente/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
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
                                <form action="{{route('projetos.tipoProjeto.create')}}" id="formNovoTipoProjeto/${projeto.id}" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <input type="text" name="nome" id="newTipoProjetoInput/${projeto.id}" onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoProjeto/atualizar" id="formAlterarTipoProjeto/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
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

                        var tarefas = projeto.tarefas.map(tarefa => `<p class="pl-2 break-words">${tarefa.descricao}</p>`).join("");
                        celulas[4].classList.add(...tdClassList, 'border-r-4', 'border-r-[#A3A2A3]');
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
                            bgColor = 'bg-greenStatus';
                        } else if (tempoGastoMins === tempoPrevistoMinutes) {
                            bgColor = 'bg-blueStatus';
                        } else {
                            bgColor = 'bg-redStatus';
                        }
                        celulaEstadoProjeto.innerHTML =
                            `<div class="${bgColor} m-auto size-6 rounded-full">
                            </div>`;
                            
                        var celulaAcoes = celulas[8];
                        celulaAcoes.innerHTML = `
                        <div class="flex justify-center items-center space-x-4">
                            <a href="/projetos/${projeto.id}/edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <form action="/projetos/${projeto.id}/destroy" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" {{$hasPermissions ? "" : "disabled"}} class="disabled:hover:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500 {{$hasPermissions ? "" : "hover:text-red-700"}}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
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

    function atualizarTabelaProjetosConcluidos(userId){

        var tdClassList = ['py-3', 'border', 'border-b'];

        fetch('/filtrar/projetosConcluidos?colaborador_id=' + userId)
            .then(response => response.json())
            .then(data => {
                var tbodyConcluidos = document.querySelector('#tabelaProjetosConcluidos tbody');

                
                tbodyConcluidos.innerHTML = '';

                data.projetos.forEach((projeto) => {
                    // Para separação do design para computador / mobile
                    if(true){
                        var linha = tbodyConcluidos.insertRow();
                        var userProjeto = projeto.users.find(user => user.id === parseInt(userId));
                        linha.setAttribute('data-id', projeto.id);
                        linha.classList.add('border-b'); // Adiciona borda à linha

                        handlePageReload(userProjeto);

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
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <select name="novoCliente" id="novoCliente/${projeto.id}" onchange="this.form.submit()" class="w-fit pl-2 pr-8 border-none focus:border-none">
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
                                <form action="{{route('projetos.tipoCliente.create')}}" id="formNovoTipoCliente/${projeto.id}" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <input type="text" name="nome" id="newTipoClienteInput/${projeto.id}"  onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoCliente/atualizar" id="formAlterarTipoCliente/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
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
                                <form action="{{route('projetos.tipoProjeto.create')}}" id="formNovoTipoProjeto/${projeto.id}" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <input type="text" name="nome" id="newTipoProjetoInput/${projeto.id}" onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoProjeto/atualizar" id="formAlterarTipoProjeto/${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
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

                        var tarefas = projeto.tarefas.map(tarefa => `<p class="pl-2 break-words">${tarefa.descricao}</p>`).join("");
                        celulas[4].classList.add(...tdClassList, 'border-r-4', 'border-r-[#A3A2A3]');
                        celulas[4].innerHTML = "<div>" + tarefas + "</div>";

                        var disabled = projeto.users.length == data.colaboradores.length ? "disabled" : "";
                        var selectColabs = `
                        <div class="flex items-end">
                            <div id="colaboradorCell/:id" class="colaboradorCell">`;
                        projeto.users.forEach(u => {
                            selectColabs += `    
                                <form action="{{ route('projetos.colaboradores.atualizar', ':id') }}" method="POST" class="my-0 py-0" >
                                @csrf
                                @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <div class="flex items-center p-1">
                                        <select name="novoColaborador" id=:id onchange="this.form.submit()" class="w-full pl-2 pr-8 border-none focus:border-none" :disabled>
                                `;

                                data.colaboradores.forEach(c => {
                                    var userIsColaborator = projeto.users.some(user => user.id === c.id);
                                    var isSelected = u.id === c.id;

                                    if (!userIsColaborator || isSelected) {
                                        selectColabs += `
                                            <option value='${c.id}/${u.id}' class="w-full" ${isSelected ? ' selected' : ''}>
                                                ${c.name}
                                            </option>`;
                                    }
                                });

                                selectColabs += `
                                        </select>
                                    </div>
                                </form>`;
                        });

                        selectColabs += `
                                <form action="{{ route('projetos.colaboradores.adicionar', ':id') }}" id="newColaboradorForm/:id" method="POST" class="hidden my-0 py-0">
                                @csrf
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userId}">
                                    <div class="flex items-center border-t border-gray-400 p-1">
                                        <select name="novoColaboradorId" id=":id" onchange="this.form.submit()" class="w-full pl-2 pr-10 border-none focus:border-none">
                                            <option disabled selected>...</option>`;
                                            data.colaboradores.forEach(c => {
                                                if(!projeto.users.some(user => user.id === c.id)){
                                                    selectColabs += `
                                                    <option value="${c.id}" class="w-full">
                                                        ${c.name}
                                                    </option>`;
                                                }
                                            });

                        selectColabs += `
                                        </select>
                                    </div>
                                </form>`;

                        selectColabs += `
                            </div>
                            <div class="my-0 mx-3 :hidden">
                                <button id=:id class="btn-adicionar-colaborador" onclick="addNewColaboradorField(:id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                    </svg>                                                                      
                                </button>
                            </div>
                        </div>
                        `;

                        selectColabs = selectColabs.replaceAll(':id', projeto.id);
                        selectColabs = selectColabs.replaceAll(':disabled', disabled);
                        selectColabs = selectColabs.replaceAll(':hidden', projeto.users.length == data.colaboradores.length ? 'hidden' : '');
                        celulas[5].innerHTML = selectColabs;


                        var tempoGasto = userProjeto ? userProjeto.pivot.tempo_gasto : '00:00';
                        
                        var div = document.createElement('div');
                        div.innerHTML = `
                        <form action="/projetos/${projeto.id}/${userId}/updateTimeSpent" method="POST" class="m-auto w-[100px] justify-center">
                            @csrf
                            @method('PUT')
                            <input value='${tempoGasto}' onChange='${this.submit}' class="border-none bg-transparent rounded-md p-2 w-full tempo-gasto text-center" autocomplete="off" pattern="[0-9]{0,4}:[0-5][0-9]" type="text" placeholder="${tempoGasto}" name="tempoGasto">
                        </form>
                        `;

                        var tempoCum = 0;
                        projeto.users.forEach(u => {
                            data.colaboradores.forEach(c => {
                                if(c.id == u.id){
                                    var t = u.pivot.tempo_gasto;
                                    if (t) {
                                        var HHmm = t.split(":");
                                        var h = parseInt(HHmm[0], 10);
                                        var m = parseInt(HHmm[1], 10);

                                        tempoCum += h * 60 + m;
                                    }
                                }
                            })
                        })
                        
                        var h = Math.floor(tempoCum/60);
                        var m = tempoCum % 60;

                        var hh = h.toString().padStart(2, '0');
                        var mm = m.toString().padStart(2, '0');

                        tempoCum = `${hh}:${mm}`;

                        celulas[6].classList.add('border-l-0');
                        celulas[6].innerHTML = `
                        <div class="m-auto text-center">
                            ${tempoCum}
                        </div>
                        `;

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
                            bgColor = 'bg-greenStatus';
                        } else if (tempoGastoMins === tempoPrevistoMinutes) {
                            bgColor = 'bg-blueStatus';
                        } else {
                            bgColor = 'bg-redStatus';
                        }
                        celulaEstadoProjeto.innerHTML =
                            `<div class="${bgColor} m-auto size-6 rounded-full">
                            </div>`;
                            
                        var celulaAcoes = celulas[8];
                        celulaAcoes.innerHTML = `
                        <div class="flex justify-center items-center space-x-4">
                            <a href="/projetos/${projeto.id}/edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <form action="/projetos/${projeto.id}/destroy" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" {{$hasPermissions ? "" : "disabled"}} class="disabled:hover:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500 {{$hasPermissions ? "" : "hover:text-red-700"}}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
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
                data.projetos.forEach((projeto) => {
                    // Para separação do design para computador / mobile
                    if(true){
                        var linha = tbodyOutrosColaboradores.insertRow();
                        linha.classList.add('border-b'); // Adiciona borda à linha
                        var userProjeto = projeto.users.find(user => user.id === parseInt(userId));

                        handlePageReload(userProjeto);

                        var celulas = [];

                        for (let i = 0; i < 9; i++) {
                            celulas[i] = linha.insertCell(i);
                            celulas[i].classList.add('py-3');
                        }

                        celulas[0].classList.add('border-r-0', 'invisible');
                        celulas[1].innerHTML = `
                        <div class="flex items-end">
                            <div>
                                <form action="/projetos/${projeto.id}/cliente/atualizar" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <select name="novoCliente" id="novoCliente/colab${projeto.id}" onchange="this.form.submit()" class="w-fit pl-2 pr-8 border-none focus:border-none">
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
                                <form action="{{route('projetos.tipoCliente.create')}}" id="formNovoTipoCliente/colab${projeto.id}" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <input type="text" name="nome" id="newTipoClienteInput/${projeto.id}"  onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoCliente/atualizar" id="formAlterarTipoCliente/colab${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <select name="novoTipoCliente" id="novoTipoCliente/colab${projeto.id}" onchange="handleTipoClienteForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
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
                                <form action="{{route('projetos.tipoProjeto.create')}}" id="formNovoTipoProjeto/colab${projeto.id}" class="my-0 py-0 hidden">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <input type="text" name="nome" id="newTipoProjetoInput/${projeto.id}" onchange="${this.submit}">
                                </form>
                                <form action="/projetos/${projeto.id}/tipoProjeto/atualizar" id="formAlterarTipoProjeto/colab${projeto.id}" method="POST" class="my-0 py-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <select name="novoTipoProjeto" id="novoTipoProjeto/colab${projeto.id}" onchange="handleTipoProjetoForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                        @foreach($tiposProjeto as $tP)
                                            <option value="{{$tP->id}}">{{$tP->nome}}</option>
                                        @endforeach
                                        <option value="-1" class="font-black">Novo</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        `;

                        var tarefas = projeto.tarefas.map(tarefa => `<p class="pl-2 break-words">${tarefa.descricao}</p>`).join("");
                        celulas[4].classList.add('border-r-4', 'border-r-[#A3A2A3]');
                        celulas[4].innerHTML = "<div>" + tarefas + "</div>";

                        var disabled = projeto.users.length == data.colaboradores.length ? "disabled" : "";
                        var selectColabs = `
                        <div class="flex items-end">
                            <div id="colaboradorCell/:id" class="colaboradorCell">`;
                        projeto.users.forEach(u => {
                            selectColabs += `    
                                <form action="{{ route('projetos.colaboradores.atualizar', ':id') }}" method="POST" class="my-0 py-0" >
                                @csrf
                                @method('PUT')
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userProjeto.id}">
                                    <div class="flex items-center p-1">
                                        <select name="novoColaborador" id=:id onchange="this.form.submit()" class="w-full pl-2 pr-8 border-none focus:border-none" :disabled>
                                `;

                                data.colaboradores.forEach(c => {
                                    var userIsColaborator = projeto.users.some(user => user.id === c.id);
                                    var isSelected = u.id === c.id;

                                    if (!userIsColaborator || isSelected) {
                                        selectColabs += `
                                            <option value='${c.id}/${u.id}' class="w-full" ${isSelected ? ' selected' : ''}>
                                                ${c.name}
                                            </option>`;
                                    }
                                });

                                selectColabs += `
                                        </select>
                                    </div>
                                </form>`;
                        });

                        selectColabs += `
                                <form action="{{ route('projetos.colaboradores.adicionar', ':id') }}" id="newColaboradorForm/:id" method="POST" class="hidden my-0 py-0">
                                @csrf
                                    <input type="hidden" name="origin" value="prioridades">
                                    <input type="hidden" name="user" value="${userId}">
                                    <div class="flex items-center border-t border-gray-400 p-1">
                                        <select name="novoColaboradorId" id=":id" onchange="this.form.submit()" class="w-full pl-2 pr-10 border-none focus:border-none">
                                            <option disabled selected>...</option>`;
                                            data.colaboradores.forEach(c => {
                                                if(!projeto.users.some(user => user.id === c.id)){
                                                    selectColabs += `
                                                    <option value="${c.id}" class="w-full">
                                                        ${c.name}
                                                    </option>`;
                                                }
                                            });

                        selectColabs += `
                                        </select>
                                    </div>
                                </form>`;

                        selectColabs += `
                            </div>
                            <div class="my-0 mx-3 :hidden">
                                <button id=:id class="btn-adicionar-colaborador" onclick="addNewColaboradorField(:id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                    </svg>                                                                      
                                </button>
                            </div>
                        </div>
                        `;

                        selectColabs = selectColabs.replaceAll(':id', projeto.id);
                        selectColabs = selectColabs.replaceAll(':disabled', disabled);
                        selectColabs = selectColabs.replaceAll(':hidden', projeto.users.length == data.colaboradores.length ? 'hidden' : '');
                        celulas[5].innerHTML = selectColabs;
                        
                        celulas[6].classList.add('border-r-0');

                        var celulaEstadoProjeto = celulas[7];
                        celulaEstadoProjeto.classList.add('border-r-0');

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
                            bgColor = 'bg-greenStatus';
                        } else if (tempoGastoMins === tempoPrevistoMinutes) {
                            bgColor = 'bg-blueStatus';
                        } else {
                            bgColor = 'bg-redStatus';
                        }

                        celulaEstadoProjeto.innerHTML =
                            `<div class="${bgColor} m-auto size-6 rounded-full">
                            </div>`;

                        var celulaAcoes = celulas[8];
                        celulaAcoes.innerHTML = `
                        <div class="flex justify-center items-center space-x-4">
                            <a href="/projetos/${projeto.id}/edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:tet-blue-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <form action="/projetos/${projeto.id}/destroy" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" {{$hasPermissions ? "" : "disabled"}} class="disabled:hover:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500 {{$hasPermissions ? "" : "hover:text-red-700"}}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        `;
                        
                        var select = document.querySelector(`#novoCliente\\/colab${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.cliente.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }

                        var select = document.querySelector(`#novoTipoCliente\\/colab${projeto.id}`);
                        var options = select.options;
                        for (var i = 0; i < options.length; i++) {
                            if (options[i].text === projeto.tipo_cliente.nome) {
                                options[i].selected = true;
                                break;
                            }
                        }

                        var select = document.querySelector(`#novoTipoProjeto\\/colab${projeto.id}`);
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
        atualizarTabelaProjetosConcluidos(userId);
    }

    var colaboradorCell = document.getElementsByClassName("colaboradorCell");

    function addNewColaboradorField(id){
        var colaboradorCell = document.getElementById("colaboradorCell/" + id);
        console.log('newColaboradorForm/' + id);
        document.getElementById('newColaboradorForm/' + id).classList.remove('hidden');
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

        var el5 = document.getElementById('tabelaProjetosConcluidos').getElementsByTagName('tbody')[0];
        var sortable = new Sortable(el5, {
            chosenClass: 'chosenDraggable',
            group: 'shared',
            sort: false,
            ghostClass: 'bg-gray-300',
            animation: 150,
            onAdd: function(evt){
                var item = evt.item;
                var projetosData = [];
                var userId = document.getElementById('colaborador').value; // Obtém o user_id do dropdown de colaboradores

                projetosData.push({
                    id: item.getAttribute('data-id'),
                    user_id: userId,
                    estado: 5
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
            document.getElementById("formNovoTipoCliente/" + id.split('/')[1]).classList.remove("hidden");
        }else{
            document.getElementById('formAlterarTipoCliente/' + id.split('/')[1]).submit();
        }
    }

    function handleTipoProjetoForms(id){
        var select = document.getElementById(id);

        if(select.value == -1){
            select.classList.add("hidden")
            document.getElementById("formNovoTipoProjeto/" + id.split('/')[1]).classList.remove("hidden");
        }else{
            document.getElementById('formAlterarTipoProjeto/' + id.split('/')[1]).submit();
        }
    }
</script>