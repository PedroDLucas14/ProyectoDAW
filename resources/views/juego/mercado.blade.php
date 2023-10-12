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
    <script src="{{ asset('js/mercado.js') }}" defer></script>
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
                    <form class="row g-1" action="{{ route('mercado.ver') }}" method="post">
                        @csrf
                        <input type="text" hidden value="naves" name="cat">
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="inputNombre" name="nombre"
                                    value="{{ old('nombre') }}" placeholder="Nombre">
                                <label for="inputCreditos">Nombre</label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control" id="inputCreditos"
                                    name="valorTotal" placeholder="Créditos">
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
                                <input type="number" min="0" class="form-control" id="inputResistencia"
                                    name="resistencia" placeholder="Resistencia">
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
                                <input type="number" min="0" class="form-control" id="inputDefensa"
                                    name="defensa" placeholder="Defensa">
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
                                <input type="submit" class="btn btn-starwars" value="Filtrar">
                                <input type="reset" class="btn btn-starwars" value="Limpiar">
                            </div>
                        </div>
                    </form>
                    <!-- Contenido de la pestaña de naves -->
                    {{ $naves->fragment('naves')->links() }}
                    <div class="row">
                        @if (count($naves) > 0)
                            @foreach ($naves as $nave)
                                <div class="col-md-6">
                                    <div class="card p-2">
                                        <img src="{{ $nave->imagen }}" class="card-img-top"
                                            alt="{{ 'img-' . $nave->nombre }}">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $nave->nombre }}</h6>
                                            <h6>Precio: {{ $nave->valor }} Créditos</h6>
                                            <h6><i class="bi bi-heart-fill"></i> Resistencia:{{ $nave->resistencia }}
                                            </h6>
                                            <h6><i class="fa-solid fa-gun"></i> Ataque:{{ $nave->ataque }}</h6>
                                            <h6><i class="fa-solid fa-shield-halved"></i>
                                                </i> Defensa:{{ $nave->defensa }}</h6>
                                            <button class="btn btn-starwars mt-3" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#detallesNave{{ $nave->cod_nave }}" aria-expanded="false"
                                                aria-controls="detallesNave{{ $nave->cod_nave }}">
                                                Ver detalles
                                            </button>
                                            <a class="btn btn-starwars mt-3 btn-compras-naves"
                                                href="{{ route('comprar.nave', $nave) }}" id="comprarNaves"
                                                role="button">Comprar</a>
                                            <div class="collapse" id="detallesNave{{ $nave->cod_nave }}">
                                                <div class="card card-body text-center mt-2">
                                                    <p>
                                                        Coste nivel:{{ $nave->coste_nivel }} creditos <br>
                                                        Nº Accesorios: {{ $nave->num_accesorios }}<br
                                                        Aumento por nivel resistencia:{{ $nave->aumento_resistencia }}<br>
                                                        Aumento por nivel ataque:{{ $nave->aumento_ataque }} <br>
                                                        Aumento por nivel defensa:{{ $nave->aumento_defensa }} <br>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3>No hay naves disponibles</h3>
                        @endif

                    </div>
                    {{ $naves->fragment('naves')->links() }}
                </div>
                <div class="tab-pane fade @if ($link == 'pilotos') show active @endif" id="pilotos">
                    <form class="row g-1" action="{{ route('mercado.ver') }}" method="post">
                        @csrf
                        <input type="text" hidden value="pilotos" name="cat">
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="inputNombre" name="nombre"
                                    placeholder="Nombre">
                                <label for="inputCreditos">Nombre</label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control" id="inputCreditos"
                                    name="valorTotal" placeholder="Créditos">
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
                                <input type="number" min="0" class="form-control" id="inputResistencia"
                                    name="resistencia" placeholder="Resistencia">
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
                                <input type="number" min="0" class="form-control" id="inputAtaque"
                                    name="ataque" placeholder="Ataque">
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
                                <input type="number" min="0" class="form-control" id="inputDefensa"
                                    name="defensa" placeholder="Defensa">
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
                                <input type="submit" class="btn btn-starwars" value="Filtrar">
                                <input type="reset" class="btn btn-starwars" value="Limpiar">
                            </div>
                        </div>
                    </form>
                    <!-- Contenido de la pestaña de pilotos -->
                    {{ $pilotos->fragment('pilotos')->links() }}
                    <div class="row">
                        @if (count($pilotos))
                            @foreach ($pilotos as $piloto)
                                <div class="col-md-6">
                                    <div class="card p-2">
                                        <img src="{{ $piloto->imagen }}" class="card-img-top"
                                            alt="{{ 'img-' . $piloto->nombre }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $piloto->nombre }}</h5>
                                            <h6>Precio: {{ $piloto->valor }} Créditos</h6>
                                            <h6><i class="bi bi-heart-fill"></i> Resistencia:{{ $piloto->resistencia }}
                                            </h6>
                                            <h6><i class="fa-solid fa-gun"></i> Ataque:{{ $piloto->ataque }}</h6>
                                            <h6><i class="fa-solid fa-shield-halved"></i>
                                                </i> Defensa:{{ $piloto->defensa }}</h6>
                                            <h6><i class="fa-solid fa-book-open"></i> Habilidad:
                                                {{ $piloto->dameHabilidad('nombre') }}</h6>
                                            <button class="btn btn-starwars mt-3" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#detallespiloto{{ $piloto->cod_piloto }}"
                                                aria-expanded="false"
                                                aria-controls="detallespiloto{{ $piloto->cod_piloto }}">
                                                Ver detalles
                                            </button>
                                            <a class="btn btn-starwars mt-3 btn-compras-piloto"
                                                href="{{ route('comprar.piloto', $piloto) }}" role="button">Comprar</a>
                                            <div class="collapse" id="detallespiloto{{ $piloto->cod_piloto }}">
                                                <div class="card card-body text-center mt-2">
                                                    <p>
                                                        Habilidad: {{ $piloto->dameHabilidad('descripcion') }}<br>
                                                        Coste nivel:{{ $piloto->coste_nivel }} creditos <br>
                                                        Aumento por nivel
                                                        resistencia:{{ $piloto->aumento_resistencia }}<br>
                                                        Aumento por nivel ataque:{{ $piloto->aumento_ataque }} <br>
                                                        Aumento por nivel defensa:{{ $piloto->aumento_defensa }} <br>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3>No hay pilotos disponibles</h3>
                        @endif

                    </div>
                    {{ $pilotos->fragment('pilotos')->links() }}
                </div>
                <div class="tab-pane fade @if ($link == 'accesorios') show active @endif" id="accesorios">
                    <form class="row g-1" action="{{ route('mercado.ver') }}" method="post">
                        @csrf
                        <input type="text" hidden value="accesorios" name="cat">
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="inputNombre" name="nombre"
                                    placeholder="Nombre">
                                <label for="inputCreditos">Nombre</label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-auto">
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control" id="inputCreditos"
                                    name="valorTotal" placeholder="Créditos">
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
                                <input type="number" min="0" class="form-control" id="inputResistencia"
                                    name="resistencia" placeholder="Resistencia">
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
                                <input type="number" min="0" class="form-control" id="inputAtaque"
                                    name="ataque" placeholder="Ataque">
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
                                <input type="number" min="0" class="form-control" id="inputDefensa"
                                    name="defensa" placeholder="Defensa">
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
                                <input type="submit" class="btn btn-starwars" value="Filtrar">
                                <input type="reset" class="btn btn-starwars" value="Limpiar">
                            </div>
                        </div>
                    </form>
                    <!-- Contenido de la pestaña de accesorios -->
                    {{ $accesorios->fragment('accesorios')->links() }}
                    <div class="row">
                        @if (count($accesorios) > 0)
                            @foreach ($accesorios as $accesorio)
                                <div class="col-md-6">
                                    <div class="card p-2">
                                        <img src="{{ $accesorio->imagen }}"
                                            class="card-img-top"alt="{{ 'img-' . $accesorio->nombre }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $accesorio->nombre }}</h5>
                                            <h6>Precio: {{ $accesorio->valor }} Créditos</h6>
                                            <h6><i class="bi bi-heart-fill"></i> Resistencia:{{ $accesorio->resistencia }}
                                            </h6>
                                            <h6><i class="fa-solid fa-gun"></i> Ataque:{{ $accesorio->ataque }}</h6>
                                            <h6><i class="fa-solid fa-shield-halved"></i>
                                                </i> Defensa:{{ $accesorio->defensa }}</h6>
                                            <button class="btn btn-starwars mt-3" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#detallespiloto{{ $accesorio->cod_accesorio }}"
                                                aria-expanded="false"
                                                aria-controls="detallespiloto{{ $accesorio->cod_accesorio }}">
                                                Ver detalles
                                            </button>
                                            <a class="btn btn-starwars mt-3 btn-compras-acc"
                                                href="{{ route('comprar.accesorio', $accesorio) }}"
                                                role="button">Comprar</a>
                                            <div class="collapse" id="detallespiloto{{ $accesorio->cod_accesorio }}">
                                                <div class="card card-body text-center mt-2">
                                                    <p>
                                                        Coste nivel:{{ $accesorio->coste_nivel }} creditos <br>
                                                        Aumento por nivel
                                                        resistencia:{{ $accesorio->aumento_resistencia }}<br>
                                                        Aumento por nivel ataque:{{ $accesorio->aumento_ataque }} <br>
                                                        Aumento por nivel defensa:{{ $accesorio->aumento_defensa }} <br>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3>No hay accesorios disponibles</h3>
                        @endif
                    </div>
                    {{ $accesorios->fragment('accesorios')->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
