<div class="absolute right-0">
    <div class="w-fit" x-data="{ open: false }">
        <button id="logoutDropdownButton" class="flex w-full px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-sidebar rounded-md hover:text-gray-300 focus:outline-none focus:shadow-outline-blue">
            @auth
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                </svg>
            @else
                <span class="flex-grow">Convidado</span>
            @endauth
            <svg class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <div id="dropdownDiv" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="hidden absolute left-0 w-[100px] mt-2 origin-top-right rounded-md shadow-lg">
            <div class="py-1 bg-white rounded-md shadow-xs">
                <!-- Logout Link -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class=" w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const logoutButton = document.getElementById('logoutDropdownButton');
    logoutButton.addEventListener('click', function(){
        dropdownDiv.classList.toggle('hidden');
    })

    const dropdownDiv = document.getElementById('dropdownDiv');
    document.addEventListener('click', function(event){
        if(!dropdownDiv.classList.contains('hidden') && !logoutButton.contains(event.target)){
            dropdownDiv.classList.add('hidden');
        }
    })
</script>