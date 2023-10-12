@extends('layouts.gestions')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/gestion.css') }}">
@endsection
@section('jsExtra')
    <script src="{{ asset('js/gestion.js') }}" type="module"></script>
@endsection

@section('titulo-pagina')
    <div class="col col-md-6"><b>Lista de pilotos del jugador {{ $usuario->nick }}</b></div>
@endsection

@section('titulo-tabla')
    <i class="fa-solid fa-person-rifle"></i> Lista de pilotos del jugador {{ $usuario->nick }}
@endsection
@section('contenido-tabla')
    <a class="btn btn-success btn-sm float-end ml-1 mb-3" href="{{ route('gestionInventarios') }}"> Volver</a>
    {{-- <a href="{{ route('añadirUsuarioPilto', ['usuario' => $usuario]) }}"
        class="btn btn-success btn-sm float-end mb-3">Añadir</a> --}}
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nombre Piloto</th>
                <th>Nivel</th>
                <th>Acciones</th>
            </tr>
        </thead>

        @if (count($pilotos) > 0)
            @foreach ($pilotos as $row)
                <tr>
                    <td>{{ $row->piloto->nombre }}</td>
                    <td>{{ $row->nivel }}</td>
                    <td>
                        <a href="{{ route('verUsuarioPiloto', ['usuario' => $usuario, 'usuarioPiloto' => $row]) }}"
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
    {!! $pilotos->links() !!}
@endsection
