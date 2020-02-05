<?php

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

Route::get('/', 'HomeController@index')->name('/');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::middleware(['auth', 'Administrador', 'SenhaRedefinida'])->group(function () {
    Route::get('/usuarios', 'UsuariosController@index')->name('usuarios');
    Route::get('/usuarios/cadastro', 'UsuariosController@telaCadastroUsuario')->name('telaCadastroUsuario');
    Route::get('/usuarios/cadastro/{id}', 'UsuariosController@getUsuario')->name('usuarioId');
    Route::post('/usuarios/delete/{id}', 'UsuariosController@deletarUsuario')->name('deletarUsuario');
    Route::post('/usuarios/cadastro/novo', 'UsuariosController@cadastrarUsuario')->name('cadastrarUsuario');
    Route::post('/usuarios/cadastro/alterar/{id}', 'UsuariosController@alterarUsuario')->name('alterarUsuario');
    Route::any('/usuarios/busca', 'UsuariosController@buscaUsuario')->name('usuariosBusca');

    
    Route::get('/candidatos/cadastro', 'CandidatosController@telaCadastroCandidato')->name('telaCadastroCandidato');
    Route::get('/candidatos/cadastro/{id}', 'CandidatosController@getCandidato')->name('candidatoId');
    Route::post('/candidatos/cadastro/novo', 'CandidatosController@cadastrarCandidato')->name('cadastrarCandidato');
    Route::post('/candidatos/cadastro/alterar/{id}', 'CandidatosController@alterarCandidato')->name('alterarCandidato');
    Route::post('/candidatos/deletar/{id}', 'CandidatosController@deletarCandidato')->name('deletarCandidato');

});


Route::middleware(['auth', 'SenhaRedefinida'])->group(function () {
    Route::get('/resultado', 'ResultadoController@index')->name('resultado');

    Route::get('/candidatos/visualizar/{id}', 'CandidatosController@visualizarCandidato')->name('visualizarCandidato');
    Route::get('/candidatos', 'CandidatosController@index')->name('candidatos');
    Route::any('/candidatos/busca', 'CandidatosController@buscaCandidato')->name('candidatosBusca');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios/redefinir', 'UsuariosController@telaRedefinirSenha')->name('telaRedefinirSenha');
    Route::post('/usuarios/redefinir/altera/{id}', 'UsuariosController@redefinirSenha')->name('redefinirSenha');
});