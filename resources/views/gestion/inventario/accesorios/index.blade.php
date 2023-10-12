@extends('layouts.gestions')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection
@section('jsExtra')
    <script src="{{ asset('js/gestion.js') }}" type="module"></script>
@endsection

@section('titulo-pagina')
    <div class="col col-md-6"><b>Lista de accesorios del jugador {{ $usuario->nick }}</b></div>
@endsection
@section('titulo-tabla')
    <div class="col col-md-6"> <i class="fa-solid fa-screwdriver-wrench"></i> <b>Lista de accesorios del jugador
            {{ $usuario->nick }}</b></div>
@endsection
@section('contenido-tabla')
    <a class="btn btn-success btn-sm float-end mb-3" href="{{ route('gestionInventarios') }}"> Volver</a>
    {{-- <a href="{{ route('añadirAccUsuario', ['usuario' => $usuario]) }}" class="btn btn-success btn-sm float-end">Añadir</a> --}}
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nombre Accesorio</th>
                <th>Nivel</th>
                <th>Acciones</th>
            </tr>
        </thead>

        @if (count($accesorios) > 0)
            @foreach ($accesorios as $row)
                <tr>
                    <td>{{ $row->accesorio->nombre }}</td>
                    <td>{{ $row->nivel }}</td>
                    <td>
                        <a href="{{ route('verAccUsuario', ['usuario' => $usuario, 'usuarioAccesorio' => $row]) }}"
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
    {!! $accesorios->links() !!}
@endsection
