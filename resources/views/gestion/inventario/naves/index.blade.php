@extends('layouts.gestions')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection
@section('jsExtra')
    <script src="{{ asset('js/gestion.js') }}" type="module"></script>
@endsection

@section('titulo-pagina')
    <div class="col col-md-6"><b>Lista de naves del jugador {{ $usuario->nick }}</b></div>
@endsection
@section('titulo-tabla')
    <i class="fa-solid fa-rocket"></i> Lista de naves del jugador {{ $usuario->nick }}
@endsection

@section('contenido-tabla')
    <a class="btn btn-success btn-sm float-end mb-3" href="{{ route('gestionInventarios') }}"> Volver</a>
    {{-- <a href="{{ route('añadirUsuarioNave', ['usuario' => $usuario]) }}" class="btn btn-success btn-sm float-end">Añadir</a> --}}
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nombre Nave</th>
                <th>Nivel</th>
                <th>Acciones</th>
            </tr>
        </thead>
        @if (count($naves) > 0)
            @foreach ($naves as $row)
                <tr>
                    <td>{{ $row->nave->nombre }}</td>
                    <td>{{ $row->nivel }}</td>
                    <td>
                        <a href="{{ route('verUsuarioNave', ['usuario' => $usuario, 'usuariosNave' => $row]) }}"
                            class="btn btn-primary btn-sm">Ver</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">No hay disponibles registros</td>
            </tr>
        @endif
    </table>
    {!! $naves->links() !!}
@endsection
