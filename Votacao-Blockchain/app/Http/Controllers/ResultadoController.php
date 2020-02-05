<?php

namespace App\Http\Controllers;

use App\Candidato;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultadoController extends Controller
{
    public function index()
    {
        $listaCandidatos = Candidato::all();
        $listaUsuarios = User::all();

        return view(
            'resultado/resultado',
            [
                'listaCandidatos' => $listaCandidatos,
                'listaUsuarios' => $listaUsuarios,
            ]
        );
    }
}
