@extends('layouts.plantilla')

@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endsection

@section('jsExtra')
    <script src="{{ asset('js/perfil.js') }}" defer></script>
    <style>
        main {
            background: url({{ asset('img/fondo.jpg') }});
        }

        main {
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
@endsection

@section('mainMenu')
    @auth
        @if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('jugador'))
            <li><a href="{{ route('jugar') }}">Jugar</a></li>
        @endif
    @endauth
    <li><a href="{{ route('index.clasificacion') }}">Clasificación</a></li>
    @auth
        @if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('jugador'))
            <li><a href="{{ route('perfil.inventario') }}">Inventario</a></li>
            <li><a href="{{ route('mercado.ver') }}">Mercado</a></li>
        @endif
        @if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('mantenimiento'))
            <li><a href="{{ route('gestion') }}">Gestión</a></li>
        @endif
        <li> <a href="{{ route('perfil.index') }}">Usuario: {{ Auth::user()->nick }}</a> </li>
    @endauth
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="tabs">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item">
                <a class="nav-link active" id="nav-perfil-tab" data-toggle="tab" href="#perfil">Perfil</a>
            </li>
            @if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('jugador'))
                <li class="nav-item">
                    <a class="nav-link" id="nav-perfil-tab" data-toggle="tab" href="#historial">Historial de partidas</a>
                </li>
            @endif
        </ul>
        <div class="tab-content p-3">
            <div class="tab-pane fade show active" id="perfil">
                <div class="container">
                    <form class="row g-3" action="{{ route('perfil.update') }}" enctype="multipart/form-data"
                        id="perfil" method="POST">
                        @csrf
                        <div class="text-center">
                            <img src="{{ $usuario->avatar }}" class="rounded" alt="Imagen-Perfil"
                                style="height: 150px; width: 150px">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 usuario" id="divAvatar" style="display: none">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Imagen</label>
                                <input class="form-control usuario" type="file" id="formFile" name="avatar">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="inputNick" name="nick"
                                    value="{{ $usuario->nick }}" disabled>
                                <label for="inputNick">Nick</label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control usuario" id="inputEmail" name="email"
                                    value="{{ $usuario->email }}" disabled>
                                <label for="inputEmail">Email</label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                            <div class="form-floating mb-3">
                                <input type="date" name="fecha_nacimiento" id="inputDate" class="form-control usuario"
                                    disabled value="{{ $usuario->fecha_nacimiento->format('Y-m-d') }}">
                                <label for="inputDate">Fecha de Nacimiento</label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 usuario" id="pass" style="display: none">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="inputPassword" name="password"
                                    placeholder="Password">
                                <label for="inputPassword">Contraseña</label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 usuario" id="confPass" style="display: none">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="inputConfirPass" name="confirmarPassword"
                                    placeholder="Confirmar Contraseña">
                                <label for="inputConfirPass">Confirmar contraseña</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-starwars mb-3 usuario" id="updateUser" hidden>Guardar
                                Cambios</button>
                            <button type="button" class="btn btn-starwars mb-3" id="editarDatos">Editar datos</button>
                            <a class="btn btn-starwars mb-3" href="{{ route('perfil.inventario') }}">Ver inventario</a>
                        </div>
                    </form>
                    @if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('jugador'))
                        <div class="pb-2 col-xs-12 col-sm-12 col-md-12 ">
                            <legend>Estaditisicas</legend>
                            <div class="row mt-3 mb-3">
                                <label for="inputCreditos"
                                    class="col-xs-2 col-sm-2 col-md-1 col-form-label">Créditos</label>
                                <div class="col-xs-4 col-sm-4 col-md-2">
                                    <input type="number" class="form-control" name="creditos" id="inputCreditos"
                                        value="{{ $usuario->creditos }}" disabled>
                                </div>
                                <label for="inputVictorias"
                                    class="col-xs-2 col-sm-2 col-md-1 col-form-label">Victorias</label>
                                <div class="col-xs-4 col-sm-4 col-md-2">
                                    <input type="number" class="form-control" name="victorias" id="inputVictorias"
                                        value="{{ $usuario->victorias }}" disabled>
                                </div>
                                <label for="inputDerrotas"
                                    class="col-xs-2 col-sm-2 col-md-1 col-form-label">Derrotas</label>
                                <div class="col-xs-4 col-sm-4 col-md-2">
                                    <input type="number" class="form-control" name="derrotas" id="inputDerrotas"
                                        value="{{ $usuario->derrotas }}" disabled>
                                </div>
                                <label for="inputPuntos" class="col-xs-2 col-sm-2 col-md-1 col-form-label">Puntos</label>
                                <div class="col-xs-4 col-sm-4 col-md-2">
                                    <input type="number" class="form-control" name="puntos" id="inputPuntos"
                                        value="{{ $usuario->puntos }}" disabled>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('jugador'))
                <div class="tab-pane fade" id="historial">
                    <table class="table table-hover table-bordered pt-4" id="tb-clasificacion">
                        <thead>
                            <tr>
                                <th>Batalla</th>
                                <th>Fecha</th>
                                <th>Hora inicio</th>
                                <th>Hora final</th>
                                <th>Usuario ganador</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        @if (count($paginatedData) > 0)
                            @foreach ($paginatedData as $row)
                                <tr>
                                    <td>{{ $row->cod_batalla }}</td>
                                    <td>{{ $row->fecha }}</td>
                                    <td>{{ $row->hora_inicio }}</td>
                                    <td>{{ $row->hora_final }}</td>
                                    <td>{{ $row->nickUsuarioGanador() }}</td>
                                    <td> <a href="{{ route('verPartida', $row) }}"><i
                                                class="fa-solid fa-magnifying-glass"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No hay batallas registradas</td>
                            </tr>
                        @endif
                    </table>
                    {!! $paginatedData->fragment('historial')->links() !!}
                </div>
            @endif

        </div>
    </div>

@endsection
