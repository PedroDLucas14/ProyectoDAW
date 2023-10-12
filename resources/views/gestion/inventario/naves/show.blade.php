@extends('layouts.gestions')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection
@section('jsExtra')
    <script src="{{ asset('js/gestion.js') }}" type="module"></script>
@endsection
@section('titulo-pagina')
    <i class="fa-solid fa-rocket"></i> Nave {{ $usuariosNave->nave->nombre }}
@endsection
@section('contenido-tabla')
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('listaNavesUsuario', $usuario) }}"> Volver</a>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Ha ocurrido un error en los siguientes campos.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form action="{{ route('modificarUsuarioNave', $usuariosNave) }}" method="post" class="row mt-3 g-3"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- @dd($usuariosNave->nave) --}}
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="cod_usuario" id="inputCodUsuario"
                            value="{{ $usuariosNave->cod_usuario }}" disabled>
                        <label for="inputCodUsuario">Cod usuario</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control nave" name="cod_usuario" id="inputCodNave"
                            value="{{ $usuariosNave->cod_nave }}" disabled>
                        <label for="inputCodNave">Cod nave</label>
                    </div>
                </div>
                <fieldset class="p-2 row">
                    <legend class="float-none w-auto p-2">Atributos</legend>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control nave" name="ataque_actual" id="inputAtaque"
                                value="{{ $usuariosNave->ataque_actual }}" disabled>
                            <label for="inputAtaque">Ataque actual</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control nave" name="defensa_actual" id="inputDefensa"
                                value="{{ $usuariosNave->defensa_actual }}" disabled>
                            <label for="inputDefensa">Defensa actual</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control nave" name="resistencia_actual" id="inputResistencia"
                                value="{{ $usuariosNave->resistencia_actual }}" disabled>
                            <label for="inputResistencia">Resistencia actual</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control nave" name="nivel" id="inputNivel"
                                value="{{ $usuariosNave->nivel }}" disabled>
                            <label for="inputNivel">Nivel</label>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    @endsection
