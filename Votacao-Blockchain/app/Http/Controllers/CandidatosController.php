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

    public function getCandidato(int $id)
    {
        $candidato = Candidato::find($id);

        return view(
            'candidatos/cadastro',
            [
                'candidato' => $candidato,
            ]
        );
    }

    public function buscaCandidato(Request $request)
    {
        //$q = Input::get('q');
        $q = $request->input('q');

        //Conversão da data
        $dataBr = $q;
        $date = str_replace('/', '-', $dataBr);
        $dataSql = date("Y-m-d", strtotime($date));

        //Busca
        if ($q != "") {
            $listaCandidatos = Candidato::where('nome', 'LIKE', '%' . $q . '%')
                //->orWhere('localidade', 'LIKE', '%' . $q . '%')
                //->orWhere('data_nascimento', 'LIKE', '%' . $dataSql . '%')
                //->orWhere('sus', 'LIKE', '%' . $q . '%')
                ->paginate(15)->setPath('/candidatos/busca');
            $pagination = $listaCandidatos->appends(array(
                'q' => $q
            ));
            if (count($listaCandidatos) > 0)
                return view(
                    'candidatos/candidatos',
                    [
                        'listaCandidatos' => $listaCandidatos
                    ]
                );
        } else {
            return redirect()->route('candidatos');
        }

        return view('candidatos/candidatos')->withMessage('No Details found. Try to search again !');
    }

    public function visualizarCandidato(int $id)
    {
        $candidato = Candidato::find($id);

        return view(
            'candidatos/visualizacao',
            [
                'candidato' => $candidato,
            ]
        );
    }

    public function telaCadastroCandidato()
    {
        return view(
            'candidatos/cadastro',
        );
    }

    public function cadastrarCandidato(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        $candidato = new Candidato();
        $candidato->nome = $request->nome;
        $candidato->save();

        return redirect()->route('candidatos');
    }

    public function alterarCandidato(Request $request, int $id)
    {
        try {


            $candidato = Candidato::find($id);
            $candidato->nome = $request->nome;

            $candidato->save();
            return back()->with('mensagemSucesso', "Alteração realizada com sucesso.");
        } catch (Exception $ex) {
            return back()->with('mensagemErro', "Ocorreu um erro (" + $ex + ").");
        }
    }

    public function deletarCandidato(int $id)
    {
        $candidato = Candidato::find($id);
        $candidato->delete();

        return redirect()->route('candidatos');
    }

}
