@extends('layouts.plantilla')
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/mercado.css') }}">
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
@section('jsExtra')
    <script src="{{ asset('js/inventario.js') }}" defer></script>
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
@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/mercado.css') }}">
@endsection
@section('content')
    <div class="container">
        <div id="contenedor-creditos">
            <label id="creditos"> Tus créditos: {{ $usuario->creditos }} <i class="fa-solid fa-sack-dollar"></i></label>
        </div>
        <div class="tabs mercado">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item">
                    <a class="nav-link @if ($link == 'naves') show active @endif" id="nav-naves-tab"
                        data-toggle="tab" href="#naves">Naves</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($link == 'pilotos') show active @endif" id="nav-pilotos-tab "
                        data-toggle="tab" href="#pilotos">Pilotos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($link == 'accesorios') show active @endif" id="nav-accesorios-tab"
                        data-toggle="tab" href="#accesorios">Accesorios</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade @if ($link == 'naves') show active @endif" id="naves">
                    <form class="row g-1" action="{{ route('perfil.inventario') }}" method="post">
                        @csrf
                        <input type="text" hidden value="naves" name="cat">
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control" id="inputNivel" name="nivel"
                                    placeholder="Nivel">
                                <label for="inputNivel">Nivel</label>
                            </div>
                            <select name="operadorNivel" class="form-control" id="">
                                <option value="=" selected>=</option>
                                <option value="<">></option>
                                <option value=">">
                                    &lt; </option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control" id="inputResistencia"
                                    name="resistencia_actual" placeholder="Resistencia">
                                <label for="inputResistencia">Resistencia</label>
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
                                <input type="number" min="0" class="form-control" id="inputAtaque"
                                    name="ataque_actual" placeholder="Ataque">
                                <label for="inputAtaque">Ataque</label>
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
                                <input type="number" min="0" class="form-control" id="inputDefensa"
                                    name="defensa_actual" placeholder="Defensa">
                                <label for="inputDefensa">Defensa</label>
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
                                <input type="submit" class="btn btn-starwars" value="Filtrar">
                                <input type="reset" class="btn btn-starwars" value="Limpiar">
                            </div>
                        </div>
                    </form>
                    <!-- Contenido de la pestaña de naves -->
                    {{ $naves->fragment('naves')->links() }}
                    <div class="row">
                        @foreach ($naves as $nave)
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="{{ asset($nave->imagen) }}" class="card-img-top mt-3"
                                        alt="{{ 'img-' . $nave->nombre }}">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $nave->nombre }}</h6>
                                        <h6>Nivel: {{ intval($nave->pivot->nivel) }}</h6>
                                        <h6><i class="bi bi-heart-fill"></i>
                                            Resistencia:{{ $nave->pivot->resistencia_actual }}
                                        </h6>
                                        <h6><i class="fa-solid fa-gun"></i> Ataque:{{ $nave->pivot->ataque_actual }}</h6>
                                        <h6><i class="fa-solid fa-shield-halved"></i>
                                            </i> Defensa:{{ $nave->pivot->defensa_actual }}</h6>
                                        <button class="btn btn-starwars mt-3 mb-3" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#detallesNave{{ $nave->pivot->cod_usuario_nave }}"
                                            aria-expanded="false"
                                            aria-controls="detallesNave{{ $nave->pivot->cod_usuario_nave }}">
                                            Ver detalles
                                        </button>
                                        <div class="collapse" id="detallesNave{{ $nave->pivot->cod_usuario_nave }}">
                                            <div class="card card-body text-center mt-2 pb-2">
                                                <p>
                                                    Nº accesorios: {{ $nave->num_accesorios }}
                                                    Aumento por nivel resistencia:{{ $nave->aumento_resistencia }}<br>
                                                    Aumento por nivel ataque:{{ $nave->aumento_ataque }} <br>
                                                    Aumento por nivel defensa:{{ $nave->aumento_defensa }} <br>
                                                </p>
                                            </div>
                                        </div>
                                        <br>
                                        <!--SUbida de nivel-->
                                        <button type="button" class="btn btn-default menos-nave"
                                            id={{ '-' . $nave->pivot->cod_usuario_nave }}>
                                            <span class="fa-solid fa-circle-minus fa-xl"></span>
                                        </button>
                                        <input type="number" min="1"
                                            id="{{ 'NaveNivel' . $nave->pivot->cod_usuario_nave }}"
                                            style="width: 100px;text-align: right" value="1" disabled>
                                        <button type="button" class="btn btn-default mas-nave"
                                            id={{ '+' . $nave->pivot->cod_usuario_nave }}>
                                            <span class="fa-solid fa-circle-plus fa-xl"></span>
                                        </button>
                                        <br>
                                        <label for="costeNave">Resumen subida:</label>
                                        <p id="{{ 'costeNave' . $nave->pivot->cod_usuario_nave }}">
                                            Coste total de la mejora {{ $nave->coste_nivel }} creditos<br>
                                            Nueva resistencia:
                                            {{ $nave->pivot->resistencia_actual + $nave->aumento_resistencia }} puntos <br>
                                            Nuevo ataque: {{ $nave->pivot->ataque_actual + $nave->aumento_ataque }} puntos
                                            <br>
                                            Nueva defensa: {{ $nave->pivot->defensa_actual + $nave->aumento_defensa }}
                                            puntos <br>
                                        </p>
                                        <a class="btn btn-starwars mt-3 btn-subiNivelNave"
                                            href="{{ route('subirNivel', $nave) }}"
                                            id="{{ 'NaveSubida' . $nave->pivot->cod_usuario_nave }}" role="button">Subir
                                            Niveles</a>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $naves->fragment('naves')->links() }}
                </div>
                <div class="tab-pane fade @if ($link == 'pilotos') show active @endif" id="pilotos">
                    <form class="row g-1" action="{{ route('perfil.inventario') }}" method="post">
                        @csrf
                        <input type="text" hidden value="pilotos" name="cat">
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control" id="inputNivel"
                                    name="nivel" placeholder="Nivel">
                                <label for="inputNivel">Nivel</label>
                            </div>
                            <select name="operadorNivel" class="form-control" id="">
                                <option value="=" selected>=</option>
                                <option value="<">></option>
                                <option value=">">
                                    &lt; </option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control" id="inputResistencia"
                                    name="resistencia_actual" placeholder="Resistencia">
                                <label for="inputResistencia">Resistencia</label>
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
                                <input type="number" min="0" class="form-control" id="inputAtaque"
                                    name="ataque_actual" placeholder="Ataque">
                                <label for="inputAtaque">Ataque</label>
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
                                <input type="number" min="0" class="form-control" id="inputDefensa"
                                    name="defensa_actual" placeholder="Defensa">
                                <label for="inputDefensa">Defensa</label>
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
                                <input type="submit" class="btn btn-starwars" value="Filtrar">
                                <input type="reset" class="btn btn-starwars" value="Limpiar">
                            </div>
                        </div>
                    </form>
                    <!-- Contenido de la pestaña de pilotos -->
                    {{ $pilotos->fragment('pilotos')->links() }}
                    <div class="row">
                        @foreach ($pilotos as $piloto)
                            {{-- @dd($piloto) --}}
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="{{ asset($piloto->imagen) }}" class="card-img-top mt-3"
                                        alt="{{ 'img-' . $piloto->nombre }}">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $piloto->nombre }}</h6>
                                        <h6>Nivel: {{ intval($piloto->pivot->nivel) }}</h6>
                                        <h6><i class="bi bi-heart-fill"></i>
                                            Resistencia:{{ $piloto->pivot->resistencia_actual }}
                                        </h6>
                                        <h6><i class="fa-solid fa-gun"></i> Ataque:{{ $piloto->pivot->ataque_actual }}
                                        </h6>
                                        <h6><i class="fa-solid fa-shield-halved"></i>
                                            </i> Defensa:{{ $piloto->pivot->defensa_actual }}</h6>
                                        <button class="btn btn-starwars mt-3 mb-3" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#detallesPiloto{{ $piloto->pivot->cod_usuario_piloto }}"
                                            aria-expanded="false"
                                            aria-controls="detallesPiloto{{ $piloto->pivot->cod_usuario_piloto }}">
                                            Ver detalles
                                        </button>
                                        <div class="collapse"
                                            id="detallesPiloto{{ $piloto->pivot->cod_usuario_piloto }}">
                                            <div class="card card-body text-center mt-2 pb-2">
                                                <p>
                                                    Aumento por nivel resistencia:{{ $piloto->aumento_resistencia }}<br>
                                                    Aumento por nivel ataque:{{ $piloto->aumento_ataque }} <br>
                                                    Aumento por nivel defensa:{{ $piloto->aumento_defensa }} <br>
                                                </p>
                                            </div>
                                        </div>
                                        <br>
                                        <!--SUbida de nivel-->
                                        <button type="button" class="btn btn-default menos-piloto"
                                            id={{ '-' . $piloto->pivot->cod_usuario_piloto }}>
                                            <span class="fa-solid fa-circle-minus fa-xl"></span>
                                        </button>
                                        <input type="number" min="1"
                                            id="{{ 'PilotoNivel' . $piloto->pivot->cod_usuario_piloto }}"
                                            style="width: 100px;text-align: right" value="1" disabled>
                                        <button type="button" class="btn btn-default mas-piloto"
                                            id={{ '+' . $piloto->pivot->cod_usuario_piloto }}>
                                            <span class="fa-solid fa-circle-plus fa-xl"></span>
                                        </button>
                                        <br>
                                        <label for="costePiloto">Resumen subida:</label>
                                        <p id="{{ 'costePiloto' . $piloto->pivot->cod_usuario_piloto }}">
                                            Coste total de la mejora {{ $piloto->coste_nivel }} creditos<br>
                                            Nueva resistencia:
                                            {{ $piloto->pivot->resistencia_actual + $piloto->aumento_resistencia }} puntos
                                            <br>
                                            Nuevo ataque: {{ $piloto->pivot->ataque_actual + $piloto->aumento_ataque }}
                                            puntos
                                            <br>
                                            Nueva defensa: {{ $piloto->pivot->defensa_actual + $piloto->aumento_defensa }}
                                            puntos <br>
                                        </p>
                                        <a class="btn btn-starwars mt-3 btn-subiNivelPiloto"
                                            href="{{ route('subirNivel', $piloto) }}"
                                            id="{{ 'PilotoSubida' . $piloto->pivot->cod_usuario_piloto }}"
                                            role="button">Subir
                                            Niveles</a>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $pilotos->fragment('pilotos')->links() }}
                </div>
                <div class="tab-pane fade @if ($link == 'accesorios') show active @endif" id="accesorios">
                    <form class="row g-1" action="{{ route('perfil.inventario') }}" method="post">
                        @csrf
                        <input type="text" hidden value="accesorios" name="cat">
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control" id="inputNivel"
                                    name="nivel" placeholder="Nivel">
                                <label for="inputNivel">Nivel</label>
                            </div>
                            <select name="operadorNivel" class="form-control" id="">
                                <option value="=" selected>=</option>
                                <option value="<">></option>
                                <option value=">">
                                    &lt; </option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control" id="inputResistencia"
                                    name="resistencia_actual" placeholder="Resistencia">
                                <label for="inputResistencia">Resistencia</label>
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
                                <input type="number" min="0" class="form-control" id="inputAtaque"
                                    name="ataque_actual" placeholder="Ataque">
                                <label for="inputAtaque">Ataque</label>
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
                                <input type="number" min="0" class="form-control" id="inputDefensa"
                                    name="defensa_actual" placeholder="Defensa">
                                <label for="inputDefensa">Defensa</label>
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
                                <input type="submit" class="btn btn-starwars" value="Filtrar">
                                <input type="reset" class="btn btn-starwars" value="Limpiar">
                            </div>
                        </div>
                    </form>
                    <!-- Contenido de la pestaña de accesorios -->
                    {{ $accesorios->fragment('accesorios')->links() }}
                    <div class="row">
                        @foreach ($accesorios as $accesorio)
                            {{-- @dd($piloto) --}}
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="{{ asset($accesorio->imagen) }}" class="card-img-top mt-3"
                                        alt="{{ 'img-' . $accesorio->nombre }}">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $accesorio->nombre }}</h6>
                                        <h6>Nivel: {{ intval($accesorio->pivot->nivel) }}</h6>
                                        <h6><i class="bi bi-heart-fill"></i>
                                            Resistencia:{{ $accesorio->pivot->resistencia_actual == null ? '-' : $accesorio->pivot->resistencia_actual }}
                                        </h6>
                                        <h6><i class="fa-solid fa-gun"></i>
                                            Ataque:{{ $accesorio->pivot->ataque_actual == null ? '-' : $accesorio->pivot->ataque_actual }}
                                        </h6>
                                        <h6><i class="fa-solid fa-shield-halved"></i>
                                            </i>
                                            Defensa:{{ $accesorio->pivot->defensa_actual == null ? '-' : $accesorio->pivot->defensa_actual }}
                                        </h6>
                                        <button class="btn btn-starwars mt-3 mb-3" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#detallesAccesorio{{ $accesorio->pivot->cod_usuario_accesorio }}"
                                            aria-expanded="false"
                                            aria-controls="detallesAccesorio{{ $accesorio->pivot->cod_usuario_accesorio }}">
                                            Ver detalles
                                        </button>
                                        <div class="collapse"
                                            id="detallesAccesorio{{ $accesorio->pivot->cod_usuario_accesorio }}">
                                            <div class="card card-body text-center mt-2 pb-2">
                                                <p>
                                                    @if ($accesorio->aumento_defensa != null)
                                                        Aumento por nivel
                                                        resistencia:{{ $accesorio->aumento_resistencia }}<br>
                                                    @endif
                                                    @if ($accesorio->aumento_ataque != null)
                                                        Aumento por nivel ataque:{{ $accesorio->aumento_ataque }} <br>
                                                    @endif
                                                    @if ($accesorio->aumento_defensa != null)
                                                        Aumento por nivel defensa:{{ $accesorio->aumento_defensa }} <br>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <br>
                                        <!--SUbida de nivel-->
                                        <button type="button" class="btn btn-default menos-accesorio"
                                            id={{ '-' . $accesorio->pivot->cod_usuario_accesorio }}>
                                            <span class="fa-solid fa-circle-minus fa-xl"></span>
                                        </button>
                                        <input type="number" min="1"
                                            id="{{ 'AccesorioNivel' . $accesorio->pivot->cod_usuario_accesorio }}"
                                            style="width: 100px;text-align: right" value="1" disabled>
                                        <button type="button" class="btn btn-default mas-accesorio"
                                            id={{ '+' . $accesorio->pivot->cod_usuario_accesorio }}>
                                            <span class="fa-solid fa-circle-plus fa-xl"></span>
                                        </button>
                                        <br>
                                        <label for="costeAccesorio">Resumen subida:</label>
                                        <p id="{{ 'costeAccesorio' . $accesorio->pivot->cod_usuario_accesorio }}">
                                            Coste total de la mejora {{ $accesorio->coste_nivel }} creditos<br>
                                            @if ($accesorio->pivot->resistencia_actual != null)
                                                Nueva resistencia:
                                                {{ $accesorio->pivot->resistencia_actual + $accesorio->aumento_resistencia }}
                                                puntos
                                                <br>
                                            @endif
                                            @if ($accesorio->pivot->ataque_actual != null)
                                                Nuevo ataque:
                                                {{ $accesorio->pivot->ataque_actual + $accesorio->aumento_ataque }}
                                                puntos
                                                <br>
                                            @endif
                                            @if ($accesorio->pivot->defensa_actual != null)
                                                Nueva defensa:
                                                {{ $accesorio->pivot->defensa_actual + $accesorio->aumento_defensa }}
                                                puntos <br>
                                            @endif
                                        </p>
                                        <a class="btn btn-starwars mt-3 btn-subiNivelAccesorio"
                                            href="{{ route('subirNivel', $accesorio) }}"
                                            id="{{ 'AccesorioSubida' . $accesorio->pivot->cod_usuario_accesorio }}"
                                            role="button">Subir
                                            Niveles</a>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $accesorios->fragment('accesorios')->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
