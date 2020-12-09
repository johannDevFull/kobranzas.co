<?php
use App\Http\Controllers\BuildController;
use App\Http\Controllers\LlamadasController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;                  

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (){
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');
 
// PAGINA EN CONSTRUCCION
Route::get('construir', BuildController::class)->name('construir');

// PERMISOS USUARIO 
Route::middleware(['auth'])->group(function () {
    Route::get('permission/show/{user}',[PermisosController::class,'getRol']);  
   
    Route::post('user/store', [UserController::class,'store'])->name('user.store')
                                                        ->middleware('permission:user.create');
    Route::get('user', [UserController::class,'index'])->name('user.index')
                                                        ->middleware('permission:user.index');
    Route::get('user/create', [UserController::class,'create'])->name('user.create')
                                                        ->middleware('permission:user.create');
    Route::put('user/{id}', [UserController::class,'update'])->name('user.update')
                                                        ->middleware('permission:user.edit');
    Route::get('user/{id}', [UserController::class,'show'])->name('user.show')
                                                        ->middleware('permission:user.show');
    Route::delete('user/{id}', [UserController::class,'destroy'])->name('user.destroy')
                                                        ->middleware('permission:user.destroy');
    Route::get('user/{id}/edit', [UserController::class,'edit'])->name('user.edit')
                                                        ->middleware('permission:user.edit');
});

// PERMISOS LLAMADAS 
Route::middleware(['auth'])->group(function () {
   
    Route::get('llamadas', [LlamadasController::class, 'index'])
        ->name('llamadas');

    Route::get('llamadas/create', [LlamadasController::class, 'create'])
        ->name('llamadas.create');

    Route::post('llamadas', [LlamadasController::class, 'store'])
        ->name('llamadas.store');

    Route::get('llamadas/{user}/edit', [LlamadasController::class, 'edit'])
        ->name('llamadas.edit');

    Route::put('llamadas/{user}', [LlamadasController::class, 'update'])
        ->name('llamadas.update'); 

    Route::delete('llamadas/{user}', [LlamadasController::class, 'destroy'])
        ->name('llamadas.destroy'); 

    Route::put('llamadas/{user}/restore', [LlamadasController::class, 'restore'])
        ->name('llamadas.restore'); 
});





// GISTION DE ROLES Y PERMISSOS
Route::middleware(['auth'])->group(function () {
    
    // GET INDEX :Vista permisos
    Route::get('/permisos', [PermisosController::class,'index'])->name('permisos');
    // POST STORE ROL :Crear rol
    Route::post('/rol', [PermisosController::class,'storeRol'])->name('rol');
    // POST SOTORE PERMISO :Crear permiso
    Route::post('/permiso', [PermisosController::class,'storePermiso'])->name('permiso');
    // *** POST SOTORE : Asiganar rol a un usuario por id
    Route::post('/asignar', [PermisosController::class,'test'])->name('asignar');




    // TEST=  STORE ROL
    Route::post('/create/rol',[PermisosController::class,'storeRol'])->name('create.rol');
    Route::post('/permisos/crear', [PermisosController::class,'test'])->name('rol.permisos');

    // Testing  
    // Route::post('/permisos', [PermisosController::class,'testIP'])->name('permisos.dos');
    // // 
    // Route::get('/asigna', [PermisosController::class,'asignaT'])->name('asigna');
    // // 
    // Route::get('asigna/permisos', [PermisosController::class, 'asignaTP'])->name('asigna.permisos');

    // Route::get('/permisos/show', [PermisosController::class, 'index'])->name('permisos.show');

    
}); 

// Route to test
// Route::get('prueba', [PermisosController::class,'test'])->name('prueba');

