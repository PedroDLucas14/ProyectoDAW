@extends('layouts.gestions')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection
@section('jsExtra')
    <script src="{{ asset('js/gestion.js') }}" type="module"></script>
@endsection
@section('titulo-pagina')
    <i class="fa-solid fa-rocket"></i> Accesorio {{ $usuarioAccesorio->accesorio->nombre }}
@endsection
@section('contenido-tabla')
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('listaAccUsuario', $usuario) }}"> Volver</a>
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
            <form action="{{ route('modificarAccUsuario', $usuarioAccesorio) }}" method="post" class="row mt-3 g-3">
                @csrf
                @method('PUT')
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="cod_usuario" id="inputCodUsuario"
                            value="{{ $usuarioAccesorio->cod_usuario }}" disabled>
                        <label for="inputCodUsuario">Cod usuario</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control accesorio" name="cod_usuario" id="inputCodAccesorio"
                            value="{{ $usuarioAccesorio->cod_accesorio }}" disabled>
                        <label for="inputCodAccesorio">Cod Accesorio</label>
                    </div>
                </div>
                <fieldset class="p-2 row">
                    <legend class="float-none w-auto p-2">Atributos</legend>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control accesorio" name="ataque_actual" id="inputAtaque"
                                value="{{ $usuarioAccesorio->ataque_actual }}" disabled>
                            <label for="inputAtaque">Ataque actual</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control accesorio" name="defensa_actual" id="inputDefensa"
                                value="{{ $usuarioAccesorio->defensa_actual }}" disabled>
                            <label for="inputDefensa">Defensa actual</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control accesorio" name="resistencia_actual"
                                id="inputResistencia" value="{{ $usuarioAccesorio->resistencia_actual }}" disabled>
                            <label for="inputResistencia">Resistencia actual</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control accesorio" name="nivel" id="inputNivel"
                                value="{{ $usuarioAccesorio->nivel }}" disabled>
                            <label for="inputNivel">Nivel</label>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    @endsection
