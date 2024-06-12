<?php
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\EstadoProjetoController;
use App\Http\Controllers\TipoClienteController;
use App\Http\Controllers\TipoProjetoController;
use App\Http\Controllers\PrioridadesController;
use App\Http\Controllers\HistoricoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Mail\projectStatusChanged;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('clientes', ClienteController::class);
Route::get('/clientes/{cliente}/{window?}', [ClienteController::class, 'show'])->name('clientes.show');
Route::resource('projetos', ProjetoController::class);

Route::resource('estado-projetos', EstadoProjetoController::class);
Route::resource('tipo-clientes', TipoClienteController::class);
Route::resource('tipo-projetos', TipoProjetoController::class);
Route::resource('users', UserController::class);
Route::put('/users/{id}/updateType', [UserController::class, 'updateType'])->name('users.updateType');
Route::put('/users/toggleFerias/{id}', [UserController::class, 'toggleFerias'])->name('users.toggleFerias');

Route::get('/prioridades/{id?}', [PrioridadesController::class, 'index'])->name('prioridades.index');
Route::get('/filtrar/projetos', [PrioridadesController::class, 'filtrarProjetos']);
Route::get('/filtrar/projetosPendentes', [PrioridadesController::class, 'filtrarProjetosPendente']);
Route::get('/filtrar/projetos-outros-colaboradores/{colaboradorId}', [PrioridadesController::class, 'filtrarProjetosComOutrosColaboradores']);
Route::get('/filtrar/projetosConcluidos', [PrioridadesController::class, 'filtrarProjetosConcluidos']);
Route::post('/salvar/projetos', [PrioridadesController::class, 'salvarProjetos']);

Route::get('/historico', [HistoricoController::class, 'index'])->name('historico.index');
Route::get('/api/historico/projetos-em-aberto', [HistoricoController::class, 'filtrarProjetos']);
Route::get('/api/historico/projetos-pendentes', [HistoricoController::class, 'filtrarProjetosPendente']);
Route::get('/api/historico/projetos-concluidos', [HistoricoController::class, 'filtrarProjetosConcluidos']);
Route::get('/api/historico/projetos-com-outros', [HistoricoController::class, 'filtrarProjetosComOutrosColaboradores']);

Route::post('/atualizar/prioridades', [PrioridadesController::class, 'atualizarOrdemProjetos']);
Route::post('/atualizar/estadoProjeto', [PrioridadesController::class, 'atualizarEstadoProjeto']);

Route::put('/projetos/{projeto}/colaboradores/atualizar', [ProjetoController::class, 'atualizarColaborador'])->name('projetos.colaboradores.atualizar');
Route::put('/projetos/{projeto}/colaboradores/remover', [ProjetoController::class, 'removerColaborador'])->name('projetos.colaboradores.remover');

Route::put('/projetos/{projeto}/{user}/updateTimeSpent', [ProjetoController::class, 'updateTimeSpent']);
Route::put('/projetos/{projeto}/updateEstadoProjeto', [ProjetoController::class, 'updateEstadoProjeto']);

Route::put('/projetos/{projeto}/{user}/updateObs', [ProjetoController::class, 'updateObs']);
Route::put('projetos/{projeto}/tipoCliente/atualizar', [ProjetoController::class, 'atualizarTipoCliente'])->name('projetos.tipoCliente.atualizar');
Route::put('projetos/{projeto}/cliente/atualizar', [ProjetoController::class, 'atualizarCliente'])->name('projetos.cliente.atualizar');
Route::put('projetos/{projeto}/tipoProjeto/atualizar', [ProjetoController::class, 'atualizartipoProjeto'])->name('projetos.tipoProjeto.atualizar');
Route::get('projetos/tipoCliente/create', [ProjetoController::class, 'createNewTipoCliente'])->name('projetos.tipoCliente.create');
Route::get('projetos/tipoProjeto/create', [ProjetoController::class, 'createNewtipoProjeto'])->name('projetos.tipoProjeto.create');

// Rota para adicionar um novo colaborador a um projeto
Route::post('/projetos/{projeto}/colaboradores/adicionar', [ProjetoController::class, 'adicionarColaborador'])->name('projetos.colaboradores.adicionar');

Route::get('/projetos/{projeto}/colaboradores/disponiveis', [ProjetoController::class, 'buscarColaboradoresDisponiveis']);

Route::get('/emailTest/{user}', function($user) {
    $user = User::find($user);
    $admins = User::where('tipo', 'admin')->get();
    foreach($admins as $a){
        Mail::to($a->email)->send(new projectStatusChanged($user));
    }
    return redirect(route('prioridades.index'));
});