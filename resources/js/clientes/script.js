var btnPA = document.getElementById('btnProjetosAbertos');
var btnPC = document.getElementById('btnProjetosConcluidos');

document.getElementById('btnProjetosAbertos').addEventListener('click', () => {
    btnPA.classList.add('bg-darkBlue');
    btnPA.classList.remove('bg-gray-400');
    btnPC.classList.add('bg-gray-400');
    btnPC.classList.remove('bg-darkBlue');

    document.getElementById('tabelaProjetosAbertos').classList.remove('hidden');
    document.getElementById('tabelaProjetosConcluidos').classList.add('hidden');
});

document.getElementById('btnProjetosConcluidos').addEventListener('click', () => {
    btnPC.classList.add('bg-darkBlue');
    btnPC.classList.remove('bg-gray-400');
    btnPA.classList.add('bg-gray-400');
    btnPA.classList.remove('bg-darkBlue');

    document.getElementById('tabelaProjetosConcluidos').classList.remove('hidden');
    document.getElementById('tabelaProjetosAbertos').classList.add('hidden');
});

var colaboradorCell = document.getElementsByClassName("colaboradorCell");
var btnAdicionarColaborador = document.getElementsByClassName("btn-adicionar-colaborador");

for(var i = 0; i <btnAdicionarColaborador.length;i++){
    btnAdicionarColaborador[i].addEventListener('click', addNewColaboradorField);
}

function addNewColaboradorField(){
    var colaboradorCell = document.getElementById("colaboradorCell/" + this.id);
    var html = `
    <form action="{{ route('projetos.colaboradores.adicionar', ':id') }}" method="POST">
    @csrf
        <div class="flex items-center border-t border-gray-400 p-1">
            <select name="novoColaboradorId" id=":id" onchange="this.form.submit()" class="w-fit pl-2 pr-8 border-none focus:border-none">
                <option disabled selected>...</option>
                @foreach($colaboradores as $colaborador)
                    <option value="{{$colaborador->id}}" class="w-fit">{{ $colaborador->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
    `;

    html = html.replaceAll(':id', this.id);

    colaboradorCell.innerHTML += html;
}