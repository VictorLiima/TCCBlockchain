<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Unidade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsuariosController extends Controller
{

    public function index()
    {
        $listaUsuarios = User::paginate(15);
        //  $listaVacinas = DB::table('vacinas')->paginate(15);

        return view(
            'usuarios/usuarios',
            [
                'listaUsuarios' => $listaUsuarios,
            ],

        );
    }

    public function getUsuario(int $id)
    {
        $usuario = User::find($id);
        $listaUnidades = Unidade::all();

        return view(
            'usuarios/cadastro',
            [
                'usuario' => $usuario,
                'listaUnidades' => $listaUnidades,

            ]
        );
    }

    public function telaCadastroUsuario()
    {
        $listaUnidades = Unidade::all();

        return view('usuarios/cadastro', [
            'listaUnidades' => $listaUnidades,
        ]);
    }

    public function telaRedefinirSenha()
    {
      //  $listaUnidades = Unidade::all();
        $usuario = [
            auth()->user(),
        ];
        if (Auth()->user()->senha_redefinida == null) {
            return view(
                'usuarios/redefinirsenha',
                [
                    'usuario' => auth()->user(),
                ]
            );
        } 
        else return redirect()->route('/');
    }

    public function cadastrarUsuario(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            //'senha' => 'required|string|min:6|confirmed',
            'cpf' => 'required|string|min:14|max:14|unique:users',
            'unidade' => 'required|string',
            'permissao' => 'required|string',
            'funcao' => 'required|string',
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->password = Hash::make('123456'); //Senha padrão na criação do usuário
        $usuario->email = $request->email;
        $usuario->cpf = $request->cpf;
        $usuario->unidade = $request->unidade;
        $usuario->permissao = $request->permissao;
        $usuario->funcao = $request->funcao;


        $usuario->save();

        return redirect()->route('usuarios');
    }

    public function alterarUsuario(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            //'senha' => 'required|string|min:6|confirmed',
            'unidade' => 'required|string',
            'permissao' => 'required|string',
            'funcao' => 'required|string',
        ]);

        $usuario = User::find($id);
        $usuario->name = $request->name;
        //$usuario->password = Hash::make($request->senha);
        $usuario->unidade = $request->unidade;
        $usuario->permissao = $request->permissao;
        $usuario->funcao = $request->funcao;

        $usuario->save();

        return redirect()->route('usuarios');
    }

    public function redefinirSenha(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'senha' => 'required|string|min:6|confirmed',
        ]);

        $usuario = User::find($id);
        $usuario->password = Hash::make($request->senha);
        $usuario->senha_redefinida = Carbon::now();

        $usuario->save();

        return redirect()->route('usuarios');
    }

    public function deletarUsuario(int $id)
    {
        $vacina = User::find($id);
        $vacina->delete();

        return redirect()->route('usuarios');
    }

    public function buscaUsuario(Request $request)
    {
        //$q = Input::get('q');
        $q = $request->input('q');
        //Conversão da data
        //$dataBr = $q;
        // $date = str_replace('/', '-', $dataBr);
        // $dataSql = date("Y-m-d", strtotime($date));

        //Busca
        if ($q != "") {
            $listaUsuarios = User::where('name', 'LIKE', '%' . $q . '%')
                ->orWhere('unidade', 'LIKE', '%' . $q . '%')
                ->orWhere('funcao', 'LIKE', '%' . $q . '%')
                ->paginate(15)->setPath('/vacinas/busca');
            $pagination = $listaUsuarios->appends(array(
                'q' => $q
            ));
            if (count($listaUsuarios) > 0)
                return view(
                    'usuarios/usuarios',
                    [
                        'listaUsuarios' => $listaUsuarios
                    ]
                );
        } else {
            return redirect()->route('usuarios');
        }

        return view('usuarios/usuarios')->withMessage('No Details found. Try to search again !');
    }
}
