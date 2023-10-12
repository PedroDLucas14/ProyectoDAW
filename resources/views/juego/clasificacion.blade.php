@extends('layouts.plantilla')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/juego.css') }}">
    <style>
        main {
            background: url({{ asset('img/fondo.jpg') }});

        }

        main {
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            margin-bottom: 0;
        }
    </style>
@endsection
@section('mainMenu')
    <li><a href="{{ route('sobreNosotros') }}"> StarWars Hunters</a></li>
    <li><a href="{{ route('jugar') }}">Jugar</a></li>
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
    <div class="container pt-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-md-12"><b>
                            <h2 class="text-center">Clasificación</h2>
                        </b></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive d-flex flex-column justify-content-center">
                    <table class="table table-bordered table-hover " id="tb-clasificacion">
                        <thead>
                            <tr>
                                <th>Division</th>
                                <th>Nick</th>
                                <th>Victorias</th>
                                <th>Derrotas</th>
                                <th>Puntos</th>
                            </tr>
                        </thead>

                        @if (count($usuarios) > 0)
                            @foreach ($usuarios as $row)
                                <tr>
                                    <td><img src="{{ asset('' . $divisiones::where('cod_division', '=', $row->cod_division)->value('imagen')) }}"
                                            alt="image-division"></td>
                                    <td>{{ $row->nick }}</td>
                                    <td>{{ $row->victorias }}</td>
                                    <td>{{ $row->derrotas }}</td>
                                    <td>{{ $row->puntos }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No hay registros disponibles</td>
                            </tr>
                        @endif
                    </table>
                    {!! $usuarios->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
