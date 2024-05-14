<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'tipo' => 'required|in:admin,colaborador',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'max:255',
            'email' => 'email|unique:users,email,' . $user->id,
            'tipo' => 'in:admin,colaborador',
            // Não inclua a validação de senha aqui se a senha não puder ser alterada neste formulário
        ]);

        $user->update($validatedData);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        if (auth()->user() && auth()->user()->tipo == 'admin') {
            DB::table('projeto_users')->where('user_id', $user->id)->delete();
            $user->delete();
        }
        return redirect()->route('users.index');
    }

    public function updateType(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->tipo = $request->tipo;
        $user->save();

        return back()->with('success', 'Tipo de usuário atualizado com sucesso!');
    }

    public function toggleFerias(Request $request, $id){
        $user = User::findOrFail($id);
        if ($request->has('toggleFerias')) {
            $user->vacation = true;
        } else{
            $user->vacation = false;
        }
        $user->save();
        return redirect()->route('prioridades.index');
    }
}
