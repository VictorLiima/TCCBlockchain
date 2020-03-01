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
    
    <?php
    $usuarioLogado = Illuminate\Support\Facades\Auth::user();
    ?>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{route('cadastrarNo')}}">
            @csrf
                <div class="card">
                    <div class="card-header bg-success text-white">{{ __('Cadastrar Nó') }}</div>
                    <div class="card-body border-secondary">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="enderecoNo">Endereço do nó</label>
                                <input type="text" class="form-control" maxlength="255" name="enderecoNo" id="enderecoNo" placeholder="Endereço do nó">
                            </div>
                        </div>
                        <p>Exemplo: http://localhost:5001</p>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection