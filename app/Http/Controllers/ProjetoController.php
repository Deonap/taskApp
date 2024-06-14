<?php

namespace App\Http\Controllers;

use App\Models\ProjetoUser;
use App\Models\TipoCliente;
use App\Models\Projeto;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\User;
use App\Models\EstadoProjeto;
use App\Models\TipoProjeto;

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
            'tipo_projeto_id' => 'required|exists:tipo_projetos,id',
            'estado_projeto_id' => 'exists:estado_projetos,id', // Substitua pelos tipos que você possui
            'nome' => 'string|max:255',
            'tarefas' => 'array',
            'tarefas.*' => 'string', // Assumindo que as tarefas são enviadas como um array
            'users' => 'required|array|exists:users,id', // Assumindo que os colaboradores são enviados como um array
            'tempo_previsto' => 'required|string',
            'notas_iniciais' => 'nullable|string',
        ]);

        if (!$request->filled('estado_projeto_id')) {
            $validatedData['estado_projeto_id'] = 2;
        }

        // Crie o novo projeto com os dados validados
        $projeto = Projeto::create($validatedData);

        // Anexe as tarefas ao projeto
        if ($request->has('tarefas')) {
            $tarefasData = array_map(function ($descricao) {
                return ['descricao' => $descricao];
            }, $validatedData['tarefas']);

            $projeto->tarefas()->createMany($tarefasData);
        }
        // Anexe os usuários relacionados ao projeto
        $projeto->users()->sync($validatedData['users']);

        return redirect()->route('clientes.show', $projeto->cliente->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Projeto $projeto)
    {
        return view('projetos.show', compact('projeto'));
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
            'tempo_previsto' => 'required|string',
            'observacoes' => 'nullable|string',
            'tempo_gasto' => 'nullable|string',
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

        return redirect()->route('clientes.show', $projeto->cliente_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projeto $projeto)
    {
        $projeto->users()->detach();
        $projeto->delete();

        return redirect()->route('clientes.show', $projeto->cliente->id);
    }

    public function atualizarColaborador(Request $request, Projeto $projeto)
    {
        $aux = explode('/', $request['novoColaborador']);

        $novoColaboradorId = $aux[0];
        $oldColaboradorId = $aux[1];

        $projeto->users()->where('id', $oldColaboradorId)->detach($oldColaboradorId);
        $projeto->users()->attach($novoColaboradorId);
        if ($request->has('origin')) {
            $origin = $request['origin'];
            if ($origin === 'clientes') {
                return redirect(route('clientes.show', ['cliente' => $projeto->cliente_id, 'window' => $request['window']]));
            } elseif ($origin === 'prioridades') {
                return redirect(route('prioridades.index', $request['user']));
            }
        }
    }

    public function removerColaborador(Request $request, Projeto $projeto){
        $colabId = $request['colaborador_id'];
        $projeto->users()->detach($colabId);
        $projeto->update();
        return redirect()->back();
    }

    public function atualizarCliente(Request $request, Projeto $projeto)
    {
        $novoCliente = $request['novoCliente'];

        $projeto->cliente_id = $novoCliente;
        $projeto->update();
        return redirect(route('prioridades.index', $request['user']));
    }

    public function atualizarTipoCliente(Request $request, Projeto $projeto)
    {
        $novoTipoCliente = $request['novoTipoCliente'];

        $projeto->tipo_cliente_id = $novoTipoCliente;
        $projeto->update();

        if ($request->has('origin')) {
            $origin = $request['origin'];
            if ($origin === 'clientes') {
                return redirect(route('clientes.show', ['cliente' => $projeto->cliente_id, 'window' => $request['window']]));
            } elseif ($origin === 'prioridades') {
                return redirect(route('prioridades.index', $request['user']));
            } elseif ($origin === 'historico') {
                return redirect(route('historico.index'));
            }
        }
    }

    public function createNewTipoCliente(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|unique:tipo_clientes|max:255'
        ]);
        TipoCliente::create($validatedData);
        if ($request->has('origin')) {
            $origin = $request['origin'];
            if ($origin === 'clientes') {
                return redirect(route('clientes.show', ['cliente' => $request['cliente_id'], 'window' => $request['window']]));
            } elseif ($origin === 'prioridades') {
                return redirect(route('prioridades.index', $request['user']));
            } elseif ($origin === 'historico') {
                return redirect(route('historico.index'));
            }
        }
    }

    public function createNewTipoProjeto(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|unique:tipo_projetos|max:255'
        ]);
        TipoProjeto::create($validatedData);
        if ($request->has('origin')) {
            $origin = $request['origin'];
            if ($origin === 'clientes') {
                return redirect(route('clientes.show', ['cliente' => $request['cliente_id'], 'window' => $request['window']]));
            } elseif ($origin === 'prioridades') {
                return redirect(route('prioridades.index', $request['user']));
            } elseif ($origin === 'historico') {
                return redirect(route('historico.index'));
            }
        }
    }

    public function atualizarTipoProjeto(Request $request, Projeto $projeto)
    {
        $novoTipoProjeto = $request['novoTipoProjeto'];

        $projeto->tipo_projeto_id = $novoTipoProjeto;
        $projeto->update();
        if ($request->has('origin')) {
            $origin = $request['origin'];
            if ($origin === 'clientes') {
                return redirect(route('clientes.show', ['cliente' => $projeto->cliente_id, 'window' => $request['window']]));
            } elseif ($origin === 'prioridades') {
                return redirect(route('prioridades.index', $request['user']));
            } elseif ($origin === 'historico') {
                return redirect(route('historico.index'));
            }
        }
    }

    public function adicionarColaborador(Request $request, Projeto $projeto, $window = 'null')
    {
        $validated = $request->validate([
            'novoColaboradorId' => 'required|exists:users,id',
        ]);

        $novoColaboradorId = $validated['novoColaboradorId'];

        if ($projeto->users()->where('id', $novoColaboradorId)->exists()) {
            return redirect()->route('clientes.show', $projeto->cliente_id);
        }

        $pU = new ProjetoUser;
        $pU->projeto_id = $projeto->id;
        $pU->user_id = $novoColaboradorId;
        $pU->save();

        if ($request->has('origin')) {
            $origin = $request['origin'];
            if ($origin === 'clientes') {
                return redirect(route('clientes.show', ['cliente' => $projeto->cliente_id, 'window' => $request['window']]));
            }elseif($origin === 'prioridades'){
                return redirect(route('prioridades.index', $request['user']));
            }
        }
    }

    // No ProjetoController
    public function buscarColaboradoresDisponiveis(Projeto $projeto)
    {
        $todosColaboradores = User::where('tipo', 'colaborador')->get();
        $colaboradoresDisponiveis = $todosColaboradores->diff($projeto->users);

        return response()->json($colaboradoresDisponiveis);
    }

    public function updateTimeSpent(Request $request, Projeto $projeto, User $user)
    {
        $validated = $request->validate([
            'tempoGasto' => ' required'
        ]);

        $pU = ProjetoUser::where('projeto_id', $projeto->id)->where('user_id', $user->id)->first();
        $pU->tempo_gasto = $validated['tempoGasto'];

        $pU->update();

        return redirect(route('prioridades.index', $user->id));
    }

    public function updateObs(Request $request, Projeto $projeto, User $user)
    {
        $validated = $request->validate([
            'observacoes' => ' required'
        ]);

        $pU = ProjetoUser::where(['projeto_id' => $projeto->id, 'user_id' => $user->id])->first();
        $pU->observacoes = $validated['observacoes'];
        $pU->update();
        return redirect(route('prioridades.index', $user->id));
    }

    public function updateEstadoProjeto(Request $request, Projeto $projeto){
        // dd($projeto);
        $newId = $request['secondaryStatus'];
        if($newId == 5){
            $projeto->estado_projeto_id = 5;
            $projeto->update();
            return redirect(route('prioridades.index', $request['user']));
        }
        $projeto->estado_secundario_id = $newId;
        $projeto->update();
        return redirect(route('prioridades.index', $request['user']));
    }

}