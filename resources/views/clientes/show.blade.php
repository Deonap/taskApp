<html lang='en'>
    <head>
        <style>
            .content-margin {
                margin: 50px;
                /* Outros estilos conforme necessário */
            }
            .btn-selecionar-colaborador,
            .btn-adicionar-colaborador {
                margin-left: 5px;
                cursor: pointer;
                background: none;
                border: none;
                padding: 0;
            }
            th{
                padding: 0.5rem 1rem 0.5rem 1rem;
                text-align: left;
                font-weight: 800;
            }
            td{
                padding: 0.5rem 1rem 0.5rem 1rem;
            }
            table{
                table-layout: fixed;
                width: 100%;
            }
            form{
                margin:auto;
            }
        </style>
    </head>
    <?php
        $hasPermissions = auth()->user() && auth()->user()->tipo == 'admin';
    ?>
    <body>
        <x-app-layout>
            <div>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center text-darkBlue">
                        <h2 class="hidden md:block text-xl font-black">
                            Clientes >
                        </h2>
                        <div class="text-xl font-black md:text-base md:font-normal ml-2">
                            Ver Cliente
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mb-4 lg:flex lg:items-center w-fit">
                        <div class="flex items-center w-full mt-3 lg:mt-0">
                            <label for="nome" class="mr-3 lg:ml-3 lg:mt-0">
                                Nome
                            </label>
                            <input disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nome" autocomplete='off' type="text" name="nome" placeholder="{{$cliente->nome}}">
                        </div>
                        <div class="flex items-center w-full mt-3 lg:mt-0">
                            <label for="email" class="mr-3 lg:ml-3 lg:mt-0">
                                Email
                            </label>
                            <input disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" autocomplete='off' type="email" name="email" placeholder={{$cliente->email}}>
                        </div>
                        <div class="flex items-center w-full mt-3 lg:mt-0">    
                            <label for="telefone" class="mr-3 lg:ml-3 lg:mt-0">
                                Telefone 
                            </label>
                            <input disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telefone" autocomplete='off' type="text" name="telefone" placeholder={{$cliente->telefone}}>
                        </div>
                    </div>
                    <div class="my-10">
                        <button id="btnProjetosAbertos" class="{{$window == 'projetosAbertos' ? 'bg-darkBlue' : 'bg-gray-400'}} text-white py-2 px-4 rounded mr-4">
                            <div class="hidden md:block">
                                Projetos Abertos/Pendentes
                            </div>
                            <div class="block md:hidden">
                                Projetos Abertos
                            </div>
                        </button>
                        <button id="btnProjetosConcluidos" class="{{$window == 'projetosConcluidos' ? 'bg-darkBlue' : 'bg-gray-400'}} text-white py-2 px-4 rounded mt-5">
                            Projetos Concluídos
                        </button>
                    </div>
                    <div id="tabelaProjetosAbertos" class="{{$window == 'projetosAbertos' ? '' : 'hidden' }}">
                        <div class="hidden xl:block">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-300">
                                        <th scope="col" class="w-[15%]">
                                            Tipo
                                        </th>
                                        <th scope="col" class="w-[13%]">
                                            Projeto
                                        </th>
                                        <th scope="col" class="w-[14%]">
                                            Notas Iniciais
                                        </th>
                                        <th scope="col" class="text-center w-[13%]">
                                            Tempo Previsto
                                        </th>
                                        <th scope="col" class="w-[20%]">
                                            Colaborador
                                        </th>
                                        <th scope="col" class="text-center w-[15%]">
                                            Tempo Investido
                                        </th>
                                        <th scope="col" class="w-[10%] text-right pr-[5rem]">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="projetosAbertosTbody">
                                    @foreach($projetosAbertos as $projeto)
                                        <tr class="border-b-4 border-b-[#d1d1d1]">
                                            <td>
                                                <div class="flex items-end">
                                                    <div>
                                                        <form action="{{route('projetos.tipoCliente.create')}}" id="formNovoTipoCliente/{{$projeto->id}}" class="my-0 py-0 hidden">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosAbertos">
                                                            <input type="text" name="cliente_id" value="{{$cliente->id}}" class="hidden">
                                                            <input type="text" name="nome" id="newTipoClienteInput/{{$projeto->id}}"  onchange="this.form.submit()">
                                                        </form>
                                                        <form action="{{route('projetos.tipoCliente.atualizar', $projeto->id)}}" id="formAlterarTipoCliente/{{$projeto->id}}" method="POST" class="my-0 py-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosAbertos">
                                                            <select name="novoTipoCliente" id="novoTipoCliente/{{$projeto->id}}" onchange="handleTipoClienteForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                                                @foreach($tiposCliente as $tC)
                                                                    <option value="{{$tC->id}}" {{$tC->nome == $projeto->tipoCliente->nome ? "selected" : ""}}>{{$tC->nome}}</option>
                                                                @endforeach
                                                                <option value="-1" class="font-black">Novo</option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>                                                
                                            </td>
                                            <td>
                                                <div class="flex items-end">
                                                    <div>
                                                        <form action="{{route('projetos.tipoProjeto.create')}}" id="formNovoTipoProjeto/{{$projeto->id}}" class="my-0 py-0 hidden">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosAbertos">

                                                            <input type="text" name="cliente_id" value={{$cliente->id}} class="hidden">
                                                            <input type="text" name="nome" id="newTipoProjetoInput/{{$projeto->id}}" onchange="this.form.submit()">
                                                        </form>
                                                        <form action="{{route('projetos.tipoProjeto.atualizar', $projeto->id)}}" id="formAlterarTipoProjeto/{{$projeto->id}}" method="POST" class="my-0 py-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosAbertos">
                                                            <select name="novoTipoProjeto" id="novoTipoProjeto/{{$projeto->id}}" onchange="handleTipoProjetoForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                                                @foreach($tipoProjeto as $tP)
                                                                    <option value="{{$tP->id}}" {{$tP->nome == $projeto->tipoProjeto->nome ? "selected" : ""}}>{{$tP->nome}}</option>
                                                                @endforeach
                                                                <option value="-1" class="font-black">Novo</option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{$projeto->notas_iniciais}}
                                            </td>
                                            <td class="text-center">
                                                {{ $projeto->tempo_previsto }}
                                            </td>
                                            <td>
                                                <div class="flex items-end">
                                                    <div>
                                                        @foreach($projeto->users as $user)
                                                            <form action="{{ route('projetos.colaboradores.atualizar', $projeto->id) }}" method="POST" class="my-0 py-0">
                                                            @csrf
                                                            @method('PUT')
                                                                <input type="hidden" name="origin" value="clientes">
                                                                <input type="hidden" name="window" value="projetosAbertos">
                                                                <div class="flex items-center @if(!$loop->last) border-b border-gray-400 @endif p-1">
                                                                    <select name="novoColaborador" id={{$projeto->id}} onchange="this.form.submit()" {{$projeto->users->count() == $colaboradores->count() ? 'disabled' : ''}} class="w-full pl-2 pr-10 border-none focus:border-none">
                                                                        @foreach($colaboradores as $colaborador)
                                                                            @if(!$projeto->users->contains($colaborador) || $colaborador->id == $user->id)
                                                                                <option value="{{$colaborador->id}}/{{$user->id}}" class="w-full" {{$colaborador->id == $user->id ? 'selected' : ''}}>{{ $colaborador->name }}</option>        
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </form>
                                                        @endforeach
                                                        {{-- newColaborador --}}
                                                        <form action="{{ route('projetos.colaboradores.adicionar', $projeto->id) }}" id="newColaboradorForm/{{$projeto->id}}" method="POST" class="hidden my-0 py-0">
                                                        @csrf
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosAbertos">
                                                            <div class="flex items-center border-t border-gray-400 p-1">
                                                                <select name="novoColaboradorId" id="{{$projeto->id}}" onchange="this.form.submit()" class="w-full pl-2 pr-10 border-none focus:border-none">
                                                                    <option disabled selected>...</option>
                                                                    @foreach($colaboradores as $colaborador)
                                                                        @if(!$projeto->users->contains($colaborador))
                                                                            <option value="{{$colaborador->id}}" class="w-full">{{ $colaborador->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="my-0 mx-3 {{$projeto->users->count() == $colaboradores->count() ? 'hidden' : ''}}">
                                                        <button id="{{$projeto->id}}" class="btn-adicionar-colaborador" data-origin="projetosAbertos">
                                                            <!-- + -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                                            </svg>                                                                      
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="flex justify-center space-x-3">
                                                    <div>
                                                        @foreach($projeto->users as $user)
                                                            <div class="text-center @if(!$loop->last) border-b border-gray-400 @endif p-1">
                                                                {{ $user->tempoGasto($projeto) }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="rounded-full size-6 m-auto">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex justify-end pr-[3rem] space-x-3">
                                                    <a href="{{ route('projetos.edit', $projeto->id) }}" title="Editar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST" onsubmit="return confirm('Tem a certeza?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" {{$hasPermissions ? "" : 'disabled'}} class="disabled:cursor-not-allowed">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500 {{$hasPermissions ? '' : 'hover:text-red-700'}}">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="hidden" id="newProjectRow">
                                        <form method="POST" action="{{ route('projetos.store') }}" autocomplete="off">
                                        @csrf
                                            <input class="hidden" name="cliente_id" value="{{$cliente->id}}">
                                            <td>
                                                <div class="flex items-end">
                                                    <div>
                                                        <select name="tipo_cliente_id" class="w-fit pl-2 pr-8 py-2">
                                                            <option selected disabled>...</option>
                                                            @foreach($tiposCliente as $tC)
                                                                <option value="{{$tC->id}}">{{$tC->nome}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>                                                
                                            </td>
                                            <td>
                                                <div class="flex items-end">
                                                    <div>
                                                        <select name="tipo_projeto_id" class="w-fit pl-2 pr-8 py-2">
                                                            <option selected disabled>...</option>
                                                            @foreach($tipoProjeto as $tP)
                                                                <option value={{$tP->id}}>{{$tP->nome}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="notas_iniciais">
                                            </td>
                                            <td class="text-center w-full">
                                                <input type="text" class="text-center w-full" placeholder="hh:mm" name="tempo_previsto" pattern="[0-9]{0,4}:[0-5][0-9]">
                                            </td>
                                            <td>
                                                <div class="flex items-end">
                                                    <div>
                                                        <div class="flex items-center p-1">
                                                            <select name="users[]" class="w-fit pl-2 pr-8 py-2">
                                                                <option selected disabled value="">...</option>
                                                                @foreach($colaboradores as $colaborador)
                                                                    <option value="{{$colaborador->id}}" class="w-fit">{{$colaborador->name}}</option>        
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                            </td>
                                            <td class="flex justify-end pr-[3rem]">
                                                <button type="submit" onclick="this.form.submit()" class="m-auto font-bold py-2 px-4 rounded bg-darkBlue text-white hover:cursor-pointer">
                                                    Adicionar
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="block xl:hidden space-y-3 h-fit">
                            <div class="sm:flex space-y-3 sm:space-y-0 sm:space-x-3">
                                @foreach($projetosAbertos as $projeto)
                                    <div class="min-h-fit w-full flex items-start shadow-lg border-4 p-4">
                                        <div class="w-full">
                                            <div class="flex justify-between items-center">
                                                <h1 class="font-black">
                                                    {{$projeto->tipoCliente->nome}}
                                                </h1>
                                                @if($hasPermissions)
                                                    <div class="flex justify-center space-x-3">
                                                        <a href="{{ route('projetos.edit', $projeto->id) }}" title="Editar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </a>
                                                        <form method="POST" action="{{ route('projetos.destroy', $projeto->id) }}" class="m-auto" title="Remover">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Tem a certeza?')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mt-3">
                                                <h2 class="font-bold">
                                                    {{$projeto->nome}}
                                                </h2>
                                            </div>
                                            <div class="mt-4 flex items-center">
                                                <div>
                                                    <a class="bg-darkBlue text-white py-2 px-4 rounded mr-4 hover:cursor-pointer" onclick="openModal('modal_{{$projeto->id}}')">
                                                        Tarefas
                                                    </a>
                                                    <div id="modal_{{$projeto->id}}" class="modal fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 m-auto ">
                                                        <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white w-fit">
                                                            <div class="flex justify-end p-2">
                                                                <button onclick="closeModal('modal_{{$projeto->id}}')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                    
                                                            <div class="p-6 pt-0 text-center">
                                                                @foreach($projeto->tarefas as $tarefa)
                                                                    <div>
                                                                        {{ $tarefa->descricao }}
                                                                    </div>  
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass" viewBox="0 0 16 16">
                                                        <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702c0 .7-.478 1.235-1.011 1.491A3.5 3.5 0 0 0 4.5 13v1h7v-1a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351v-.702c0-.7.478-1.235 1.011-1.491A3.5 3.5 0 0 0 11.5 3V2z"/>
                                                    </svg>
                                                    {{$projeto->tempo_previsto}}
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                @foreach($projeto->users as $user)
                                                    <div>
                                                        <div class="w-fit py-2 mr-4 flex items-center">
                                                            <div>
                                                                {{$user->name}}
                                                            </div>
                                                            <div class="flex items-center"> 
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class=" ml-4 bi bi-stopwatch" viewBox="0 0 16 16">
                                                                    <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5z"/>
                                                                    <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64l.012-.013.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5M8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3"/>
                                                                </svg>
                                                                <div>
                                                                    {{$user->tempoGasto($projeto)}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="tabelaProjetosConcluidos" class="{{$window == 'projetosConcluidos' ? '' : 'hidden' }}">
                        <div class="hidden xl:block">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-300">
                                        <th scope="col" class="w-[15%]">
                                            Tipo
                                        </th>
                                        <th scope="col" class="w-[13%]">
                                            Projeto
                                        </th>
                                        <th scope="col" class="w-[14%]">
                                            Notas Iniciais
                                        </th>
                                        <th class="text-center w-[13%]">
                                            Tempo Previsto
                                        </th>
                                        <th scope="col" class="w-[20%]">
                                            Colaborador
                                        </th>
                                        <th class="text-center w-[15%]">
                                            Tempo Investido
                                        </th>
                                        <th scope="col" class="w-[0%]">

                                        </th>
                                        <th class="w-[10%] text-right pr-[5rem]">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projetosConcluidos as $projeto)
                                        <tr class="border-b-4 border-b-[#d1d1d1]">
                                            <td>
                                                <div class="flex items-end">
                                                    <div>
                                                        <form action="{{route('projetos.tipoCliente.create')}}" id="formNovoTipoCliente/{{$projeto->id}}" class="my-0 py-0 hidden">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosConcluidos">
                                                            <input type="text" name="cliente_id" value="{{$cliente->id}}" class="hidden">
                                                            <input type="text" name="nome" id="newTipoClienteInput/{{$projeto->id}}"  onchange="this.form.submit()">
                                                        </form>
                                                        <form action="{{route('projetos.tipoCliente.atualizar', $projeto->id)}}" id="formAlterarTipoCliente/{{$projeto->id}}" method="POST" class="my-0 py-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosConcluidos">
                                                            <select name="novoTipoCliente" id="novoTipoCliente/{{$projeto->id}}" onchange="handleTipoClienteForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                                                @foreach($tiposCliente as $tC)
                                                                    <option value="{{$tC->id}}" {{$tC->nome == $projeto->tipoCliente->nome ? "selected" : ""}}>{{$tC->nome}}</option>
                                                                @endforeach
                                                                <option value="-1" class="font-black">Novo</option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex items-end">
                                                    <div>
                                                        <form action="{{route('projetos.tipoProjeto.create')}}" id="formNovoTipoProjeto/{{$projeto->id}}" class="my-0 py-0 hidden">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosConcluidos">
                                                            <input type="text" name="cliente_id" value={{$cliente->id}} class="hidden">
                                                            <input type="text" name="nome" id="newTipoProjetoInput/{{$projeto->id}}" onchange="this.form.submit()">
                                                        </form>
                                                        <form action="{{route('projetos.tipoProjeto.atualizar', $projeto->id)}}" id="formAlterarTipoProjeto/{{$projeto->id}}" method="POST" class="my-0 py-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosConcluidos">
                                                            <select name="novoTipoProjeto" id="novoTipoProjeto/{{$projeto->id}}" onchange="handleTipoProjetoForms(this.id)" class="w-fit pl-2 pr-8 border-none focus:border-none">
                                                                @foreach($tipoProjeto as $tP)
                                                                    <option value="{{$tP->id}}" {{$tP->nome == $projeto->tipoProjeto->nome ? "selected" : ""}}>{{$tP->nome}}</option>
                                                                @endforeach
                                                                <option value="-1" class="font-black">Novo</option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{$projeto->notas_iniciais}}
                                            </td>
                                            <td class="text-center">
                                                {{ $projeto->tempo_previsto }}
                                            </td>
                                            <td>
                                                <div class="flex items-end">
                                                    <div>
                                                        @foreach($projeto->users as $user)
                                                            <form action="{{ route('projetos.colaboradores.atualizar', $projeto->id) }}" method="POST" class="my-0 py-0">
                                                            @csrf
                                                            @method('PUT')
                                                                <input type="hidden" name="origin" value="clientes">
                                                                <input type="hidden" name="window" value="projetosConcluidos">
                                                                <div class="flex items-center @if(!$loop->last) border-b border-gray-400 @endif p-1">
                                                                    <select name="novoColaborador" id={{$projeto->id}} onchange="this.form.submit()" {{$projeto->users->count() == $colaboradores->count() ? 'disabled' : ''}} class="w-fit pl-2 pr-10 border-none focus:border-none">
                                                                        @foreach($colaboradores as $colaborador)
                                                                            @if(!$projeto->users->contains($colaborador) || $colaborador->id == $user->id)
                                                                                <option value="{{$colaborador->id}}/{{$user->id}}" class="w-fit" {{$colaborador->id == $user->id ? 'selected' : ''}}>{{ $colaborador->name }}</option>        
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </form>
                                                        @endforeach
                                                        {{-- newColaborador --}}
                                                        <form action="{{ route('projetos.colaboradores.adicionar', $projeto->id) }}" id="newColaboradorForm/{{$projeto->id}}" method="POST" class="hidden my-0 py-0">
                                                        @csrf
                                                            <input type="hidden" name="origin" value="clientes">
                                                            <input type="hidden" name="window" value="projetosConcluidos">
                                                            <div class="flex items-center border-t border-gray-400 p-1">
                                                                <select name="novoColaboradorId" id="{{$projeto->id}}" onchange="this.form.submit()" class="w-fit pl-2 pr-10 border-none focus:border-none">
                                                                    <option disabled selected>...</option>
                                                                    @foreach($colaboradores as $colaborador)
                                                                        @if(!$projeto->users->contains($colaborador))
                                                                            <option value="{{$colaborador->id}}" class="w-fit">{{ $colaborador->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="my-0 mx-3 {{$projeto->users->count() == $colaboradores->count() ? 'hidden' : ''}}">
                                                        <button id="{{$projeto->id}}" class="btn-adicionar-colaborador">
                                                            <!-- + -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                                            </svg>                                                                      
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex justify-center space-x-3">
                                                    <div>
                                                        @foreach($projeto->users as $user)
                                                            <div class="text-center @if(!$loop->last) border-b border-gray-400 @endif p-1">
                                                                {{$user->tempoGasto($projeto)}}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <?php
                                                        $tempoGasto = $projeto->totTempoGasto();

                                                        $tempoPrevisto = explode(":", $projeto->tempo_previsto);
                                                        $tempoPrevistoP1 = $tempoPrevisto[0];
                                                        $tempoPrevistoP2 = $tempoPrevisto[1];

                                                        $tempo_previsto_minutes = intval($tempoPrevistoP1) * 60 + intval($tempoPrevistoP2);

                                                        if ($tempoGasto < $tempo_previsto_minutes) {
                                                            $bgColor = 'greenStatus';
                                                        } elseif ($tempoGasto == $tempo_previsto_minutes) {
                                                            $bgColor = 'blueStatus';
                                                        } else {
                                                            $bgColor = 'redStatus';
                                                        }
                                                    ?>
                                                    <div class="bg-{{$bgColor}} rounded-full size-6 m-auto">
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                            </td>
                                            <td>
                                                <div class="flex justify-end pr-[3rem] space-x-3">
                                                    <a href="{{ route('projetos.edit', $projeto->id) }}" title="Editar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('projetos.destroy', $projeto->id) }}" title="Remover" onsubmit="return confirm('Tem a certeza?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" {{$hasPermissions ? "" : 'disabled'}} class="disabled:cursor-not-allowed">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="block xl:hidden space-y-3 h-fit">
                            <div class="sm:flex space-y-3 sm:space-y-0 sm:space-x-3">
                                @foreach($projetosConcluidos as $projeto)
                                    <div class="min-h-fit w-full flex items-start shadow-lg border-4 p-4">
                                        <div class="w-full">
                                            <div class="flex justify-between items-center">
                                                <h1 class="font-black">
                                                    {{$projeto->tipoCliente->nome}}
                                                </h1>
                                                @if($hasPermissions)
                                                    <div class="flex justify-center space-x-3">
                                                        <a href="{{ route('projetos.edit', $projeto->id) }}" title="Editar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </a>
                                                        <form method="POST" action="{{ route('projetos.destroy', $projeto->id) }}" class="m-auto" title="Remover">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Tem a certeza?')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-700 hover:text-red-500">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mt-3">
                                                <div class="flex justify-between items-center">
                                                    <h2 class="font-bold">
                                                        {{$projeto->nome}}
                                                    </h2>
                                                    <?php
                                                        $tempoGasto = $projeto->totTempoGasto();

                                                        $tempoPrevisto = explode(":", $projeto->tempo_previsto);
                                                        $tempoPrevistoP1 = $tempoPrevisto[0];
                                                        $tempoPrevistoP2 = $tempoPrevisto[1];

                                                        $tempo_previsto_minutes = intval($tempoPrevistoP1) * 60 + intval($tempoPrevistoP2);

                                                        if ($tempoGasto < $tempo_previsto_minutes) {
                                                            $bgColor = 'green-300';
                                                        } elseif ($tempoGasto == $tempo_previsto_minutes) {
                                                            $bgColor = 'blue-500';
                                                        } else {
                                                            $bgColor = 'red-300';
                                                        }
                                                    ?>
                                                    <div class="rounded-full bg-{{$bgColor}} size-6">
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex items-center">
                                                <div>
                                                    <a class="bg-darkBlue text-white py-2 px-4 rounded mr-4 hover:cursor-pointer" onclick="openModal('modal_{{$projeto->id}}')">
                                                        Tarefas
                                                    </a>
                                                    <div id="modal_{{$projeto->id}}" class="modal fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 m-auto ">
                                                        <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white w-fit">
                                                            <div class="flex justify-end p-2">
                                                                <button onclick="closeModal('modal_{{$projeto->id}}')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                    
                                                            <div class="p-6 pt-0 text-center">
                                                                @foreach($projeto->tarefas as $tarefa)
                                                                    <div>
                                                                        {{ $tarefa->descricao }}
                                                                    </div>  
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass" viewBox="0 0 16 16">
                                                        <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702c0 .7-.478 1.235-1.011 1.491A3.5 3.5 0 0 0 4.5 13v1h7v-1a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351v-.702c0-.7.478-1.235 1.011-1.491A3.5 3.5 0 0 0 11.5 3V2z"/>
                                                    </svg>
                                                    {{$projeto->tempo_previsto}}
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                @foreach($projeto->users as $user)
                                                    <div>
                                                        <div class="w-fit py-2 mr-4 flex items-center">
                                                            <div>
                                                                {{$user->name}}
                                                            </div>
                                                            <div class="flex items-center"> 
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class=" ml-4 bi bi-stopwatch" viewBox="0 0 16 16">
                                                                    <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5z"/>
                                                                    <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64l.012-.013.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5M8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3"/>
                                                                </svg>
                                                                <div>
                                                                    {{$user->tempoGasto($projeto)}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a id="btnAdicionarLinha" class="hover:cursor-pointer bg-darkBlue text-white py-2 px-4 rounded mr-4 {{$window == 'projetosConcluidos' ? 'hidden' : ''}}">
                            Adicionar Projeto
                        </a>
                    </div>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<script>

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
            console.log('formAlterarTipoProjeto/' + id.split('/')[1]);
            document.getElementById('formAlterarTipoProjeto/' + id.split('/')[1]).submit();
        }
    }

    var btnPA = document.getElementById('btnProjetosAbertos');
    var btnPC = document.getElementById('btnProjetosConcluidos');

    btnPA.addEventListener('click', () => {
        document.getElementById('btnAdicionarLinha').classList.remove("hidden");
        toggleTables(btnPA, btnPC, 'tabelaProjetosAbertos', 'tabelaProjetosConcluidos');
    });

    btnPC.addEventListener('click', () => {
        document.getElementById('btnAdicionarLinha').classList.add("hidden");
        toggleTables(btnPC, btnPA, 'tabelaProjetosConcluidos', 'tabelaProjetosAbertos');
    });

    const toggleTables = (btn1, btn0, table1, table0) => {
        btn1.classList.add('bg-darkBlue');
        btn1.classList.remove('bg-gray-400');

        btn0.classList.add('bg-gray-400');
        btn0.classList.remove('bg-darkBlue');

        document.getElementById(table1).classList.remove('hidden');
        document.getElementById(table0).classList.add('hidden');
    };

    var btnAdicionarColaborador = document.getElementsByClassName("btn-adicionar-colaborador");

    for(var i = 0; i < btnAdicionarColaborador.length;i++){
        btnAdicionarColaborador[i].addEventListener('click', addNewColaboradorField);
    }

    function addNewColaboradorField(){
        document.getElementById('newColaboradorForm/' + this.id).classList.remove('hidden');
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

    document.getElementById('btnAdicionarLinha').addEventListener('click', () => {
        document.getElementById('newProjectRow').classList.remove("hidden");
    })

</script>