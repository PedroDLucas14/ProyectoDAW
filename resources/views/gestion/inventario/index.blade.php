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
                <form class="row mt-3" action="{{ route('gestionInventarios') }}" method="post">
                    @csrf
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputNick" name="nick" placeholder="Nick"
                                value="@isset($datosFiltrados['nick']) {{ $datosFiltrados['nick'] }} @endisset">
                            <label for="inputNick">Nick</label>
                        </div>
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
    <i class="fa-solid fa-warehouse"></i>
    Lista de Usuarios
@endsection

@section('contenido-tabla')
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nick</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        @if (count($usuarios) > 0)
            @foreach ($usuarios as $row)
                <tr>
                    <td>{{ $row->nick }}</td>
                    <td>{{ $row->email }}</td>
                    <td>
                        <a href="{{ route('listaNavesUsuario', ['usuario' => $row]) }}" class="btn btn-primary btn-sm">Ver
                            Naves </a>
                        <a href="{{ route('listaPilotosUsuario', ['usuario' => $row]) }}" class="btn btn-primary btn-sm">Ver
                            Pilotos</a>
                        <a href="{{ route('listaAccUsuario', ['usuario' => $row]) }}" class="btn btn-primary btn-sm">Ver
                            Accesorios</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">No hay disponibles registros</td>
            </tr>
        @endif
    </table>
    {!! $usuarios->links() !!}
@endsection
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif
    <aside>
        <li><a href="{{ route('gestion') }}">Gestión</a></li>
        <li><a href="{{ route('listaUsuarios') }}">Usuarios</a></li>
        <li><a href="{{ route('listaNaves') }}">Naves</a></li>
        <li><a href="{{ route('listaPilotos') }}">Pilotos</a></li>
        <li><a href="{{ route('listaAccesorios') }}">Accesorios</a></li>
    </aside>
    <form class="row g-1" action="{{ route('mercado.ver') }}" method="post">
        @csrf
        <input type="text" hidden value="pilotos" name="cat">
        <div class="col-auto">
            <div class="form-floating">
                <input type="text" class="form-control" id="inputNombre" name="nombre" placeholder="Nombre">
                <label for="inputCreditos">Nombre</label>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-auto">
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
        <div class="col-auto">
            <div class="form-floating">
                <input type="number" min="0" class="form-control" id="inputResistencia" name="resistencia"
                    placeholder="Resistencia">
                <label for="inputCreditos">Resistencia</label>
            </div>
            <select name="operadorResistencia" class="form-control" id="">
                <option value="=" selected>=</option>
                <option value="<">></option>
                <option value=">">
                    &lt; </option>
            </select>
        </div>
        <div class="col-auto">
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
        <div class="col-auto">
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
        <div class="col-6">
            <div class="d-grid gap-2">
                <input type="submit" class="btn btn-primary" value="Filtrar">
                <input type="reset" class="btn btn-primary" value="Limpiar">
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6"><b>Lista de usuarios</b></div>
                <div class="col col-md-6">
                    <a href="{{ route('añadirUsuario') }}" class="btn btn-success btn-sm float-end">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>Nick</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
                @if (count($usuarios) > 0)
                    @foreach ($usuarios as $row)
                        <tr>
                            <td>{{ $row->nick }}</td>
                            <td>{{ $row->email }}</td>
                            <td>
                                <a href="{{ route('listaNavesUsuario', ['usuario' => $row]) }}"
                                    class="btn btn-primary btn-sm">Ver Naves </a>
                                <a href="" class="btn btn-warning btn-sm">Ver Pilotos</a>
                                <a href="" class="btn btn-warning btn-sm">Ver Accesorios</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No hay disponibles registros</td>
                    </tr>
                @endif
            </table>
            {!! $usuarios->links() !!}
        </div>
    </div>

@endsection
