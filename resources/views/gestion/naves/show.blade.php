{{-- toDo->placeholder para los labels flotantes --}}

@extends('layouts.gestions')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection
@section('jsExtra')
    <script src="{{ asset('js/gestion.js') }}" type="module"></script>
@endsection

@section('titulo-tabla')
    <i class="fa-solid fa-rocket"></i> Nave {{ $nave->nombre }}
@endsection

@section('contenido-tabla')
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('listaNaves') }}"> Volver</a>
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
            <form action="{{ route('modificarNave', $nave) }}" method="post" class="row mt-3 g-3"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <img src="{{ asset($nave->imagen) }}" class="rounded mx-auto d-block" alt="Imagen-nave"
                        style="width: 200px;height: 200px;">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 nave" id="divImagen" style="display: none">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Imagen</label>
                        <input class="form-control nave" type="file" id="formFile">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="inputNick" name="nombre" value="{{ $nave->nombre }}"
                            disabled>
                        <label for="inputNombre">Nombre</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control nave" id="inputNumAcc" name="num_accesorios"
                            value="{{ $nave->num_accesorios }}" disabled>
                        <label for="inputNombre">Nº de Accesorios</label>
                    </div>
                </div>
                <fieldset class="p-2">
                    <legend class="float-none w-auto p-2">Atributos</legend>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row mt-3">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control nave" name="ataque" id="inputAtaque"
                                        value="{{ $nave->ataque }}" disabled>
                                    <label for="inputAtaque">Ataque</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control nave" name="aumento_ataque" id="inputAtaqueUp"
                                        value="{{ $nave->aumento_ataque }}" disabled>
                                    <label for="inputAtaqueUp">Aumento de ataque
                                        por nivel</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row mt-3">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control nave" name="defensa" id="inputDefensa"
                                        value="{{ $nave->defensa }}" disabled>
                                    <label for="inputDefensa">Defensa</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control nave" name="aumento_defensa"
                                        id="inputDefensaUp" value="{{ $nave->aumento_defensa }}" disabled>
                                    <label for="inputDefensaUp">Aumento de defensa por nivel</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row mt-3">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control nave" name="resistencia" id="inputResistencia"
                                        value="{{ $nave->resistencia }}" disabled>
                                    <label for="inputResistencia">Resistencia</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control nave" name="aumento_resistencia"
                                        id="inputResisUp" value="{{ $nave->aumento_resistencia }}" disabled>
                                    <label for="inputResisUp">Aumento de resistencia por nivel</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="p-2">
                    <legend class="float-none w-auto p-2">Costes</legend>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row mt-3">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control nave" name="valor" id="inputValor"
                                        value="{{ $nave->valor }}" disabled>
                                    <label for="inputValor">Valor</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control nave" name="coste_nivel"
                                        id="inputCostelvup" value="{{ $nave->coste_nivel }}" disabled>
                                    <label for="inputCostelvup">Coste de nivel</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3 nave" id="updateNave" hidden>Guardar
                        Cambios</button>
                    <button type="button" class="btn btn-primary mb-3 nave" id="editarNave">Editar</button>
                </div>
            </form>
        </div>
    @endsection
