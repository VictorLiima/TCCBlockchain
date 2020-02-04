@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white"><i class="fas fa-key"></i> {{ __('Redefinir Senha') }}</div>

                <div class="card-body">
                    <p class="text-justify">Olá {{$usuario['name']}} ({{$usuario['email']}}), por favor redefina a sua senha para continuar. A senha deve possuir pelo menos 6 caracteres.</p>

                    @if(isset($usuario))
                    <form method="POST" action="{{route('redefinirSenha', $usuario->id)}}">
                        @endif
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="senha">{{ __('Senha') }}</label>
                                <input id="senha" type="password" class="form-control @error('senha') is-invalid @enderror" name="senha" required autocomplete="new-senha">
                                @error('senha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="senha-confirm">{{ __('Confirmação de senha') }}</label>
                                <input id="senha-confirm" type="password" class="form-control" name="senha_confirmation" required autocomplete="new-senha">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col">
                                @if(isset($usuario))
                                <button type="submit" class="btn btn-primary">Alterar</button>
                                @else
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection