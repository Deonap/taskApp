document.addEventListener("DOMContentLoaded", function () {
    var userId = document.getElementById('colaborador').value
    atualizarTabelas(userId)
});

document.getElementById('colaborador').addEventListener('change', function () {
    var userId = this.value;
    atualizarTabelas(userId);
});

function atualizarTabelaProjetosEmAberto(userId) {
    fetch('/filtrar/projetos?colaborador_id=' + userId)
        .then(response => response.json())
        .then(data => {
            var tbody = document.querySelector('#tabelaProjetosAbertos tbody');
            tbody.innerHTML = '';

            data.forEach((projeto) => {
                var linha = tbody.insertRow();
                linha.setAttribute('data-id', projeto.id);

                // Encontra o usuário específico e sua prioridade
                var userProjeto = projeto.users.find(user => user.id === parseInt(userId));
                var prioridade = userProjeto ? userProjeto.pivot.prioridade : 'N/A';


                var celulaPrioridade = linha.insertCell(0);
                celulaPrioridade.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
                celulaPrioridade.innerHTML = prioridade;


                var celulaCliente = linha.insertCell(1);
                celulaCliente.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
                celulaCliente.innerHTML = projeto.cliente && projeto.cliente.nome ? projeto.cliente.nome : 'Cliente não especificado';


                var celulaTipoCliente = linha.insertCell(2);
                celulaTipoCliente.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
                celulaTipoCliente.innerHTML = projeto.tipo_cliente && projeto.tipo_cliente.nome ? projeto.tipo_cliente.nome : 'Tipo não especificado';


                var celulaNomeProjeto = linha.insertCell(3);
                celulaNomeProjeto.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
                celulaNomeProjeto.innerHTML = projeto.nome;

                var celulaTarefas = linha.insertCell(4);
                celulaTarefas.innerHTML = projeto.tarefas.map(tarefa => `<p>${tarefa.descricao}</p>`).join("");
                celulaTarefas.classList.add('border');


                var userProjeto = projeto.users.find(user => user.id == userId);
                var observacoes = userProjeto ? userProjeto.pivot.observacoes : 'Sem observações';
                var celulaObservacoes = linha.insertCell();
                celulaObservacoes.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
                var textareaObservacoes = document.createElement('textarea');
                textareaObservacoes.classList.add('observacoes', 'border', 'border-gray-300', 'rounded-md', 'w-full', 'resize-none', 'h-16', 'overflow-y-auto');
                textareaObservacoes.value = observacoes;
                celulaObservacoes.appendChild(textareaObservacoes);


                var tempoGasto = userProjeto ? userProjeto.pivot.tempo_gasto : '';
                var celulaTempoGasto = linha.insertCell();
                celulaTempoGasto.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
                var inputTempoGasto = document.createElement('input');
                inputTempoGasto.type = 'text';
                inputTempoGasto.classList.add('tempo-gasto', 'border', 'border-gray-300', 'rounded-md', 'p-2', 'w-full');
                inputTempoGasto.value = tempoGasto;
                celulaTempoGasto.appendChild(inputTempoGasto);

                /* 
                <td class="border px-4 py-2">
                    <div style="background-color: {{ $projeto->estadoProjeto->cor }}; class="m-auto size-7 rounded-full">
                    </div>
                </td>
                */
                var celulaEstadoProjeto = linha.insertCell(7);
                celulaEstadoProjeto.classList.add('border', 'px-4', 'py-2');
                celulaEstadoProjeto.innerHTML =
                    `<div style="background-color: ${projeto.estado_projeto.cor};" class="m-auto size-7 rounded-full">
                    </div>`;


                var celulaAcoes = linha.insertCell(8);
                celulaAcoes.classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap', 'border-b');
                celulaAcoes.innerHTML = `
                    <div style="display: flex; align-items: center;">
                        <a href="/projetos/${projeto.id}/edit" class="text-indigo-600 hover:text-indigo-900 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <form action="/projetos/${projeto.id}/destroy" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            </button>
                        </form>
                    </div>
                    `;

            });
        });
}

