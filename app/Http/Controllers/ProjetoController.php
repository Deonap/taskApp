<?php

namespace App\Http\Controllers;

use App\Models\TipoCliente;
use App\Models\Projeto;
use Illuminate\Http\Request;
use App\Http\Controllers\ClienteController;
use App\Models\Cliente;
use App\Models\User;
use App\Models\EstadoProjeto;
use App\Models\Tarefa;
use Illuminate\Routing\Events\ResponsePrepared;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projetos = Projeto::all();
        return view('projetos.index', compact('projetos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposClientes = TipoCliente::all();
        $users = User::all();
        $estadosProjetos = EstadoProjeto::all();
        $clientes = Cliente::all(); // Recupera todos os clientes disponíveis
        return view('projetos.create', compact('tiposClientes', 'clientes', 'users', 'estadosProjetos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_cliente_id' => 'required|exists:tipo_clientes,id',
            'estado_projeto_id' => 'required|exists:estado_projetos,id', // Substitua pelos tipos que você possui
            'nome' => 'required|max:255',
            'tarefas' => 'required|array',
            'tarefas.*' => 'string', // Assumindo que as tarefas são enviadas como um array
            'users' => 'required|array|exists:users,id', // Assumindo que os colaboradores são enviados como um array
            'tempo_previsto' => 'required|numeric',
            'notas_iniciais' => 'nullable|string',
        ]);

        // Crie o novo projeto com os dados validados
        $projeto = Projeto::create($validatedData);

        // Anexe as tarefas ao projeto
        $tarefasData = array_map(function ($descricao) {
            return ['descricao' => $descricao];
        }, $validatedData['tarefas']);

        $projeto->tarefas()->createMany($tarefasData);

        // Anexe os usuários relacionados ao projeto
        $projeto->users()->sync($validatedData['users']);

        return redirect()->route('clientes.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Projeto $projeto)
    {
        //return view('projetos.show', compact('projeto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projeto $projeto)
    {
        $tiposClientes = TipoCliente::all();
        $users = User::all();
        $estadosProjetos = EstadoProjeto::all();
        $clientes = Cliente::all();

        return view('projetos.edit', compact('projeto', 'tiposClientes', 'clientes', 'users', 'estadosProjetos'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projeto $projeto)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_cliente_id' => 'required|exists:tipo_clientes,id',
            'estado_projeto_id' => 'required|exists:estado_projetos,id',
            'nome' => 'required|max:255',
            'tarefas' => 'required|array',
            'tarefas.*' => 'string',
            'users' => 'required|array|exists:users,id',
            'tempo_previsto' => 'required|numeric',
            'observacoes' => 'nullable|string',
            'tempo_gasto' => 'nullable|numeric',
        ]);

        $projeto->update($validatedData);

        // Atualizar tarefas: remova todas as atuais e adicione as novas
        $projeto->tarefas()->delete();
        $tarefasData = array_map(function ($descricao) {
            return ['descricao' => $descricao];
        }, $validatedData['tarefas']);
        $projeto->tarefas()->createMany($tarefasData);

        // Atualizar usuários relacionados
        $projeto->users()->sync($validatedData['users']);

        return redirect()->route('clientes.index')->with('success', 'Projeto atualizado com sucesso.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projeto $projeto)
    {
        $projeto->users()->detach();
        $projeto->delete();
        return redirect()->route('clientes.index');
    }

    public function atualizarColaborador(Request $request, Projeto $projeto)
    {
        dd($request);
        $validated = $request->validate([
            'novoColaboradorId' => 'required|exists:users,id'
        ]);


        $novoColaboradorId = $validated['novoColaboradorId'];

        $projeto->users()->syncWithoutDetaching([$validated['novoColaborador']]);

        return response()->json(['message' => 'Colaborador atualizado com sucesso!']);
    }

    public function adicionarColaborador(Request $request, Projeto $projeto)
    {
        $validated = $request->validate([
            'novoColaboradorId' => 'required|exists:users,id',
        ]);

        $novoColaboradorId = $validated['novoColaboradorId'];

        // Verificar se a relação já existe
        $existe = $projeto->users()->where('user_id', $novoColaboradorId)->exists();

        if (!$existe) {
            // Adicionar o colaborador ao projeto se ele ainda não estiver associado
            $projeto->users()->attach($novoColaboradorId);
            return response()->json(['message' => 'Colaborador adicionado com sucesso!']);
        } else {
            // Responder que o colaborador já está no projeto
            return response()->json(['message' => 'Este colaborador já está associado a este projeto.'], 409); // 409 Conflict
        }
    }


    // No ProjetoController
    public function buscarColaboradoresDisponiveis(Projeto $projeto)
    {
        $todosColaboradores = User::where('tipo', 'colaborador')->get();
        $colaboradoresDisponiveis = $todosColaboradores->diff($projeto->users);

        return response()->json($colaboradoresDisponiveis);
    }



}
