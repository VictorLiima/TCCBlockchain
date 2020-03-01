<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class NosController extends Controller
{
    public function index()
    {
        $listaUsuarios = User::paginate(15);

        return view(
            'nos/nos',
            [
                'listaUsuarios' => $listaUsuarios,
            ],
        );
    }

    public function cadastrarNo(Request $request)
    {

        $listaUsuarios = User::paginate(15);

        //Criando json para se comunicar com a blockchain
       $dados = array("nodes" => null);
       $string = json_encode($dados);
    
        //cURL
        $ch = curl_init("http://localhost:5000/nodes/register");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_exec($ch);
        $response = curl_exec($ch);
        curl_close($ch);

        print_r($response);
        // return view(
        //     'nos/nos',
        //     [
        //         'listaUsuarios' => $listaUsuarios,
        //     ],
        // );
    }
}
