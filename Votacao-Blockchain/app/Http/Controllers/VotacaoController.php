<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidato;

class VotacaoController extends Controller
{
    public function index()
    {
        $listaCandidatos = Candidato::paginate(15);

        return view(
            'votacao/votacao',
            [
                'listaCandidatos' => $listaCandidatos,
            ]
        );
    }}
