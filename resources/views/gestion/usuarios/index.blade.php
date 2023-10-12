@extends('layouts.gestions')

@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection
@section('jsExtra')
    <script src="{{ asset('js/gestion.js') }}" type="module"></script>
@endsection
@section('filtro')
    <div class="col-xl-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-filter"></i>
                Filtros
            </div>
            <div class="card-body">
                <form class="row mt-3" action="{{ route('gestion') }}" method="post">
                    @csrf
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputNick" name="nick" placeholder="Nick">
                            <label for="inputNick">Nick</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email">
                            <label for="inputEmail">Email</label>
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
    <i class="fas fa-table me-1"></i>Lista de usuarios
@endsection
@section('contenido-tabla')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif
    @if (Auth::user()->puedePermiso('administrador'))
        <a href="{{ route('añadirUsuario') }}" class="btn btn-success btn-sm float-end mb-3">Añadir Usuario</a>
    @endif
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nick</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Borrado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        @if (count($usuarios) > 0)
            @foreach ($usuarios as $row)
                @php
                    $aclUser = $acl::where('nick', '=', $row->nick)->get();
                @endphp
                <tr>
                    <td>{{ $row->nick }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row::rol($row->nick) }}</td>
                    <td>{{ $row->borrado == true ? 'Si' : 'No' }}</td>
                    <td>
                        <form method="post" action="{{ route('borrarUsuario', ['usuario' => $row]) }}">
                            <a href="{{ route('verUsuario', ['usuario' => $row]) }}" class="btn btn-primary btn-sm">Ver / Modificar</a>
                            @csrf
                            @if (Auth::user()->puedePermiso('administrador'))
                                @if ($row->borrado)
                                    <input type="submit" class="btn btn-success btn-sm recuperar" value="Recuperar"
                                        id="{{ $row->cod_usuario }}" />
                                @else
                                    <input type="submit" class="btn btn-danger btn-sm borrar" value="Borrar"
                                        id="{{ $row->cod_usuario }}" />
                                @endif
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">No hay disponibles registros</td>
            </tr>
        @endif
    </table>
    {!! $usuarios->appends(Request::except('page'))->render() !!}
@endsection
