<html lang="en">
    <head>
        <style>
            th{
                padding: 0.5rem 1rem 0.5rem 1rem;
                text-align: left;
                font-weight: 600;
            }
            td{
                padding: 0.5rem 1rem 0.5rem 1rem;
            }
        </style>
    </head>
    <body>
        <x-app-layout>
            <div class="flex-1 bg-gray-200 p-6 m-20">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Lista de Usuários
                    </h2>
                    @if(auth()->user() && auth()->user()->tipo == 'admin')
                        <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md">
                            Adicionar
                        </a>
                    @endif
                </div>
            
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <table class="table-auto w-full ">
                        <thead>
                            <tr class="bg-blue-100">
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Tipo</th>
                                @if(auth()->user() && auth()->user()->tipo == 'admin')
                                    <th class="text-center">Ações</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-b border-gray-200">
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    ********
                                </td>
                                <td>
                                    <form action="{{ route('users.updateType', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <?php 
                                            if(auth()->user() && auth()->user()->tipo != 'admin'){
                                                # disabled
                                                $status = 'enabled';
                                            }else{
                                                $status = 'enabled';
                                            }
                                        ?>
                                        <select name="tipo" {{$status}} onchange="this.form.submit()" class="pr-10 pl-1 text-left">
                                            <option value="colaborador" {{ $user->tipo == 'colaborador' ? 'selected' : '' }}>Colaborador</option>
                                            <option value="admin" {{ $user->tipo == 'admin' ? 'selected' : '' }}>Administrador</option>
                                        </select>
                                    </form>
                                </td>
                                @if(auth()->user() && auth()->user()->tipo == 'admin')
                                    <td>
                                        <div class="flex justify-center">
                                            <a href="{{ route('users.edit', $user->id) }}"  class="text-blue-500 hover:text-blue-700 font-semibold mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </x-app-layout>
    </body>
</html>