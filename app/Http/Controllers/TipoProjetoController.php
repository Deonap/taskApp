<?php

namespace App\Http\Controllers;

use App\Models\TipoProjeto;
use Illuminate\Http\Request;

class TipoProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoProjeto::all();
        return view('parametrizacoes.projetos.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('parametrizacoes.tipos.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|unique:tipo_clientes|max:255',
            'cor' => 'required',
        ]);
        TipoProjeto::create($validatedData);
        return redirect()->route('tipo-projetos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoProjeto $tipoProjeto)
    {
        return view('parametrizacoes.projetos.show', compact('tipoProjeto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoProjeto $tipoProjeto)
    {
        return view('parametrizacoes.projetos.edit', compact('tipoProjeto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoProjeto $tipoProjeto)
    {
        $validatedData = $request->validate([
            'nome' => 'string|max:255',
            'cor' => 'string',
        ]);
        $tipoProjeto->update($validatedData);
        return redirect()->route('tipo-projetos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoProjeto $tipoProjeto)
    {
        $tipoProjeto->delete();
        return redirect()->route('tipo-projetos.index')->with('success', 'Tipo de cliente excluído com sucesso');
    }
}
