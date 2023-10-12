{{-- toDo->placeholder para los labels flotantes --}}

@extends('layouts.gestions')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection
@section('jsExtra')
    <script src="{{ asset('js/gestion.js') }}" type="module"></script>
@endsection

@section('titulo-tabla')
    <i class="fa-solid fa-user"></i>
    Ver Usuario {{ $usuario->nick }}
@endsection

@section('contenido-tabla')
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('listaUsuarios') }}"> Volver</a>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form action="{{ route('modificarUsuario', $usuario) }}" method="post" class="row mt-3 g-3"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <img src="{{ asset($usuario->avatar) }}" class="rounded mx-auto d-block" alt="imggen-perfil"
                        style="width: 200px;height: 200px;">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 usuario" id="divAvatar" style="display: none">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Imagen</label>
                        <input class="form-control usuario" type="file" id="formFile" name="avatar">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="inputNick" name="nick"
                            value="{{ $usuario->nick }}" disabled>
                        <label for="inputNick">Nick</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control usuario" id="inputNombre" name="nombre"
                            value="{{ $acl->nombre }}" disabled>
                        <label for="inputNombre">Nombre</label>
                    </div>
                </div>
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
                            value="{{ $usuario->fecha_nacimiento->format('Y-m-d') }}" disabled>
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
                <div class="col-xs-12 col-sm-12 col-md-6 " @if (!Auth::user()->puedePermiso('administrador')) style="display: none" @endif>
                    <select class="form-select usuario" id="inputRol" name="role" disabled>
                        <option>Rol del usuario</option>
                        <option value="administrador" @if ($acl->cod_acl_role == 1)  @endif>Administrador</option>
                        <option value="jugador" @if ($acl->cod_acl_role == 2) selected @endif>Jugador</option>
                        <option value="mantenimiento " @if ($acl->cod_acl_role == 3) selected @endif>Mantenimiento
                        </option>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row mt-3">
                        <label for="inputCreditos" class="col-xs-2 col-sm-2 col-md-1 col-form-label">Créditos</label>
                        <div class="col-xs-4 col-sm-4 col-md-2">
                            <input type="number" class="form-control usuario" name="creditos" id="inputCreditos"
                                value="{{ $usuario->creditos }}" disabled>
                        </div>
                        <label for="inputVictorias" class="col-xs-2 col-sm-2 col-md-1 col-form-label">Victorias</label>
                        <div class="col-xs-4 col-sm-4 col-md-2">
                            <input type="number" class="form-control usuario" name="victorias" id="inputVictorias"
                                value="{{ $usuario->victorias }}" disabled>
                        </div>
                        <label for="inputDerrotas" class="col-xs-2 col-sm-2 col-md-1 col-form-label">Derrotas</label>
                        <div class="col-xs-4 col-sm-4 col-md-2">
                            <input type="number" class="form-control usuario" name="derrotas" id="inputDerrotas"
                                value="{{ $usuario->derrotas }}" disabled>
                        </div>
                        <label for="inputPuntos" class="col-xs-2 col-sm-2 col-md-1 col-form-label">Puntos</label>
                        <div class="col-xs-4 col-sm-4 col-md-2">
                            <input type="number" class="form-control usuario" name="puntos" id="inputPuntos"
                                value="{{ $usuario->puntos }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3 usuario" id="updateUser" hidden>Guardar
                        Cambios</button>
                    <button type="button" class="btn btn-primary mb-3 usuario" id="editarUsuario"
                        @if (!Auth::user()->puedePermiso('administrador')) disabled @endif>Editar</button>
                </div>
            </form>
        </div>
    @endsection
