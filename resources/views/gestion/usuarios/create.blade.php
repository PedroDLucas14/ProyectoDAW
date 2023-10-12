@extends('layouts.gestions')

@section('titulo-tabla')
    <i class="fa-solid fa-user-plus"></i> Añadir nuevo usuario
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
        <form action="{{ route('crearUsuario') }}" method="post" class="row mt-3 g-3" enctype="multipart/form-data">
            @csrf
            <div class="col-xs-12 col-sm-12 col-md-6 ">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="inputNick" name="nick" placeholder="Nick"
                        value="{{ old('nick') }}" placeholder="Nick">
                    <label for="inputNick">Nick</label>
                    @if ($errors->has('nick'))
                        <span class="text-danger">{{ $errors->first('nick') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 ">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="inputNombre" name="nombre" placeholder="Nombre"
                        value="{{ old('nombre') }}" placeholder="Nombre">
                    <label for="inputNombre">Nombre</label>
                    @if ($errors->has('nombre'))
                        <span class="text-danger">{{ $errors->first('nombre') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 ">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email"
                        value="{{ old('email') }}" placeholder="Email">
                    <label for="inputEmail">Email</label>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 ">
                <div class="form-floating mb-3">
                    <input type="date" name="fecha_nacimiento" id="inputDate" class="form-control"
                        value="{{ old('fecha_nacimiento') }}">
                    <label for="inputDate">Fecha de Nacimiento</label>
                    @if ($errors->has('fecha_nacimiento'))
                        <span class="text-danger">{{ $errors->first('fecha_nacimiento') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 ">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password"
                        placeholder="Contraseña">
                    <label for="inputPassword">Contraseña</label>
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 ">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="inputConfirPass" name="confirmarPassword"
                        placeholder="Confirmar Contraseña">
                    <label for="inputConfirPass">Confirmar contraseña</label>
                    @if ($errors->has('confirmarPassword'))
                        <span class="text-danger">{{ $errors->first('confirmarPassword') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 ">
                <select class="form-select" id="inputRol" name="role">
                    <option>Rol del usuario</option>
                    <option value="administrador" @if (old('role') == 'administrador') selected @endif>Administrador</option>
                    <option value="jugador" @if (old('role') == 'jugador') selected @endif>Jugador</option>
                    <option value="mantenimiento " @if (old('role') == 'mantenimiento') selected @endif>Mantenimiento</option>
                </select>
                @if ($errors->has('role'))
                    <span class="text-danger">{{ $errors->first('role') }}</span>
                @endif
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 ">
                <div class="mb-3">
                    <label for="inputAvatar" class="form-label">Avatar</label>
                    <input class="form-control" type="file" id="inputAvatar" name="avatar">
                    @if ($errors->has('avatar'))
                        <span class="text-danger">{{ $errors->first('avatar') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row mt-3">
                    <label for="inputCreditos" class="col-xs-2 col-sm-2 col-md-1 col-form-label">Créditos</label>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <input type="number" class="form-control" name="creditos" id="inputCreditos" value="0"
                            placeholder="0">
                        @if ($errors->has('creditos'))
                            <span class="text-danger">{{ $errors->first('creditos') }}</span>
                        @endif
                    </div>
                    <label for="inputVictorias" class="col-xs-2 col-sm-2 col-md-1 col-form-label">Victorias</label>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <input type="number" class="form-control" name="victorias" id="inputVictorias" value="0"
                            placeholder="0">
                    </div>
                    <label for="inputDerrotas" class="col-xs-2 col-sm-2 col-md-1 col-form-label">Derrotas</label>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <input type="number" class="form-control" name="derrotas" id="inputDerrotas" value="0"
                            placeholder="0">
                    </div>
                    <label for="inputPuntos" class="col-xs-2 col-sm-2 col-md-1 col-form-label">Puntos</label>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <input type="number" class="form-control" name="puntos" id="inputPuntos" value="0"
                            placeholder="0">
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Crear Usuario</button>
            </div>
        </form>
    </div>
@endsection
