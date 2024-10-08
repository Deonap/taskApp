<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\TipoProjeto;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TipoCliente;
use App\Models\Projeto;
use PhpOption\None;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('nome', 'asc')->get();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'nome' => 'required|max:255',
                'email' => 'required|email',
                'telefone' => 'required',
            ]);

            Cliente::create($validatedData);
            return redirect()->route('clientes.index');
        } catch (\Exception $e) {
            $errorMessage = 'Já existe um cliente com esse e-mail.';
            return redirect()->route('clientes.index')->with('error', $errorMessage);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente, $window = 'null')
    {
        if($window == 'null'){
            $window = 'projetosAbertos';
        }
        // Buscar projetos relacionados ao cliente
        $projetosAbertos = $cliente->projetos()->where('estado_projeto_id', '!=', 5)->get();
        $projetosConcluidos = $cliente->projetos()->where('estado_projeto_id', 5)->get();

        // Buscar colaboradores do tipo 'colaborador'
        $colaboradores = User::where('tipo', 'colaborador')->get();

        foreach ($projetosAbertos as $projeto) {
            foreach ($projeto->users as $user) {
                $user->tempoGasto = $projeto->users()->where('user_id', $user->id)->first()->pivot->tempo_gasto;
            }
        }

        $tiposCliente =  TipoCliente::orderBy('nome', 'asc')->get();
        $tipoProjeto = TipoProjeto::orderBy('nome', 'asc')->get();

        return view('clientes.show', compact('cliente', 'projetosAbertos', 'projetosConcluidos', 'colaboradores', 'tiposCliente', 'tipoProjeto', 'window'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validatedData = $request->validate([
            'nome' => 'string|max:255',
            'email' => 'email',
            'telefone' => 'numeric',
        ]);
        $cliente->update($validatedData);
        return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            $projetos = Projeto::where('cliente_id', '=', $cliente->id)->get();
            
            // Check if there are associated projects
            if ($projetos->count() > 0) {
                // Optional: you can also throw an exception manually here
                throw new \Exception('Clientes com projetos associados não podem ser removidos.');
            }

            $cliente->delete();

            return redirect()->route('clientes.index');
        } catch (\Exception $e) {
            $errorMessage = 'Clientes com projetos associados não podem ser removidos.';
            return redirect()->route('clientes.index')->with('error', $errorMessage);
        }
    }
}
