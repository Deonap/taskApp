<link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
<style>
   @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap');

    .font-sans {
        font-family: 'Open Sans', sans-serif;
    }
    .bg-sidebar {
        background: rgb(10,56,87); /* Azul médio para fundo do menu lateral */
        border-radius: 16px;         /* Adiciona margens nas laterais do menu para não tocar nas bordas da tela */
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

    /* Dropdown Button */
    .dropbtn {
        background-color: rgb(10,56,87);
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        background: rgb(10,56,87)
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #ddd;
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

        
</style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="md:hidden flex justify-end">
        <div class="dropdown">
            <button class="dropbtn ml-3 mt-3">Menu</button>
            <div class="dropdown-content">
                <div>
                    <span class="flex text-white items-center opacity-90 hover:opacity-100 py-4 px-2 text-xl font-bold hover:cursor-default">
                        <i class="fas fa-thumbtack"></i>
                        <div class="ml-3">
                            Prioridades
                        </div> 
                        @if(auth()->user() && auth()->user()->tipo == 'admin' && $notsPorVer)
                            <div class="ml-1 mb-2 size-2 rounded-full bg-red-500">
                                <span class="invisible">
                                    a
                                </span>
                            </div>
                        @endif
                    </span>
                    <div>
                        <a href="{{ route('prioridades.index') }}"class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('prioridades.index') ? 'active' : '' }}">
                            - Definir
                        </a>
                        <a href="{{ route('historico.index') }}"class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('historico.index') ? 'active' : '' }}">
                            - Histórico
                        </a>
                    </div>
                </div>
                <div>
                    <span class="flex text-white items-center opacity-90 hover:opacity-100 py-4 px-2 text-xl font-bold hover:cursor-default">
                        <i class="fas fa-users"></i>
                        <div class="ml-3">
                            Clientes
                        </div>
                    </span>
                    <a href="{{ route('clientes.create') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('clientes.create') ? 'active' : '' }}">
                        - Adicionar
                    </a>
                    <a href="{{ route('clientes.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('clientes.*') ? (request()->routeIs('clientes.create') ? '' : 'active') : '' }}">
                        - Listagem
                    </a>
                </div>
                <div>
                    <span class="flex text-white items-center opacity-90 hover:opacity-100 py-4 px-2 text-xl font-bold hover:cursor-default">
                        <i class="fas fa-cogs"></i>
                        <div class="ml-3">
                            Parametrizações
                        </div>
                    </span>
                    <a href="{{ route('tipo-clientes.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('tipo-clientes.*') ? 'active' : '' }}">
                    - Tipo de Cliente
                    </a>
                    <a href="{{ route('users.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    - Níveis de Acesso
                    </a>
                    <a href="{{ route('estado-projetos.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('estado-projetos.*') ? 'active' : '' }}" >
                        - Estado
                    </a>
                </div>
            </div>
          </div>
    </div>
    <div class="hidden md:block w-fit">
        <aside class="relative bg-sidebar w-fit h-fit pr-1 ml-3 mt-3">
            <div class="p-6">
                <div class="hover:text-gray-300 mt-8 w-fit">
                    <img src="/images/logo-buzina.png" alt="Logotipo Buzina" class="h-10 resize-none" > <!-- Ajuste a classe de altura conforme necessário -->
                </div>
            </div>
            <nav class="text-white text-base font-semibold sm:pt-3 space-y-5 pb-6">
                <!-- Prioridades -->
                <div class="nav-item">
                    <span class="flex items-center opacity-90 hover:opacity-100 py-4 ml-2 text-xl font-bold hover:cursor-default">
                        <i class="fas fa-thumbtack"></i>
                        <div class="ml-3">
                            Prioridades
                        </div> 
                        @if(auth()->user() && auth()->user()->tipo == 'admin' && $notsPorVer)
                            <div class="ml-1 mb-2 size-2 rounded-full bg-red-500">
                                <span class="invisible">
                                    a
                                </span>
                            </div>
                        @endif
                    </span>
                    <a href="{{ route('prioridades.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('prioridades.index') ? 'active' : '' }}">
                        - Definir
                    </a>
                    <a href="{{ route('historico.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('historico.index') ? 'active' : '' }}">
                        - Histórico
                    </a>
                </div>

                <!-- Clientes -->
                <div class="nav-item">
                    <span class="flex items-center text-white opacity-90 hover:opacity-100 py-4 ml-2 text-xl font-bold hover:cursor-default">
                        <i class="fas fa-users"></i>
                        <div class="ml-3">
                            Clientes
                        </div>
                    </span>
                    <a href="{{ route('clientes.create') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('clientes.create') ? 'active' : '' }}">
                        - Adicionar
                    </a>
                    <a href="{{ route('clientes.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('clientes.*') ? (request()->routeIs('clientes.create') ? '' : 'active') : '' }}">
                        - Listagem
                    </a>
                </div>

                <!-- Parametrizações -->
                <div class="nav-item">
                    <span class="flex items-center text-white opacity-90 hover:opacity-100 py-4 ml-1 text-xl font-bold hover:cursor-default">
                        <i class="fas fa-cogs"></i>
                        <div class="ml-3">
                            Parametrizações
                        </div>
                    </span>
                    <a href="{{ route('tipo-clientes.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('tipo-clientes.*') ? 'active' : '' }}">
                    - Tipo de Cliente
                    </a>
                    <a href="{{ route('users.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    - Níveis de Acesso
                    </a>
                    <a href="{{ route('estado-projetos.index') }}" class="rounded-l-full flex items-center text-white opacity-90 hover:opacity-100 py-2 nav-item {{ request()->routeIs('estado-projetos.*') ? 'active' : '' }}" >
                        - Estado
                    </a>
                </div>
            </nav>
        </aside>
    </div>
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
