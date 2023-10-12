@extends('layouts.plantilla')

@section('title', 'Star Wars Hunters')

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
    <section class="hero-section">
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="img/slider-1.jpg">
                <div class="hs-text">
                    <div class="container">
                        <h2>Star wars <span>Hunters</span></h2>
                        <p> Star wars hunters es un juego de estrategia y gestión de recursos que pone a prueba la habilidad
                            del jugador
                            contra otros jugadores para alzarse con la victoria y convertise en el mejor estratega de la
                            galaxia.
                            .</p>
                    </div>
                </div>
            </div>
            <div class="hs-item set-bg" data-setbg="img/slider-2.jpg">
                <div class="hs-text">
                    <div class="container">
                        <h2>Star wars <span>Hunters</span></h2>
                        <p> Star wars hunters es un juego de estrategia y gestión de recursos que pone a prueba la habilidad
                            del jugador
                            contra otros jugadores para alzarse con la victoria y convertise en el mejor estratega de la
                            galaxia.
                            .</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contendor-cartas pb-4">
        <h3 class="mb-4 mt-4">Lucha junto a tus herores favoritos de la saga contra otros jugadores </h3>
        <div class="cartas-main pr-3 pl-3">
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('img/darth-vader.jpg') }}" class="card-img-top" alt="img_vader">
                <div class="card-body">
                    <h6>Darth Vader</h6>
                    <p class="card-text"> El icónico villano de Star Wars. Antes conocido como Anakin Skywalker, fue
                        seducido por el lado oscuro de la Fuerza. Es un poderoso lord sith con una armadura negra y una
                        respiración distintiva.
                    </p>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('img/obi.jpg') }}" class="card-img-top" alt="img_obi_wan">
                <div class="card-body">
                    <h6>Obi-Wan Kenobi</h6>
                    <p class="card-text">
                        Un venerado maestro jedi y defensor de la paz. Es sabio, valiente y posee un profundo conocimiento
                        de la Fuerza. Obi-Wan es reconocido por su habilidad en el combate con sable de luz y por su papel
                        en la formación de Anakin Skywalker.
                    </p>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('img/Chewbacca.jpg') }} " class="card-img-top" alt="img_chewbacca">
                <div class="card-body">
                    <h6>Chewbacca</h6>
                    <p class="card-text">
                        Un leal wookiee y copiloto del Halcón Milenario. Es un ser peludo y robusto de gran fuerza física.
                        Aunque su voz es gutural, es un gran amigo y compañero de Han Solo. Chewbacca es conocido por su
                        habilidad como mecánico y su destreza en el combate, así como por su inconfundible rugido wookiee.
                    </p>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('img/han.jpg') }}" class="card-img-top" alt="img_han_solo">
                <div class="card-body">
                    <h6>Han Solo</h6>
                    <p class="card-text">Un contrabandista y piloto espacial muy habilidoso. Es conocido por su ingenio, su
                        lealtad y su famosa nave, el Halcón Milenario. Han Solo se une a la Alianza Rebelde y se convierte
                        en un héroe galáctico.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
