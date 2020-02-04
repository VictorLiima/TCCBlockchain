@extends('layouts.app')

@section('content')
<div class="container">

    <div id="top" class="row">
        <div class="col-md-3">
            <h2><i class="fas fa-address-card"></i> Candidatos</h2>
        </div>
        <div class="col-md-6 ">
            <form action="/candidatos/busca" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input name="q" class="form-control" id="search" type="text" placeholder="Pesquisar">
                    <span class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-3 ">
            <a href="{{ route('telaCadastroCandidato') }}" class="btn btn-primary pull-right h2"><i class="fas fa-plus"></i> Novo Candidato</a>
        </div>
    </div>

    <div id="list" class="row">
        <div class="table-responsive col-md-12">
            <table class="table table-striped" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Localidade</th>
                        <th>Data de nascimento</th>
                        <th>Nº SUS</th>
                        <th class="actions">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($listaCandidatos))
                    @foreach ($listaCandidatos as $candidato)
                    <tr>
                        <td>{{$candidato->id}}</td>
                        <td>{{$candidato->nome}}</td>
                        <td>{{$candidato->localidade}}</td>
                        <td>{{date('d/m/Y', strtotime($candidato->data_nascimento))}}</td>
                        <td>{{$candidato->sus}}</td>

                        <td class="actions">
                            <a class="btn btn-secondary btn-xs" href="{{ route('visualizarCandidato', $candidato->id) }}"><i class="fas fa-print"></i> Imprimir</a>
                            
                            @if (Auth::user()->permissao == 'Administrador' || Auth::user()->permissao == 'Comum')
                            <a class="btn btn-success btn-xs" href="{{ route('candidatoId', $candidato->id) }}"><i class="far fa-eye"></i> Visualizar</a>
                            @endif

                            @if (Auth::user()->permissao == 'Administrador')
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalExclusaoCandidato{{$candidato->id}}">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                            @endif

                            <div class="modal fade" id="modalExclusaoCandidato{{$candidato->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Exclusão de candidato</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Confirma a exclusão de {{$candidato->nome}} (código: {{$candidato->id}})??
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('deletarCandidato', $candidato->id) }}" method="post">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-danger btn-xs" value="Excluir">
                                                    Excluir </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    @if(isset($listaCandidatos))
    {{ $listaCandidatos->links() }}
    @endif
</div>
@endsection