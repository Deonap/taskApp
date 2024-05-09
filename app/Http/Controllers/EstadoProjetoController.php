<?php

namespace App\Http\Controllers;

use App\Models\EstadoProjeto;
use Illuminate\Http\Request;

class EstadoProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = EstadoProjeto::all();
        return view('parametrizacoes.estados.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parametrizacoes.estados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|unique:estado_projetos|max:255',
            'cor' => 'required',
        ]);
        EstadoProjeto::create($validatedData);
        return redirect()->route('estado-projetos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(EstadoProjeto $estadoProjeto)
    {
        return view('parametrizacoes.estados.show', compact('estadoProjeto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstadoProjeto $estadoProjeto)
    {
        return view('parametrizacoes.estados.edit', compact('estadoProjeto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EstadoProjeto $estadoProjeto)
    {
        $validatedData = $request->validate([
            'nome' => 'string|max:255',
            'cor' => 'string',
        ]);
        $estadoProjeto->update($validatedData);
        return redirect()->route('estado-projetos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstadoProjeto $estadoProjeto)
    {
        $estadoProjeto->delete();
        return redirect()->route('estado-projetos.index');
    }
}
