<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Projeto;
use App\Models\User;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
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
        $validatedData = $request->validate([
            'nome' => 'required|max:255',
            'email' => 'required|email',
            'telefone' => 'required',
        ]);
        Cliente::create($validatedData);
        return redirect()->route('clientes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
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

        return view('clientes.show', compact('cliente', 'projetosAbertos', 'projetosConcluidos', 'colaboradores'));
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
            'nome' => 'required|max:255',
            'email' => 'required|email',
            'telefone' => 'required',
        ]);
        $cliente->update($validatedData);
        return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index');
    }
}
