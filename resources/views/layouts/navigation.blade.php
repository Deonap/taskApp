<link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
<style>
   @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap');

    .font-sans {
        font-family: 'Open Sans', sans-serif;
    }
    .bg-sidebar {
        background: #0a3857; /* Azul médio para fundo do menu lateral */
    }

    .cta-btn {
        color: #aeb2f8; /* Azul claro acinzentado para botões de chamada para ação */
    }

    .upgrade-btn {
        background: #1947ee; /* Azul brilhante para botão de upgrade */
    }

    .upgrade-btn:hover {
        background: #0038fd; /* Azul um pouco mais escuro para hover no botão de upgrade */
    }

    .active-nav-link {
        background: #091f70; /* Azul escuro para link ativo */
        opacity: 1 !important;
    }

    .nav-item {
        color: #ffffff; /* Branco para texto do item do menu */
        transition: background-color 0.3s;
        padding-left: 20px;
        width: 180px;
        
        
    }

    .nav-item a:hover, .nav-item a.active {
        padding: 5px auto; /* Adjust the padding as needed */
        background: #ffffff; /* White background */
        color: #0a3857; /* Blue text */
        border-radius: 8px;
        transition: all 0.3s ease;
        padding-left: 30px ;
        width: 180px;
        /* Smooth transition for hover effects */
    }

    .nav-item a:hover {
        background: #ffffff; /* Branco para o fundo do item do menu */
        color: #0a3857; /* Azul brilhante para o texto do item do menu */
        /* Adiciona um padding interno para criar a margem visual desejada */
        /* Opcional: adiciona uma pequena margem externa se necessário */
        border-radius: 8px;
        /* Mantém os cantos arredondados */
    }

    .account-link:hover {
        background: #072079; /* Azul mais escuro para hover no link da conta */
    }

    .active {
        background-color: white;
        color:#0a3857;
        /* Cor mais escura para o item ativo */
    }
    /* ... mantenha os estilos existentes e adicione o seguinte ... */

    /* Estilo para arredondar os cantos e adicionar margem ao item do menu */
    .nav-item a {
        border-radius: 8px; /* Arredonda os cantos */
        /* Adiciona margem em todos os lados */
    }

    /* Centraliza o logotipo e o texto */
    .p-6 a,
    .nav-item span,
    .nav-item a {
        display: flex;
        align-items: left;
        justify-content: start;
    }

    /* Ajuste no padding para manter os itens do menu centralizados verticalmente após adicionar margens */


    /* Adiciona margens nas laterais do menu para não tocar nas bordas da tela */
    .bg-sidebar {
        margin: 10px;
        margin-top: 30px;
        margin-left: 20px;
        
        border-radius: 16px;
        padding-left: 20px /* Arredonda os cantos do menu inteiro */
    }

    button.flex {
    padding-left: 1rem; /* Espaço interno à esquerda */
    padding-right: 1rem; /* Espaço interno à direita */
    align-items: center; /* Alinha os itens verticalmente no centro */
    }

    /* Ícone de usuário e nome do usuário */
    button svg:first-child {
    margin-right: 0.5rem; /* Espaço entre o ícone do usuário e o nome */
    }

    /* Ícone de seta para baixo */
    button svg:last-child {
    margin-left: auto; /* Empurra o ícone de seta para a extremidade direita do botão */
    }


        
</style>
</head>

<body class="bg-gray-100 font-sans flex">

<aside class="relative bg-sidebar overflow-y-auto shadow-xl" style="height: 90vh; width:100%">
    <div class="p-6 ">
        <a href="#" class="hover:text-gray-300 mt-8">
            <img src="/images/logo-buzina.png" alt="Logotipo Buzina" class="h-10" > <!-- Ajuste a classe de altura conforme necessário -->
        </a>
    </div>
    <nav class="text-white text-base font-semibold pt-3">
        <!-- Prioridades -->
        <div class="nav-item">
            <span class="flex items-center text-white opacity-90 hover:opacity-100 py-4  ml-2 mt-5 text-xl font-bold">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Prioridades 
                @if(auth()->user() && auth()->user()->tipo == 'admin' && true)
                    <div class="ml-1 mb-2 size-2 rounded-full bg-red-500">
                        <span class="invisible">
                            a
                        </span>
                    </div>
                @endif
            </span>
            <a href="{{ route('prioridades.index') }}"  class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2  nav-item {{ request()->routeIs('prioridades.index') ? 'active' : '' }}">
                - Definir
            </a>
            <a href="{{ route('historico.index') }}"  class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2  nav-item {{ request()->routeIs('historico.index') ? 'active' : '' }}">
               - Histórico
            </a>
        </div>

        <!-- Clientes -->
        <div class="nav-item">
            <span class="flex items-center text-white opacity-90 hover:opacity-100 py-4  ml-2 mt-5 text-xl font-bold">
                <i class="fas fa-users mr-3"></i>
               Clientes
            </span>
            <a href="{{ route('clientes.create') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2  nav-item {{ request()->routeIs('clientes.create') ? 'active' : '' }}">
               - Adicionar
            </a>
            <a href="{{ route('clientes.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2  nav-item {{ request()->routeIs('clientes.*') ? (request()->routeIs('clientes.create') ? '' : 'active') : '' }}">
               - Listagem
            </a>
        </div>

        <!-- Parametrizações -->
        <div class="nav-item">
            <span class="flex items-center text-white opacity-90 hover:opacity-100 py-4 ml-1 mt-5 text-xl font-bold">
                <i class="fas fa-cogs mr-3"></i>
                Parametrizações
            </span>
            <a href="{{ route('tipo-clientes.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2  nav-item {{ request()->routeIs('tipo-clientes.*') ? 'active' : '' }}"  >
               - Tipo de Cliente
            </a>
            <a href="{{ route('users.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2  nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
               - Níveis de Acesso
            </a>
            <a href="{{ route('estado-projetos.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2  nav-item {{ request()->routeIs('estado-projetos.*') ? 'active' : '' }}" >
                - Estado
            </a>
        </div>
    </nav>
    <div class="p-6">
        <div class="relative" x-data="{ open: false }">
            
            <button @click="open = !open" class="flex items-center w-full px-4 py-2 text-sm font-medium leading-5 text-left text-white transition duration-150 ease-in-out bg-sidebar rounded-md hover:text-gray-300 focus:outline-none focus:shadow-outline-blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                  </svg>
                  
                  
                @auth
                <span class="flex-grow">{{ Auth::user()->name }}</span>
                @else
                <span class="flex-grow">Convidado</span>
                @endauth
                <svg class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-48 mt-2 origin-top-right rounded-md shadow-lg">
                <div class="py-1 bg-white rounded-md shadow-xs">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 transition-colors duration-150 hover:bg-gray-100">{{ __('Profile') }}</a>
                    <!-- Logout Link -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100">{{ __('Log Out') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>


<script>
    // Este código irá adicionar a classe 'active' ao item do menu correto quando a página carregar
    document.addEventListener('DOMContentLoaded', (event) => {
        // Seus links de menu devem ter IDs ou classes que correspondam a cada rota/página
        const menuItems = document.querySelectorAll('.nav-item a');
        const currentPath = window.location.pathname; // Pega o caminho da URL atual
    
        menuItems.forEach(item => {
            // Se o href do item do menu corresponder ao caminho atual, adicione a classe 'active'
            if(item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            }
        });
    });
    </script>
  
</body>
