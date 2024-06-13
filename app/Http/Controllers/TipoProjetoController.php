<?php

namespace App\Http\Controllers;

use App\Models\TipoProjeto;
use App\Models\Projeto;
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
            'nome' => 'required|unique:tipo_projetos|max:255'
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
            'nome' => 'string|max:255'
        ]);
        $tipoProjeto->update($validatedData);
        return redirect()->route('tipo-projetos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoProjeto $tipoProjeto)
    {
        try {
            $projetos = Projeto::where('cliente_id', '=', $tipoProjeto->id)->get();
            
            // Check if there are associated projects
            if ($projetos->count() > 0) {
                // Optional: you can also throw an exception manually here
                throw new \Exception('Tipos de projeto associados a projetos não podem ser removidos.');
            }

            $tipoProjeto->delete();

            return redirect()->route('tipo-projetos.index');
        } catch (\Exception $e) {
            $errorMessage = 'Tipos de projeto associados a projetos não podem ser removidos.';
            return redirect()->route('tipo-projetos.index')->with('error', $errorMessage);
        }
    }


}
