{{-- toDo->placeholder para los labels flotantes --}}

@extends('layouts.gestions')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection
@section('jsExtra')
    <script src="{{ asset('js/gestion.js') }}" type="module"></script>
@endsection

@section('titulo-tabla')
    <i class="fa-solid fa-screwdriver-wrench"></i> Accesorio {{ $accesorio->nombre }}
@endsection


@section('contenido-tabla')
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('listaAccesorios') }}"> Volver</a>
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
            <form action="{{ route('modificarAccesorio', $accesorio) }}" method="post" class="row mt-3 g-3"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <img src="{{ asset($accesorio->imagen) }}" class="rounded mx-auto d-block" alt="Imagen-accesorio"
                        style="width: 20em;">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 nave" id="divImagen" style="display: none">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Imagen</label>
                        <input class="form-control nave" type="file" id="formFile">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="inputNick" name="nombre"
                            value="{{ $accesorio->nombre }}" disabled>
                        <label for="inputNombre">Nombre</label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <textarea class="form-control accesorio" id="ta-descripcion" name="descripcion" style="height: 100px" disabled>{{ $accesorio->descripcion }}</textarea>
                        <label for="ta-descripcion">Descripción</label>
                    </div>
                </div>
                <fieldset class="p-2">
                    <legend class="float-none w-auto p-2">Atributos</legend>
                    @if ($accesorio->ataque != null)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control accesorio" name="ataque" id="inputAtaque"
                                            value="{{ $accesorio->ataque }}" disabled>
                                        <label for="inputAtaque">Ataque</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control accesorio" name="aumento_ataque"
                                            id="inputAtaqueUp" value="{{ $accesorio->aumento_ataque }}" disabled>
                                        <label for="inputAtaqueUp">Aumento de ataque
                                            por nivel</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($accesorio->defensa != null)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control accesorio" name="defensa"
                                            id="inputDefensa" value="{{ $accesorio->defensa }}" disabled>
                                        <label for="inputDefensa">Defensa</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control accesorio" name="aumento_defensa"
                                            id="inputDefensaUp" value="{{ $accesorio->aumento_defensa }}" disabled>
                                        <label for="inputDefensaUp">Aumento de defensa por nivel</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($accesorio->resistencia != null)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control accesorio" name="resistencia"
                                            id="inputResistencia" value="{{ $accesorio->resistencia }}" disabled>
                                        <label for="inputResistencia">Resistencia</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control accesorio" name="aumento_defensa"
                                            id="inputResisUp" value="{{ $accesorio->aumento_resistencia }}" disabled>
                                        <label for="inputResisUp">Aumento de resistencia por nivel</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </fieldset>
                <fieldset class="p-2">
                    <legend class="float-none w-auto p-2">Costes</legend>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row mt-3">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control accesorio" name="valor" id="inputValor"
                                        value="{{ $accesorio->valor }}" disabled>
                                    <label for="inputValor">Valor</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control accesorio" name="coste_nivel"
                                        id="inputCostelvup" value="{{ $accesorio->coste_nivel }}" disabled>
                                    <label for="inputCostelvup">Coste de nivel</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3 accesorio" id="updateAccesorio" hidden>Guardar
                        Cambios</button>
                    <button type="button" class="btn btn-primary mb-3 accesorio" id="editarAccesorio">Editar</button>
                </div>
            </form>
        </div>
    @endsection
