<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidato;
use App\User;

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
    }

    public function votarCandidato(String $nomeCandidato)
    {

        $remetente = auth()->user()->id;
        $eleitor = User::find($remetente);

        if ($eleitor->jaVotou != 1){
        
        $candidato = $nomeCandidato;
        $quantidade = 1;

        //Criando json para se comunicar com a blockchain
        $dados = array("sender" => $remetente, "recipient" => $candidato, "amount" => $quantidade);
        $string = json_encode($dados, JSON_UNESCAPED_UNICODE);

        //cURL criando uma nova transação de voto
        $ch = curl_init("http://localhost:5000/transactions/new");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        // Mineração
        $ch = curl_init("http://localhost:5000/mine");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        // Saving
        $ch = curl_init("http://localhost:5000/save");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        //Verificação se o eleitor já votou
        $eleitor->jaVotou = TRUE;
        $eleitor->save();
    }
        return redirect('votacao');




    }
}
