<html lang="en">
    <head>
        <style>
            th{
                padding: 0.5rem 1rem 0.5rem 1rem;
                text-align: left;
                font-weight: 800;
            }
            td{
                padding: 0.5rem 1rem 0.5rem 1rem;
            }
            form{
                margin:auto;
            }
            table{
                table-layout: fixed;
                width: 100%;
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
                    <div class="flex items-center text-darkBlue">
                        <h2 class="hidden md:block text-xl font-black">
                            Parametrizações >
                        </h2>
                        <div class="text-xl font-black md:text-base md:font-normal ml-2 flex">
                            Níveis de Acesso
                        </div>
                    </div>
                    <div class="flex justify-end items-right mb-4 mt-[1.75rem]">
                        <div>
                            <button id="btnAdicionarLinha" class="bg-darkBlue hover:cursor-pointer hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-md disabled:cursor-not-allowed disabled:hover:bg-darkBlue" {{$hasPermissions ? "" : "disabled"}}>
                                Adicionar
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-300">
                                <th scope="col" class="w-[25%]">Nome</th>
                                <th scope="col" class="w-[25%]">Email</th>
                                <th scope="col" class="w-[20%]">Password</th>
                                <th scope="col" class="w-[15%]">Tipo</th>
                                <th scope="col" class="w-[15%] text-right pr-[5rem]">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="newUserRow" class="hidden border-b border-gray-200">
                                <form method="POST" action="{{ route('users.store') }}" autocomplete="off">
                                @csrf
                                    <td>
                                        <input name="name" class="bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                    </td>
                                    <td>
                                        <input name="email" class="bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                    </td>
                                    <td>
                                        <input name="password" class="bg-transparent rounded-md p-2" autocomplete="off" type="password" >
                                    </td>
                                    <td>
                                        <?php 
                                            if(!$hasPermissions){
                                                # disabled
                                                $status = 'enabled';
                                            }else{
                                                $status = 'enabled';
                                            }
                                        ?>
                                        <select name="tipo" {{$status}} class="pr-10 pl-1 text-left py-1 border-none">
                                            <option value="colaborador" {{ $user->tipo == 'colaborador' ? 'selected' : '' }}>COLAB</option>
                                            <option value="admin" {{ $user->tipo == 'admin' ? 'selected' : '' }}>ADMIN</option>
                                        </select>
                                    </td>
                                    <td class="flex justify-end pr-[3rem]">
                                        <button type="submit" onclick="this.form.submit()" class="font-bold py-2 px-4 rounded bg-darkBlue text-white hover:cursor-pointer">Adicionar</button>
                                    </td>
                                </form>
                            </tr>
                            @foreach($users as $user)
                            <tr class="border-b border-gray-200">
                                <td>
                                    <form action="{{route('users.update', $user->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input name="name" {{$hasPermissions ? "" : "disabled"}} value='{{ $user->name }}' onchange="this.form.submit()" class="border-none bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route('users.update', $user->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input name="email" {{$hasPermissions ? "" : "disabled"}} value='{{ $user->email }}' onchange="this.form.submit()" class="border-none bg-transparent rounded-md p-2" autocomplete="off" type="text">
                                    </form>
                                </td>
                                <td>
                                    ********
                                </td>
                                <td>
                                    <form action="{{ route('users.updateType', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <?php 
                                            if(!$hasPermissions){
                                                # disabled
                                                $status = 'enabled';
                                            }else{
                                                $status = 'enabled';
                                            }
                                        ?>
                                        <select name="tipo" {{$status}} onchange="this.form.submit()" class="pr-10 pl-1 text-left py-1 border-none">
                                            <option value="colaborador" {{ $user->tipo == 'colaborador' ? 'selected' : '' }}>COLAB</option>
                                            <option value="admin" {{ $user->tipo == 'admin' ? 'selected' : '' }}>ADMIN</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <div class="flex justify-end pr-[3rem] space-x-3 {{$hasPermissions ? "" : "hover:cursor-not-allowed"}}">
                                        <!-- Botão editar -->
                                        <a href="{{ route('users.edit', $user->id) }}" title="Editar" class="{{$hasPermissions ? "" : "pointer-events-none"}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-darkBlue hover:text-blue-700">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <!-- Botão apagar -->
                                        <form action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Tem a certeza?')" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="{{$hasPermissions ? "" : "pointer-events-none"}}">
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
            </div>
        </x-app-layout>
    </body>
</html>
<script>
    document.getElementById('btnAdicionarLinha').addEventListener('click', () => {
        document.getElementById('newUserRow').classList.remove("hidden");
    })
</script>