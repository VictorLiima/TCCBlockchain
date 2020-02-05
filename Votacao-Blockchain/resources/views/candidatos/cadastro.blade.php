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
    ?>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(isset($candidato))
            <form method="POST" action="{{route('alterarCandidato', $candidato->id)}}">
                @else
                <form method="POST" action="{{route('cadastrarCandidato')}}">
                    @endif
                    @csrf
                    <div class="card">
                        <div class="card-header bg-success text-white">{{ __('Dados Pessoais') }}</div>
                        <div class="card-body border-secondary">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="id">Código</label>
                                    <input type="text" class="form-control" name="id" id="id" value="@if(isset($candidato)){{$candidato->id}}@endif" disabled>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="nome">Nome completo</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror" maxlength="255" name="nome" id="nome" placeholder="Nome completo" value="@if(isset($candidato)){{$candidato->nome}}@else{{old('nome')}}@endif" @if(isset($candidato)) @if(($usuarioLogado->administrador != 1)) readonly @endif @endif>
                                    @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="sus">Total Votos</label>
                                    <input type="text" class="form-control" name="totalVotos" id="totalVotos" placeholder="000000000000000" maxlength="20" value="@if(isset($candidato)){{$candidato->total_votos}}@else{{old('total_votos')}}@endif" readonly>
                                </div>
                            </div>
                            
                            @if(isset($candidato))
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