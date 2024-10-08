<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Projeto;
use App\Models\Cliente;
use App\Models\User;
use App\Models\TipoCliente;
use App\Models\ProjetoUser;
use App\Models\TipoProjeto;
use App\Models\EstadoProjeto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrioridadesController extends Controller
{
    // Dentro da classe PrioridadesController

    public function index($selectedUser = null)
    {
        $colaboradores = User::where('tipo', 'colaborador')->get();

        $colaboradorId = $colaboradores->first() ?? null;

        // Carregar projetos com informações específicas do primeiro colaborador
        $projetosEmAberto = $this->filtrarProjetosPorEstadoEColaborador('Em desenvolvimento', $colaboradorId);
        $projetosPendentes = $this->filtrarProjetosPorEstadoEColaborador('Pendente', $colaboradorId);

        $projetosComOutros = $this->filtrarProjetosComOutrosColaboradores($colaboradorId);

        if(auth()->user() && auth()->user()->tipo == 'admin'){
            ProjetoUser::query()->update(['notificacaoVista' => true]);
        }
        $clientes = Cliente::orderBy('nome', 'asc')->get();
        $tiposCliente = TipoCliente::orderBy('nome', 'asc')->get();
        $tiposProjeto = TipoProjeto::orderBy('nome', 'asc')->get();

        return view('prioridades.index', compact('selectedUser', 'colaboradores', 'projetosEmAberto', 'projetosPendentes','projetosComOutros', 'colaboradorId', 'clientes', 'tiposCliente', 'tiposProjeto'));
    }

    private function filtrarProjetosPorEstadoEColaborador($estadoNome, $colaboradorId)
    {
        return Projeto::with([
            'tarefas',
            'tipoCliente',
            'cliente',
            'estadoProjeto',
            'users' => function ($query) use ($colaboradorId) {
                $query->where('users.id', $colaboradorId);
            }])->whereHas('estadoProjeto', function ($query) use ($estadoNome) {
                $query->where('nome', $estadoNome);
            })->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
    }

    public function filtrarProjetosComOutrosColaboradores($colaboradorId)
    {
        // Busca projetos que incluem o colaborador selecionado
        $projetos = Projeto::whereHas('users', function ($query) use ($colaboradorId) {
            $query->where('id', $colaboradorId);
        })->whereHas('users', function ($query) use ($colaboradorId) {
                $query->where('id', '!=', $colaboradorId);
            })->with(['tarefas', 'tipoCliente', 'cliente', 'estadoProjeto', 'users', 'tipoProjeto'])->where('estado_projeto_id','!=','5')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]) // Add this line
            ->get();

        $colaboradores = User::where('tipo', '=', 'colaborador')->get();
        $estados = EstadoProjeto::all();

        return response()->json(['projetos' => $projetos, 'colaboradores' => $colaboradores, 'estadoProjetos' => $estados]);
    }

    public function filtrarProjetos(Request $request)
    {
        $colaboradorId = $request->query('colaborador_id');
        $estado = 'Em desenvolvimento'; // Define o estado que você está interessado

        $projetos = Projeto::with(['tarefas', 'tipoCliente', 'cliente', 'estadoProjeto', 'users', 'tipoProjeto'])
            ->join('projeto_users', 'projetos.id', '=', 'projeto_users.projeto_id')
            ->where('projeto_users.user_id', $colaboradorId)
            ->whereHas('estadoProjeto', function ($query) use ($estado) {
                $query->where('nome', $estado);
            })
            ->whereBetween('projetos.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderByRaw('ISNULL(projeto_users.prioridade), projeto_users.prioridade')
            ->select('projetos.*') // Evita colunas duplicadas
            ->get();

        $estados = EstadoProjeto::all();
        return response()->json(['projetos' => $projetos, 'estadoProjetos' => $estados]);        
    }

    public function filtrarProjetosPendente(Request $request)
    {
        $colaboradorId = $request->query('colaborador_id');
        $estado = 'Pendente'; // Define o estado que você está interessado

        $projetos = Projeto::with(['tarefas', 'tipoCliente', 'cliente', 'estadoProjeto', 'users', 'tipoProjeto'])
            ->whereHas('users', function ($query) use ($colaboradorId) {
                $query->where('id', $colaboradorId);
            })->whereHas('estadoProjeto', function ($query) use ($estado) {
                $query->where('nome', $estado);
            })->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        $estados = EstadoProjeto::all();

        return response()->json(['projetos' => $projetos, 'estadoProjetos' => $estados]);
    }

    private function buscarProjetosPorColaborador($colaboradorId, $estadoNome)
    {
        return Projeto::with(['tarefas', 'tipoCliente', 'cliente', 'estadoProjeto'])
            ->whereHas('users', function ($query) use ($colaboradorId) {
                $query->where('id', $colaboradorId);
            })
            ->whereHas('estadoProjeto', function ($query) use ($estadoNome) {
                $query->where('nome', $estadoNome);
            })
            ->get();
    }

    public function salvarProjetos(Request $request)
    {
        $dados = $request->validate([
            'projetos.*.id' => 'required|integer',
            'projetos.*.user_id' => 'required|integer',
            'projetos.*.observacoes' => 'nullable|string',
            'projetos.*.tempoGasto' => 'nullable|string',
            'projetos.*.prioridade' => 'nullable|string'
        ]);

        foreach ($dados['projetos'] as $dado) {
            $update = DB::table('projeto_users')
                ->where(['projeto_id' => $dado['id'], 'user_id' => $dado['user_id']])
                ->update([
                    'observacoes' => $dado['observacoes'],
                    'tempo_gasto' => $dado['tempoGasto'],
                    'prioridade' => $dado['prioridade']
                ]);

            if ($update === 0) {
                Log::warning("Nenhum registro atualizado para projeto_id: {$dado['id']} e user_id: {$dado['user_id']}");
                // Você pode querer retornar um erro ou continuar o loop
            }
        }

        return response()->json(['message' => 'Projetos atualizados com sucesso']);
    }

    public function atualizarOrdemProjetos(Request $request)
    {   
        $projetosData = $request->validate([
            'projetos' => 'required|array',
            'projetos.*.id' => 'required|integer',
            'projetos.*.user_id' => 'required|integer', // Validar user_id
            'projetos.*.prioridade' => 'required|integer' // Validar prioridade
        ]);

        DB::transaction(function () use ($projetosData) {
            foreach ($projetosData['projetos'] as $projeto) {
                $projetoId = $projeto['id'];
                $userId = $projeto['user_id']; // Usar o user_id fornecido
                $novaPrioridade = $projeto['prioridade'];

                DB::table('projeto_users')
                    ->where(['projeto_id' => $projetoId, 'user_id' => $userId])
                    ->update(['prioridade' => $novaPrioridade]);

                DB::table('projeto_users')
                ->where(['projeto_id' => $projetoId, 'user_id' => $userId])
                ->update(['notificacaoVista' => false]);
            }
        });

        return response()->json(['message' => 'Prioridades atualizadas com sucesso.']);
    }

    public function atualizarEstadoProjeto(Request $request)
    {
        $projetosData = $request->validate([
            'projetos' => 'required|array',
            'projetos.*.id' => 'required|integer',
            'projetos.*.user_id' => 'required|integer', // Validar user_id
            'projetos.*.estado' => 'required|integer'
        ]);
        
        DB::transaction(function () use ($projetosData) {
            foreach ($projetosData['projetos'] as $projeto) {
                $projetoId = $projeto['id'];
                $userId = $projeto['user_id'];
                $estado = $projeto['estado'];
                
                DB::table('projetos')
                    ->where('id', $projetoId)
                    ->update(['estado_projeto_id' => $estado]);

                DB::table('projeto_users')->where(['projeto_id' => $projetoId, 'user_id' => $userId])->update(['prioridade' => NULL]);

            }
        });

        return response()->json(['message' => 'Estado do projeto atualizado.']);
    }
}