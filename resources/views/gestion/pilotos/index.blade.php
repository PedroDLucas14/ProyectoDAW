@extends('layouts.gestions')

@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection

@section('filtro')
    <div class="col-xl-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-filter"></i>
                Filtros
            </div>
            <div class="card-body">
                <form class="row g-1" action="{{ route('listaPilotos') }}" method="post">
                    @csrf
                    <input type="text" hidden value="pilotos" name="cat">
                    <div class="col-8">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputNombre" name="nombre" placeholder="Nombre">
                            <label for="inputCreditos">Nombre</label>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-2">
                        <div class="form-floating">
                            <input type="number" min="0" class="form-control" id="inputCreditos" name="valorTotal"
                                placeholder="Créditos">
                            <label for="inputCreditos">Créditos</label>
                        </div>
                        <select name="operadorCreditos" class="form-control" id="">
                            <option value="=" selected>=</option>
                            <option value="<">></option>
                            <option value=">">
                                &lt; </option>
                        </select>
                    </div>
                    <div class="col-2">
                        <div class="form-floating">
                            <input type="number" min="0" class="form-control" id="inputResistencia"
                                name="resistencia" placeholder="Resistencia">
                            <label for="inputCreditos">Resistencia</label>
                        </div>
                        <select name="operadorResistencia" class="form-control" id="">
                            <option value="=" selected>=</option>
                            <option value="<">></option>
                            <option value=">">
                                &lt; </option>
                        </select>
                    </div>
                    <div class="col-2">
                        <div class="form-floating">
                            <input type="number" min="0" class="form-control" id="inputAtaque" name="ataque"
                                placeholder="Ataque">
                            <label for="inputCreditos">Ataque</label>
                        </div>
                        <select name="operadorAtaque" class="form-control" id="">
                            <option value="=" selected>=</option>
                            <option value="<">></option>
                            <option value=">">
                                &lt; </option>
                        </select>
                    </div>
                    <div class="col-2">
                        <div class="form-floating">
                            <input type="number" min="0" class="form-control" id="inputDefensa" name="defensa"
                                placeholder="Defensa">
                            <label for="inputCreditos">Defensa</label>
                        </div>
                        <select name="operadorDefensa" class="form-control" id="">
                            <option value="=" selected>=</option>
                            <option value="<">></option>
                            <option value=">">
                                &lt; </option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary mb-3">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('titulo-tabla')
    <i class="fa-solid fa-person-rifle"></i> Lista de pilotos
@endsection
@section('contenido-tabla')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif
    <a href="{{ route('añadirPiloto') }}" class="btn btn-success btn-sm float-end mb-3">Añadir piloto</a>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ataque</th>
                <th>Defensa</th>
                <th>Resistencia</th>
                <th>Habilidad</th>
                <th>Valor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        @if (count($pilotos) > 0)
            @foreach ($pilotos as $row)
                <tr>
                    <td>{{ $row->nombre }}</td>
                    <td>{{ $row->ataque }}</td>
                    <td>{{ $row->defensa }}</td>
                    <td>{{ $row->resistencia }}</td>
                    <td>{{ $row->dameHabilidad('nombre') }}</td>
                    <td>{{ $row->valor }}</td>
                    <td>
                        <a href="{{ route('verPiloto', ['piloto' => $row]) }}" class="btn btn-primary btn-sm">Ver /
                            Modificar</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">No hay disponibles registros</td>
            </tr>
        @endif
    </table>
    {!! $pilotos->appends(Request::except('page'))->render() !!}
@endsection
