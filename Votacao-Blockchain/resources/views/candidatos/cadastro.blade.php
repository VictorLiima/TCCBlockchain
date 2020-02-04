@extends('layouts.app')

@push('scripts')
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>

<script>
    $(document).ready(function($) {
        $('.date').mask('00/00/0000');
        $('.time').mask('00:00:00');
        $('.date_time').mask('00/00/0000 00:00:00');
        $('#cep').mask('00000-000');
        $('#rg').mask('000000000000000');
        $('.tel').mask('(00) 00000-0000');
        $('.mixed').mask('AAA 000-S0S');
        $('.cpf').mask('000.000.000-00', {
            reverse: true
        });
    });
</script>
@endpush

@section('content')
<div class="container">
    @if(session()->has('mensagemSucesso'))
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class=" alert alert-success">
                {{ session()->get('mensagemSucesso') }}
            </div>
        </div>
    </div>
    @endif
    @if (session()->has('mensagemErro'))
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class=" alert alert-danger">
                {{ session()->get('mensagemErro') }}
            </div>
        </div>
    </div>
    @endif
    @if ($errors->any())
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class=" alert alert-danger">
                Houve um erro, por favor confira se preencheu todos os dados corretamente.
            </div>
        </div>
    </div>
    @endif

    <?php
    $usuarioLogado = Illuminate\Support\Facades\Auth::user();
    //$dataAtual = Carbon\Carbon::now()->toDateString();
    $dataAtual = Carbon\Carbon::now();
    if (isset($paciente)) {
        $idadePaciente = Carbon\Carbon::createFromDate($paciente->data_nascimento)->diffInDays(Carbon\Carbon::now(), false);
    }
    ?>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(isset($paciente))
            <form method="POST" action="{{route('alterarPaciente', $paciente->id)}}">
                @else
                <form method="POST" action="{{route('cadastrarPaciente')}}">
                    @endif
                    @csrf
                    <div class="card">
                        <div class="card-header bg-success text-white">{{ __('Dados Pessoais') }}</div>
                        <div class="card-body border-secondary">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="id">Código</label>
                                    <input type="text" class="form-control" name="id" id="id" value="@if(isset($paciente)){{$paciente->id}}@endif" disabled>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="idade">Idade</label>
                                    <input type="text" class="form-control" name="idade" id="idade" value="@if(isset($paciente)){{Carbon\Carbon::createFromDate($paciente->data_nascimento)->diff(Carbon\Carbon::now())->format('%yA %mM %dD')}}@endif" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome completo</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror" maxlength="255" name="nome" id="nome" placeholder="Nome completo" value="@if(isset($paciente)){{$paciente->nome}}@else{{old('nome')}}@endif" @if(isset($paciente)) @if(($paciente->fk_users_id != $usuarioLogado->id) && ($usuarioLogado->permissao != 'Administrador')) readonly @endif @endif>
                                    @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="sus">Cartão SUS</label>
                                    <input type="text" class="form-control" name="sus" id="sus" placeholder="000000000000000" maxlength="20" value="@if(isset($paciente)){{$paciente->sus}}@else{{old('sus')}}@endif">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="nome_mae">Nome da mãe</label>
                                    <input type="text" class="form-control" id="nome_mae" maxlength="255" name="nome_mae" placeholder="Nome da mãe" value="@if(isset($paciente)){{$paciente->nome_mae}}@else{{old('nome_mae')}}@endif">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_nascimento">Nascimento</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" min="1900-01-01" max='{{$dataAtual}}' value="@if(isset($paciente)){{$paciente->data_nascimento}}@else{{old('data_nascimento')}}@endif" @if(isset($paciente)) @if(($paciente->fk_users_id != $usuarioLogado->id) && ($usuarioLogado->permissao != 'Administrador')) readonly @endif @endif>
                                </div>
                                <div class="col-md-2 ">
                                    <label for="sexo">Sexo</label>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" required name="sexo" id="masculino" value="Masculino" @if(isset($paciente)) @if($paciente->sexo ==='Masculino') checked @endif @elseif(old('sexo')=='Masculino' ) checked @endif>
                                            <label class="form-check-label" for="masculino">Masculino</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sexo" id="feminino" value="Feminino" @if(isset($paciente)) @if($paciente->sexo ==='Feminino') checked @endif @elseif(old('sexo')=='Feminino' ) checked @endif>
                                            <label class="form-check-label" for="feminino">Feminino</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="gestante">Gestante</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="gestante" name="gestante" @if(isset($paciente)) @if($paciente->gestante=='Sim') checked @endif @elseif(old('gestante')=='Sim' ) checked @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="obito">Óbito</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="obito" name="obito" @if(isset($paciente)) @if($paciente->obito=='Sim') checked @endif @elseif(old('obito')=='Sim' ) checked @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="localidade">Localidade</label>
                                    <input type="text" class="form-control" id="localidade" name="localidade" maxlength="255" value="@if(isset($paciente)){{$paciente->localidade}}@else{{old('localidade')}}@endif">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" class="form-control tel" id="telefone" name="telefone" maxlength="20" placeholder="(00) 00000-0000" value="@if(isset($paciente)){{$paciente->telefone}}@else{{old('telefone')}}@endif">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nome">Telefone Alternativo</label>
                                    <input type="text" class="form-control tel" id="telefone_alternativo" maxlength="20" name="telefone_alternativo" placeholder="(00) 00000-0000" value="@if(isset($paciente)){{$paciente->telefone_alternativo}}@else{{old('telefone_alternativo')}}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observacoes">Observações</label>
                                <textarea class="form-control" id="observacoes" name="observacoes" maxlength="65000" rows="4">@if(isset($paciente)){{$paciente->observacoes}}@else{{old('observacoes')}}@endif</textarea>
                            </div>
                        </div>
                        <div class="card-header bg-success text-white">{{ __('Vacinas') }}</div>
                        <div class="card-body">
                            <div class="form-row">
                                @foreach($listaVacinas as $vacina)
                                <?php
                                if (isset($paciente)) {
                                    $vacinaQuery = null;
                                    $vacinaQueryExiste = Illuminate\Support\Facades\DB::table('pacientes_vacinas')
                                        ->where(
                                            [
                                                ['fk_pacientes_id', '=', $paciente->id],
                                                ['fk_vacinas_id', '=', $vacina->id],
                                            ]
                                        )->exists();
                                    if ($vacinaQueryExiste) {
                                        $vacinaQuery = Illuminate\Support\Facades\DB::table('pacientes_vacinas')
                                            ->where(
                                                [
                                                    ['fk_pacientes_id', '=', $paciente->id],
                                                    ['fk_vacinas_id', '=', $vacina->id],
                                                ]
                                            )->get();
                                    }
                                    if (isset($paciente) && !isset($vacinaQuery[0])) {
                                        $vacinaAtrasada = false;
                                        $dataNascimentoPaciente = Carbon\Carbon::createFromDate($paciente->data_nascimento);

                                        if ($idadePaciente >= 0 && $idadePaciente >= $vacina->inicio_minimo_dias && $idadePaciente <= $vacina->inicio_maximo_dias) {
                                            $vacinaAtrasada = true;
                                        } else {
                                            $vacinaAtrasada = false;
                                        }
                                       // echo $vacinaAtrasada ? 'true' : 'false';
                                    }
                                }
                                ?>
                                @if(isset($vacinaAnterior))
                                @if(($vacinaAnterior->vacina) != ($vacina->vacina))
                            </div>
                            <div class="form-row">

                                @endif
                                @endif
                                <div class="form-group col-md-2">
                                    <label for="dataVacina[]">{{$vacina->vacina}} - {{$vacina->dose}}</label>
                                    <input type="text" class="form-control" id="idVacina[]" name="idVacina[]" value="{{$vacina->id}}" hidden>
                                    @if($vacina->vacina == "Outras")
                                    <input type="text" class="form-control" id="descricaoOutras[]" name="descricaoOutras[]" value="@if(isset($paciente) && isset($vacinaQuery[0])){{$vacinaQuery[0]->descricao_outras}}@else{{old('descricaoOutras[]')}}@endif" @if(isset($paciente) && isset($vacinaQuery[0])) @if(($vacinaQuery[0]->fk_users_id != $usuarioLogado->id) && ($vacinaQuery[0]->fk_users_id != null) && ($usuarioLogado->permissao != 'Administrador')) readonly @endif @endif>
                                    @else
                                    <input type="text" class="form-control" id="descricaoOutras[]" name="descricaoOutras[]" value="@if(isset($paciente) && isset($vacinaQuery[0])){{$vacinaQuery[0]->descricao_outras}}@else{{old('descricaoOutras[]')}}@endif" hidden @if(isset($paciente) && isset($vacinaQuery[0])) @if(($vacinaQuery[0]->fk_users_id != $usuarioLogado->id) && ($vacinaQuery[0]->fk_users_id != null) && ($usuarioLogado->permissao != 'Administrador')) readonly @endif @endif>
                                    @endif

                                    <input type="date" class="form-control
                                    @if(isset($paciente) && !isset($vacinaQuery[0]))
                                    @if($vacinaAtrasada)
                                       border-danger
                                        @endif
                                        @endif
                                    " id="dataVacina[]" name="dataVacina[]" min="1900-01-01" max='{{$dataAtual}}' value="@if(isset($paciente) && isset($vacinaQuery[0])){{$vacinaQuery[0]->data_aplicacao}}@else{{old('dataVacina[]')}}@endif" @if(isset($paciente) && isset($vacinaQuery[0])) @if(($vacinaQuery[0]->fk_users_id != $usuarioLogado->id) && ($vacinaQuery[0]->fk_users_id != null) && ($usuarioLogado->permissao != 'Administrador')) readonly @endif @endif>
                                    <select class="form-control" id="unidadeVacina[]" name="unidadeVacina[]" @if(isset($paciente) && isset($vacinaQuery[0])) @if(($vacinaQuery[0]->fk_users_id != $usuarioLogado->id) && ($vacinaQuery[0]->fk_users_id != null) && ($usuarioLogado->permissao != 'Administrador')) hidden @endif @endif>
                                        <option value=''>Unidade</option>
                                        @foreach($listaUnidades as $unidade)
                                        <option value="{{$unidade->id}}" @if(isset($paciente) && isset($vacinaQuery[0])) @if(($vacinaQuery[0]->fk_unidades_id) == $unidade->id) selected @endif @endif >{{$unidade->nome}}</option>
                                        @endforeach
                                    </select>
                                    @if(isset($paciente) && isset($vacinaQuery[0]))
                                    @if(($vacinaQuery[0]->fk_users_id != $usuarioLogado->id) && ($vacinaQuery[0]->fk_users_id != null) && (Auth::user()->permissao != 'Administrador'))
                                    <select class="form-control" id="unidadeVacinaDisabled[]" name="unidadeVacinaDisabled[]" disabled>
                                        <option value=''>Unidade</option>
                                        @foreach($listaUnidades as $unidade)
                                        <option value="{{$unidade->id}}" @if(isset($paciente) && isset($vacinaQuery[0])) @if(($vacinaQuery[0]->fk_unidades_id) == $unidade->id) selected @endif @endif >{{$unidade->nome}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                    @endif
                                    @if(isset($paciente) && !isset($vacinaQuery[0]))
                                    @if($vacinaAtrasada)
                                    <p class="text-justify small text-danger">
                                        <strong>A idade mínima para a vacina é de {{$vacina->inicio_minimo_dias}} dias. A máxima é de {{$vacina->inicio_maximo_dias}} dias.</strong>
                                    </p>
                                    @endif
                                    @endif
                                </div>

                                <?php
                                $vacinaAnterior = $vacina;
                                ?>
                                @endforeach
                            </div>
                            @if(isset($paciente))
                            <button type="submit" class="btn btn-primary">Alterar</button>
                            @else
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                            @endif
                        </div>
                    </div>
                </form>
        </div>
    </div>
    @endsection