function atualizarTabelaProjetosPendentes(userId) {
    fetch('/filtrar/projetospendentes?colaborador_id=' + userId)
        .then(response => response.json())
        .then(data => {
            var tbodyPendentes = document.querySelector('#tabelaProjetosPendentes tbody');
            tbodyPendentes.innerHTML = '';

            data.forEach((projeto) => {
                var linha = tbodyPendentes.insertRow();
                linha.setAttribute('data-id', projeto.id);
                linha.classList.add('border-b'); // Adiciona borda à linha

                var celulas = [];

                for (let i = 0; i < 6; i++) {
                    celulas[i] = linha.insertCell(i);
                    celulas[i].classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap');
                }

                celulas[0].innerHTML = projeto.cliente && projeto.cliente.nome ? projeto.cliente.nome : 'Cliente não especificado';
                celulas[1].innerHTML = projeto.tipo_cliente ? projeto.tipo_cliente.nome : 'Tipo não especificado';
                celulas[2].innerHTML = projeto.nome;

                var tarefas = projeto.tarefas.map(tarefa => tarefa.descricao).join(", ");
                celulas[3].innerHTML = tarefas;


                var celulaEstadoProjeto = celulas[4];
                celulaEstadoProjeto.innerHTML =
                    `<div style="background-color: ${projeto.estado_projeto.cor};" class="m-auto size-7 rounded-full">
                    </div>`;
                    

                var celulaAcoes = celulas[5];
                celulaAcoes.innerHTML = `
            <div style="display: flex; align-items: center;">
                    <a href="/projetos/${projeto.id}/edit" class="text-indigo-600 hover:text-indigo-900 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </a>
                    <form action="/projetos/${projeto.id}/destroy" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>
            `;
            });
        });
}

function atualizarTabelaProjetosComOutrosColaboradores(userId) {
    fetch('/filtrar/projetos-outros-colaboradores/' + userId)
        .then(response => response.json())
        .then(data => {

            var tbodyOutrosColaboradores = document.querySelector('#tabelaProjetosOutrosColaboradores tbody');
            tbodyOutrosColaboradores.innerHTML = '';

            data.forEach((projeto) => {
                var linha = tbodyOutrosColaboradores.insertRow();
                linha.classList.add('border-b'); // Adiciona borda à linha

                var celulas = [];

                for (let i = 0; i < 7; i++) {
                    celulas[i] = linha.insertCell(i);
                    celulas[i].classList.add('border', 'px-3', 'py-4', 'whitespace-nowrap');
                }

                celulas[0].innerHTML = projeto.cliente.nome;
                celulas[1].innerHTML = projeto.tipo_cliente ? projeto.tipo_cliente.nome : 'Tipo não especificado';
                celulas[2].innerHTML = projeto.nome;

                var tarefas = projeto.tarefas.map(tarefa => tarefa.descricao).join(", ");
                celulas[3].innerHTML = tarefas;

                
                // Lista todos os colaboradores associados ao projeto
                var colaboradores = projeto.users.map(user => user.name).join(", ");
                celulas[4].innerHTML = colaboradores;


                /* 
                <td class="border px-4 py-2">
                    <div style="background-color: {{ $projeto->estadoProjeto->cor }}; class="m-auto size-7 rounded-full">
                    </div>
                </td>
                */
                // var celulaEstadoProjeto = linha.insertCell(7);
                // celulaEstadoProjeto.classList.add('border', 'px-4', 'py-2');
                // celulaEstadoProjeto.innerHTML =
                //     `<div style="background-color: ${projeto.estado_projeto.cor};" class="m-auto size-7 rounded-full">
                //     </div>`;

                var celulaEstadoProjeto = celulas[5];
                celulaEstadoProjeto.innerHTML =
                    `<div style="background-color: ${projeto.estado_projeto.cor};" class="size-7 rounded-full">
                    </div>`;


                var celulaAcoes = celulas[6];
                celulaAcoes.innerHTML = `
                <div style="display: flex; align-items: center;">
                    <a href="/projetos/${projeto.id}/edit" class="text-indigo-600 hover:text-indigo-900 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </a>
                    <form action="/projetos/${projeto.id}/destroy" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>
            `;
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
                estado: 6
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
                estado: 7
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

document.getElementById('salvarPrioridades').addEventListener('click', function () {
    var userId = document.getElementById('colaborador').value; // Obter o user_id do dropdown
    var projetosData = [];

    document.querySelectorAll('#tabelaProjetosAbertos tbody tr').forEach(function (row) {
        var projetoId = row.getAttribute('data-id');
        var observacoes = row.querySelector('.observacoes').value;
        var tempoGasto = row.querySelector('.tempo-gasto').value;

        projetosData.push({
            id: projetoId,
            user_id: userId, // Usar o mesmo user_id para todos os projetos
            observacoes: observacoes,
            tempoGasto: tempoGasto
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
    var tabelaPrioridadesAberto = document.querySelector('#tabelaProjetosAbertos tbody');
    tabelaPrioridadesAberto.classList.toggle('disabledTable');
});