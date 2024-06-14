<?php

namespace App\Http\Controllers;

use App\Models\TipoCliente;
use App\Models\Projeto;
use Illuminate\Http\Request;

class TipoClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoCliente::orderBy('nome', 'asc')->get();
        return view('parametrizacoes.tipos.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parametrizacoes.tipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|unique:tipo_clientes|max:255',
            'cor' => 'required',
        ]);
        TipoCliente::create($validatedData);
        return redirect()->route('tipo-clientes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoCliente $tipoCliente)
    {
        return view('parametrizacoes.tipos.show', compact('tipoCliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoCliente $tipoCliente)
    {
        return view('parametrizacoes.tipos.edit', compact('tipoCliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoCliente $tipoCliente)
    {
        $validatedData = $request->validate([
            'nome' => 'string|max:255',
            'cor' => 'string',
        ]);
        $tipoCliente->update($validatedData);
        return redirect()->route('tipo-clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoCliente $tipoCliente)
    {
        try {
            $projetos = Projeto::where('tipo_cliente_id', '=', $tipoCliente->id)->get();
            
            // Check if there are associated projects
            if ($projetos->count() > 0) {
                // Optional: you can also throw an exception manually here
                throw new \Exception('Tipos de cliente associados a projetos não podem ser removidos.');
            }

            $tipoCliente->delete();

            return redirect()->route('tipo-clientes.index');
        } catch (\Exception $e) {
            $errorMessage = 'Tipos de cliente associados a projetos não podem ser removidos.';
            return redirect()->route('tipo-clientes.index')->with('error', $errorMessage);
        }
    }


}
