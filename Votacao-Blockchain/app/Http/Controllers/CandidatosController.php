<?php

namespace App\Http\Controllers;

use App\Candidato;
use Illuminate\Http\Request;

class CandidatosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $listaCandidatos = Candidato::paginate(15);

        return view(
            'candidatos/candidatos',
            [
                'listaCandidatos' => $listaCandidatos,
            ],
        );
    }

}
