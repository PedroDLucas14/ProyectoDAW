{{-- toDo->placeholder para los labels flotantes --}}

@extends('layouts.gestions')

@section('titulo-tabla')
    <i class="fa-solid fa-person-rifle"></i> Añadir nuevo piloto
@endsection

@section('contenido-tabla')
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('listaPilotos') }}"> Volver</a>
                </div>
            </div>
        </div>
        <form action="{{ 'crearPiloto' }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-xs-12 col-sm-12 col-md-12 piloto" id="divImagen">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Imagen</label>
                    <input class="form-control piloto" type="file" id="formFile" name="imagen">
                    @if ($errors->has('imagen'))
                        <span class="text-danger">{{ $errors->first('imagen') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 ">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="inputNombre" name="nombre" value="{{ old('nombre') }}"
                        placeholder="Nombre">
                    <label for="inputNombre">Nombre</label>
                    @if ($errors->has('nombre'))
                        <span class="text-danger">{{ $errors->first('nombre') }}</span>
                    @endif
                </div>
            </div>
            <fieldset class="p-2">
                <legend class="float-none w-auto p-2">Atributos</legend>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row mt-3">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control piloto" name="ataque" id="inputAtaque"
                                    value="{{ old('ataque') }}" placeholder="Ataque">
                                <label for="inputAtaque">Ataque</label>
                                @if ($errors->has('ataque'))
                                    <span class="text-danger">{{ $errors->first('ataque') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control piloto" name="aumento_ataque" id="inputAtaqueUp"
                                    value="{{ old('aumento_ataque') }}" placeholder="Aumento de ataque">
                                <label for="inputAtaqueUp">Aumento de ataque
                                    por nivel</label>
                                @if ($errors->has('aumento_ataque'))
                                    <span class="text-danger">{{ $errors->first('aumento_ataque') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row mt-3">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control piloto" name="defensa" id="inputDefensa"
                                    value="{{ old('defensa') }}" placeholder="Defensa">
                                <label for="inputDefensa">Defensa</label>
                                @if ($errors->has('defensa'))
                                    <span class="text-danger">{{ $errors->first('defensa') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control piloto" name="aumento_defensa" id="inputDefensaUp"
                                    value="{{ old('aumento_defensa') }}" placeholder="Aumento defensa">
                                <label for="inputDefensaUp">Aumento de defensa por nivel</label>
                                @if ($errors->has('aumento_defensa'))
                                    <span class="text-danger">{{ $errors->first('aumento_defensa') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row mt-3">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control piloto" name="resistencia" id="inputResistencia"
                                    value="{{ old('resistencia') }}" placeholder="Resistencia">
                                <label for="inputResistencia">Resistencia</label>
                                @if ($errors->has('resistencia'))
                                    <span class="text-danger">{{ $errors->first('resistencia') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control piloto" name="aumento_resistencia"
                                    id="inputResisUp" value="{{ old('aumento_resistencia') }}"
                                    placeholder="Aumento resistencia">
                                <label for="inputResisUp">Aumento de resistencia por nivel</label>
                                @if ($errors->has('aumento_resistencia'))
                                    <span class="text-danger">{{ $errors->first('aumento_resistencia') }}</span>
                                @endif
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
                                <input type="number" class="form-control piloto" name="valor" id="inputValor"
                                    value="{{ old('valor') }}" placeholder="Valor">
                                <label for="inputValor">Valor</label>
                                @if ($errors->has('valor'))
                                    <span class="text-danger">{{ $errors->first('valor') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control piloto" name="coste_nivel" id="inputCostelvup"
                                    value="{{ old('coste_nivel') }}" placeholder="Coste nivel">
                                <label for="inputCostelvup">Coste de nivel</label>
                                @if ($errors->has('coste_nivel'))
                                    <span class="text-danger">{{ $errors->first('coste_nivel') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Crear piloto</button>
            </div>
        </form>
    </div>
@endsection
