<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Projeto;
use App\Models\User;
use App\Models\EstadoProjeto;

class HistoricoController extends Controller
{
    public function index(Request $request)
    {
        $colaboradores = User::where('tipo', 'colaborador')->get();
        $colaboradorId = $colaboradores->first()->id ?? null;

        $dataSelecionada = $request->input('data_selecionada'); // Pega a data selecionada pelo usuário
        $inicioSemana = Carbon::parse($dataSelecionada)->startOfWeek();
        $fimSemana = Carbon::parse($dataSelecionada)->endOfWeek();
        logger()->info('Request recebido:', $request->all());
        // Faça as consultas aqui para buscar os dados das tabelas
        $projetosEmAberto = $this->filtrarProjetosPorEstadoEColaborador('Em desenvolvimento',$colaboradorId, $inicioSemana, $fimSemana);
        $projetosPendentes = $this->filtrarProjetosPorEstadoEColaborador('Pendente', $colaboradorId, $inicioSemana, $fimSemana);

        $projetosComOutros = $this->filtrarProjetosComOutrosColaboradores($request);

        $corDesenvolvimento = EstadoProjeto::where('nome', 'Em desenvolvimento')->value('cor');
        $corPendente = EstadoProjeto::where('nome', 'Pendente')->value('cor');

        logger()->info('Request recebido:', $request->all());
        logger()->info('Projetos com outros colaboradores no Index:', $projetosComOutros->toArray());

        return view('historico.index', compact( 'colaboradores', 'inicioSemana', 'fimSemana', 'projetosEmAberto', 'projetosPendentes','projetosComOutros','corDesenvolvimento','corPendente'));
    }

    private function filtrarProjetosPorEstadoEColaborador($estadoNome, $colaboradorId, $inicioSemana, $fimSemana)
    {
        return Projeto::with(['tarefas', 'tipoCliente', 'cliente', 'estadoProjeto', 'users' => function($query) use ($colaboradorId) {
            $query->where('users.id', $colaboradorId);
        }])->whereHas('estadoProjeto', function ($query) use ($estadoNome) {
            $query->where('nome', $estadoNome);
        })->whereHas('users', function ($query) use ($colaboradorId) {
            $query->where('users.id', $colaboradorId);
        })
        // Filtra projetos atualizados dentro do período da semana selecionada
        ->whereBetween('updated_at', [$inicioSemana, $fimSemana])
        ->get();
    }

    //public function filtrarProjetosComOutrosColaboradores(Request $request)
    //{
    // $colaboradorId = $request->query('colaborador_id');
    // $inicioSemana = Carbon::parse($request->query('inicio_semana'));
    // $fimSemana = Carbon::parse($request->query('fim_semana'));

    //   $projetos = Projeto::whereHas('users', function ($query) use ($colaboradorId) {
    //                      $query->where('id', $colaboradorId);
    //                  })
    //                  ->whereHas('users', function ($query) use ($colaboradorId) {
    //                      $query->where('id', '!=', $colaboradorId);
    //                   })
    //                  ->whereBetween('updated_at', [$inicioSemana, $fimSemana])
    //                  ->with(['tarefas', 'tipoCliente', 'cliente', 'estadoProjeto', 'users'])
    //                   ->get();
    //
    //   return response()->json($projetos);
    //}
    public function filtrarProjetosComOutrosColaboradores(Request $request)
    {
        $colaboradorId = $request->query('colaborador_id');
        $inicioSemana = $request->query('inicio_semana');
        $fimSemana = $request->query('fim_semana');

        $projetos = Projeto::with(['tarefas', 'tipoCliente', 'cliente', 'estadoProjeto', 'users'])
                        ->whereHas('users', function ($query) use ($colaboradorId) {
                            $query->where('id', $colaboradorId);
                        })->whereBetween('updated_at', [$inicioSemana, $fimSemana])
                        ->get()
                        ->filter(function ($projeto) {
                            return $projeto->users->count() > 1;
                        });
                        logger()->info('Projetos com outros colaboradores:', $projetos->toArray());
        // Retorna a coleção de projetos diretamente
        return $projetos;
    }


    public function filtrarProjetos(Request $request)
    {
        $colaboradorId = $request->query('colaborador_id');
        $inicioSemana = $request->query('inicio_semana');
        $fimSemana = $request->query('fim_semana');
        $estado = 'Em desenvolvimento'; // Define o estado que você está interessado

        $projetos = Projeto::with(['tarefas', 'tipoCliente', 'cliente', 'estadoProjeto', 'users'])
                        ->whereHas('users', function ($query) use ($colaboradorId) {
                            $query->where('id', $colaboradorId);
                        })->whereHas('estadoProjeto', function ($query) use ($estado) {
                            $query->where('nome', $estado);
                        })->whereBetween('updated_at', [$inicioSemana, $fimSemana])
                        ->get();

        return response()->json($projetos);
    }



    public function filtrarProjetosPendente(Request $request)
    {
        $colaboradorId = $request->query('colaborador_id');
        $inicioSemana = $request->query('inicio_semana');
        $fimSemana = $request->query('fim_semana');
        $estado = 'Pendente'; // Define o estado que você está interessado

        // Aqui, você não precisa declarar novamente $inicioSemana e $fimSemana porque eles serão pegos da query string.
        

        $projetos = Projeto::with(['tarefas', 'tipoCliente', 'cliente', 'estadoProjeto'])
                        ->whereHas('users', function ($query) use ($colaboradorId) {
                            $query->where('id', $colaboradorId);
                        })->whereHas('estadoProjeto', function ($query) use ($estado) {
                            $query->where('nome', $estado);
                        })->whereBetween('updated_at', [$inicioSemana, $fimSemana])
                        ->get();

        return response()->json($projetos);
    }
}