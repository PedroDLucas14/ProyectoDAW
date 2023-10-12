<?php

namespace App\Http\Controllers;

use App\Models\AccesorioRegistroBatalla;
use App\Models\Batalla;
use App\Models\Divisiones;
use App\Models\LogBatalla;
use App\Models\RegistroBatalla;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Controlador que gestiona todas las acciones 
 * relacionadas con el juego y sus mecanicas
 */

class JuegoController extends Controller
{

    //Variables por defecto de los puntos ganados, perdidos y creditos ganados por partida 
    protected $puntosGanados = 100;
    protected $puntosPerdida = 50;
    protected $creditosGanados = 1000;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth')->except('verClasificacion');
    }

    /**
     * Muetra una lista de posibles rivales para el
     * usuario registrado.
     * Se muestra una lista de 3 jugadores del rango de puntos del jugador
     * entre 200 puntos debajo y 200 puntos por arriba
     */
    public function lista()
    {
        try {
            $usuario = Usuario::where('nick', '=', Auth::user()->nick)->select('cod_usuario', 'puntos')->get()->toArray();
            $rivales = Usuario::where('cod_usuario', '<>', $usuario[0]['cod_usuario'])
                ->where('borrado', '=', false)
                ->whereBetween('puntos', [($usuario[0]['puntos'] - 400), ($usuario[0]['puntos'] + 400)])
                ->inRandomOrder()
                ->orderBy('puntos', 'desc')
                ->take(3)
                ->get();
            return View('juego.lista', compact('rivales'));
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }

    /**
     * Acción para recargar la lista de rivales que puede ver el usuario
     * conectado.
     * @return array con los nuevos jugadores a mostrar
     */
    public function recargar(): array
    {
        $respuesta = [];
        try {
            $usuario = Usuario::where('nick', '=', Auth::user()->nick)->select('cod_usuario', 'puntos')->get()->toArray();
            $rivales = Usuario::where('cod_usuario', '<>', $usuario[0]['cod_usuario'])
                ->where('borrado', '=', false)
                ->whereBetween('puntos', [($usuario[0]['puntos'] - 300), ($usuario[0]['puntos'] + 300)])
                ->inRandomOrder()
                ->take(3)
                ->get();
            $cont = 0;
            foreach ($rivales as $rival) {
                $respuesta[$cont]["cod_usuario"] = $rival->cod_usuario;
                $respuesta[$cont]["nick"] = $rival->nick;
                $respuesta[$cont]["puntos"] = $rival->puntos;
                $respuesta[$cont]["division"] = url($rival->division->imagen);
                $cont++;
            }
            array_multisort(array_column($respuesta, 'puntos'), SORT_DESC, $respuesta);
            return compact('respuesta');
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }

    /**
     * Acción encarga de creear un partida con los datos que le llegan del cliente
     * @param Request $request objetoc con la informacion del jugador rival elegido por el usuario
     *
     * Deveulve como respuesta los datos necesarios para el siguiente paso
     */
    public function crearPartida(Request $request)
    {
        try {
            $datosBatalla = json_decode($request->getContent(), true);
            $datosBatalla["rival"] = intval($datosBatalla["rival"]);
            $datosBatalla["jugador"] = [];
            $codJugador = Usuario::where('nick', '=', Auth::user()->nick)->select('cod_usuario')->get()->value('cod_usuario');

            //obtener datos del jugador activo
            $datosBatalla["jugador"]["cod_usuario"] = $codJugador;
            $jugador = Usuario::find($codJugador);
            $datosBatalla["jugador"]['pilotos'] = $jugador->pilotos;
            $datosBatalla["jugador"]['naves'] = $jugador->naves;
            $datosBatalla["jugador"]['accesorios'] = $jugador->accesorios;

            return response()->json($datosBatalla);
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }

    /**
     * Acción que da comien<o a la batalla del jugador activo
     * Con los datos que llegan se crea el registro de la batalla en la BD(batallas),
     * se guarda los dos el registro_batalla para cada uno de los jugadores de esa batalla(registro_batalla)
     * Se insertan los accesorios para esa batalla en la tabla accesorios_registro_batalla
     * y ademas se hace la eleccion para la máquina(jugador rival)
     *
     * Si todo va bien se devuelve los datos en formato json con los datos inciales para la batalla
     * para poder tratarlos en el cliente
     *
     * @param Request $request Información requerida para poner en marcha el juego
     *                El rival, la eleccion de objetos por parte del usuario
     *
     */
    public function iniciarBatalla(Request $request)
    {
        $errores = [];
        $datosBatalla = json_decode($request->getContent(), true);
        $datosDevuelta = [];

        try {
            $codJugador = Usuario::where('nick', '=', Auth::user()->nick)->select('cod_usuario')->get()->value('cod_usuario');
            $datosDevuelta["codUsuario"] = $codJugador;
            $datosDevuelta["rival"] = $datosBatalla["rival"];
            if (!$this->comprobarPiloto($codJugador, $datosBatalla["datosJugador"]["piloto"])) {
                $errores[]["Piloto"] = "Error al elegir el piloto";
            }
            if (!$this->comprobarNave($codJugador, $datosBatalla["datosJugador"]["nave"])) {
                $errores[]["Nave"] = "Error al elegir el piloto";
            }
            //Falta comprobar los acesorioss y el numero ToDO

            if (!$errores) {
                //crear la batalla en la tabla batalla
                $codBatalla = $this->guardarBatalla();
                $datosDevuelta["cod_batalla"] = $codBatalla;
                //crear el registro de esa batalla
                $codRegistroBatalla = $this->crearRegistroBatalla($codBatalla, $codJugador, $datosBatalla["datosJugador"]["nave"], $datosBatalla["datosJugador"]["piloto"]);
                $datosDevuelta["cod_registro_batalla_jugador"] = $codRegistroBatalla;
                //Insertar los accesorios elegidos para la batalla
                $this->insertarRegistoAccesorios($codRegistroBatalla, $codJugador, $datosBatalla["datosJugador"]["accesorios"]);
                //Eleccion de las opciones por parte de la maquina
                $datosDevuelta["cod_registro_batalla_rival"] = $this->eleccionMaquina($datosBatalla["rival"], $codBatalla);
                //Devolever tambien los datos iniciales
                $registroBatallaJugador = RegistroBatalla::find($codRegistroBatalla);
                $datosIniciales = [
                    "nombre" => $registroBatallaJugador->usuario->nick,
                    "resistencia" => $registroBatallaJugador->totalResistencia(),
                    "ataque" => $registroBatallaJugador->totalAtaque(),
                    "defensa" => $registroBatallaJugador->totalDefensa(),
                    "imagenNave" => $registroBatallaJugador->usuario_nave->nave->imagen
                ];
                $datosDevuelta["inicialesJugador"] = $datosIniciales;
                $registroBatallaRival = RegistroBatalla::find($datosDevuelta["cod_registro_batalla_rival"]);
                $datosInicialesRival = [
                    "nombre" => $registroBatallaRival->usuario->nick,
                    "resistencia" => $registroBatallaRival->totalResistencia(),
                    "ataque" => $registroBatallaRival->totalAtaque(),
                    "defensa" => $registroBatallaRival->totalDefensa(),
                    "imagenNave" => $registroBatallaRival->usuario_nave->nave->imagen
                ];
                $datosDevuelta["inicialesRival"] = $datosInicialesRival;

                return response()->json($datosDevuelta);
            }
            return response()->json($errores);
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }

    /**
     * Funcion que compureba si el cod_usuario_piloto que
     * llega desde el cliente se corresponde con un piloto asociado a ese jugador
     *
     * @param $cod_usuario->Usuario
     * @param $cod_usuario_piloto->
     *
     * @return Boolean true|false
     */
    private function comprobarPiloto(int $cod_usuario, int $cod_usuario_piloto): bool
    {
        try {
            $us = Usuario::find($cod_usuario);
            if (
                $us->pilotos()
                ->select('cod_usuario_piloto')
                ->where('cod_usuario_piloto', '=', $cod_usuario_piloto)->get()->toArray() == []
            ) {
                return false;
            }
            return true;
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }

    /**
     * Funcion que compureba si el cod_usuario_nave que
     * llega desde el cliente se corresponde con un piloto asociado a ese jugador
     *
     * @param $cod_usuario->Usuario
     * @param $cod_usuario_nave->
     *
     * @return Boolean true|false
     */
    private function comprobarNave(int $cod_usuario, int $cod_usuario_nave): bool
    {
        try {
            $us = Usuario::find($cod_usuario);
            if (
                $us->naves()
                ->select('cod_usuario_nave')
                ->where('cod_usuario_nave', '=', $cod_usuario_nave)->get()->toArray() == []
            ) {
                return false;
            }
            return true;
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }

    /**
     * Función para insertar accesorios que usara el jugador activo para
     * la batalla
     * @param int $cod_registro_batalla
     * @param int $cod_usuario->Usuario propietario de los accesorios
     * @param array $accesorios->Accesorios que se se insertaran(Valores númericos)
     */
    private function insertarRegistoAccesorios(int $cod_registro_batalla, int $cod_usuario, array $accesorios)
    {
        try {
            foreach ($accesorios as $accesorio) {
                $RegistroAccesorios = new AccesorioRegistroBatalla;
                if ($this->comprobarAccesorio($cod_usuario, $accesorio)) {
                    $RegistroAccesorios->cod_usuario_accesorio = $accesorio;
                }
                $RegistroAccesorios->cod_registro_batalla = $cod_registro_batalla;
                $RegistroAccesorios->save();
            }
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }
    /**
     * Función para comprobar los accesorios que llegan desde el cliente pertenece a ese
     * usuario
     * @param int cod_usuario
     * @param int cod_usuario_accesorio
     * @return bool
     */
    private function comprobarAccesorio(int $cod_usuario, int $cod_usuario_accesorio): bool
    {
        try {
            $us = Usuario::find($cod_usuario);
            if (
                $us->accesorios()
                ->select('cod_usuario_accesorio')
                ->where('cod_usuario_accesorio', '=', $cod_usuario_accesorio)->get()->toArray() == []
            ) {
                return false;
            }
            return true;
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }


    /**
     *
     * Función que desarrola el funcionamiento del juego en le servidor <br>
     *
     * El funcionamiento es tirada de un "dado" y depende del resultado
     * de este se produce unos efectos u otros.<br>
     * Resultados:
     * <ul>
     *  <li>1->Pifia ningún jugador se hace daño</li>
     *  <li>2->Se produce daño entre los jugadores</li>
     *  <li>3->No se produce daño/li>
     *  <li>4->Se produce daño</li>
     *  <li>5->No se produce /li>
     *  <li>6->Se produce el efecto<li>
     * </ul>
     *
     * La partida acaba cuando la resistencia de unos de los jugadores llega a 0
     * o cuando pasa el tiempo que hay para la partida.
     *
     * El procedimiento guardara los datos en la tabla Log_batalla.<br>
     *
     * @param int $cod_usuario
     * @param int $cod_rival
     * @param int $cod_batalla
     * @return $cod_batalla
     *
     */
    public function procedimientoJuego(Request $request)
    {
        try {

            $datos = json_decode($request->getContent(), true);

            $cod_usuario = $datos["cod_usuario"];
            $cod_rival = $datos["cod_rival"];
            $cod_batalla = $datos["cod_batalla"];

            //Variables locales al metodo
            $controlProcedimiento = true;
            $turno = 0;
            $dadoJugador = 0;
            $habilidadActivaJugador = false;
            $turnosHabilidadJugador = 0;
            $primeraVezSeisJugador = false;
            $victoriaJugador = false;
            $efectoJugador = "Comienzo";
            $dadoRival = 0;
            $habilidadActivaRival = false;
            $turnosHabilidadRival = 0;
            $efectoRival = "Comienzo";
            $datosHabilidadJugador = null;
            $datosHabilidadRival = null;

            //Registros de los jugadores para la batalla
            $registroBatallaJugador = RegistroBatalla::where('cod_batalla', $cod_batalla)->where('cod_usuario', $cod_usuario)->get()->first();
            $registroBatallaRival = RegistroBatalla::where('cod_batalla', $cod_batalla)->where('cod_usuario', $cod_rival)->get()->first();

            //Registro de batalla
            $resTotalJugador = $registroBatallaJugador->totalResistencia();
            $ataTotalJugador = $registroBatallaJugador->totalAtaque();
            $defTotalJugador = $registroBatallaJugador->totalDefensa();

            //Comprobar si el piloto del jugador  tiene habilidad
            //$a=$registroBatallaJugador->usuario_piloto->piloto->habilidades->toArray();
            if (isset($registroBatallaJugador->usuario_piloto->piloto->habilidades->toArray()[0])) {
                $datosHabilidadJugador = [
                    "descripcion" => $registroBatallaJugador->usuario_piloto->piloto->habilidades->first()->descripcion,
                    "atributo" => $registroBatallaJugador->usuario_piloto->piloto->habilidades->first()->atributo,
                    "cantidad" => $registroBatallaJugador->usuario_piloto->piloto->habilidades->first()->cantidad,
                    "tiempo" => $registroBatallaJugador->usuario_piloto->piloto->habilidades->first()->tiempo_duracion,
                ];
            }

            $resTotalRival = $registroBatallaRival->totalResistencia();
            $ataTotalRival = $registroBatallaRival->totalAtaque();
            $defTotalRival = $registroBatallaRival->totalDefensa();

            //Comprobar si el piloto del rival  tiene habilidad
            if (isset($registroBatallaRival->usuario_piloto->piloto->habilidades->toArray()[0])) {
                $datosHabilidadRival = [
                    "descripcion" => $registroBatallaRival->usuario_piloto->piloto->habilidades->first()->descripcion,
                    "atributo" => $registroBatallaRival->usuario_piloto->piloto->habilidades->first()->atributo,
                    "cantidad" => $registroBatallaRival->usuario_piloto->piloto->habilidades->first()->cantidad,
                    "tiempo" => $registroBatallaRival->usuario_piloto->piloto->habilidades->first()->tiempo_duracion,
                ];
            }

            //Funcionamiento

            $horaInicial = intval(time());
            while ($controlProcedimiento && $turno <= 90) {
                $logJugador = new LogBatalla;
                $logRIval = new LogBatalla;
                $dadoJugador = rand(1, 6);
                $dadoRival = rand(1, 6);

                //Comprobar el estado de la habilidad
                //Si la habilidad esta activa se comprueba el num de turnos que dura
                //y se aplica el efecto
                if ($habilidadActivaJugador && $datosHabilidadJugador != null && $turno != 1) {
                    if ($datosHabilidadJugador["atributo"] != "puntos" || $datosHabilidadJugador["atributo"] != "creditos") {
                        if ($turnosHabilidadJugador < $datosHabilidadJugador["tiempo"] && $turnosHabilidadJugador == 0) {
                            switch ($datosHabilidadJugador["atributo"]) {
                                case "ataque":
                                    $ataTotalJugador += $datosHabilidadJugador["cantidad"];
                                    break;
                                case "defensa":
                                    $defTotalJugador += $datosHabilidadJugador["cantidad"];
                                    break;
                                default:
                                    $resTotalJugador += $datosHabilidadJugador["cantidad"];
                            }
                            $turnosHabilidadJugador++;
                        } else {
                            $habilidadActivaJugador = false;
                            $turnosHabilidadJugador = 0;
                            switch ($datosHabilidadJugador["atributo"]) {
                                case "ataque":
                                    $ataTotalJugador -= $datosHabilidadJugador["cantidad"];
                                    break;
                                case "defensa":
                                    $defTotalJugador -= $datosHabilidadJugador["cantidad"];
                                    break;
                                default:
                                    $resTotalJugador -= $datosHabilidadJugador["cantidad"];
                            }
                        }
                    }
                }
                if ($turno != 0) {
                    //tirada de dado del jugador 1
                    switch ($dadoJugador) {
                        case 1:
                            $efectoJugador = "Ataque fallado";
                            break;
                        case 2:
                            //Restar al rival el ataque del jugador
                            $resta = (($ataTotalJugador - $defTotalRival) <= 0 ? 0 : $ataTotalJugador - $defTotalRival);
                            $resTotalRival = ($resTotalRival - $resta) <= 0 ? 0 : $resTotalRival - $resta;
                            $efectoJugador = "Ataque acertado $resta de daño";
                            break;
                        case 3:
                            $efectoJugador = "Rival esquiva";
                            break;
                        case 4:

                            $resta = ($ataTotalJugador - $defTotalRival) <= 0 ? 0 : $ataTotalJugador - $defTotalRival;
                            $resTotalRival = ($resTotalRival - $resta) <= 0 ? 0 : $resTotalRival - $resta;
                            $efectoJugador = "Ataque acertado $resta de daño";
                            break;
                        case 5:
                            $efectoJugador = "Rival esquiva";
                            break;
                        case 6:
                            $habilidadActivaJugador = true;
                            if ($datosHabilidadJugador != null) {
                                if ($datosHabilidadJugador["atributo"] == "puntos" || $datosHabilidadJugador["atributo"] == "creditos") {
                                    $primeraVezSeisJugador = true;
                                    $resta = ($ataTotalJugador - $defTotalRival) <= 0 ? 0 : $ataTotalJugador - $defTotalRival;
                                    $resTotalRival = ($resTotalRival - $resta) <= 0 ? 0 : $resTotalRival - $resta;
                                    $efectoJugador = "Habilidad de final de partida activada y ataque acertado $resta de daño";
                                } else {
                                    $efectoJugador =  "Habilidad activada: Aumento de " . $datosHabilidadJugador["atributo"] . " en " . $datosHabilidadJugador["cantidad"] . "pts durante " . $datosHabilidadJugador["tiempo"] . " turnos";
                                }
                            }
                            break;
                    }  //Fin tirada del jugador
                }
                //Comprobar el estado de la habilidad del rival
                //Si la habilidad esta activa se comprueba el num de turnos que dura
                //y se aplica el efecto
                if ($habilidadActivaRival && $datosHabilidadRival != null && $turno != 1) {
                    if ($datosHabilidadRival["atributo"] != "puntos" || $datosHabilidadRival["atributo"] != "creditos") {
                        if ($turnosHabilidadRival < $datosHabilidadRival["tiempo"] && $turnosHabilidadRival == 0) {
                            switch ($datosHabilidadRival["atributo"]) {
                                case "ataque":
                                    $ataTotalRival += $datosHabilidadRival["cantidad"];
                                    break;
                                case "defensa":
                                    $defTotalRival += $datosHabilidadRival["cantidad"];
                                    break;
                                default:
                                    $resTotalRival += $datosHabilidadRival["cantidad"];
                            }
                            $turnosHabilidadRival++;
                        } else {
                            $habilidadActivaRival = false;
                            $turnosHabilidadRival = 0;
                            switch ($datosHabilidadRival["atributo"]) {
                                case "ataque":
                                    $ataTotalRival -= $datosHabilidadRival["cantidad"];
                                    break;
                                case "defensa":
                                    $defTotalRival -= $datosHabilidadRival["cantidad"];
                                    break;
                                default:
                                    $resTotalRival -= $datosHabilidadRival["cantidad"];
                            }
                        }
                    }
                }
                if ($turno != 0) {
                    //Tirada del jugador rival
                    switch ($dadoRival) {
                        case 1:
                            $efectoRival = "Ataque fallado";
                            break;
                        case 2:
                            //Restar al rival el ataque del jugador
                            $resta = ($ataTotalRival - $defTotalJugador) <= 0 ? 0 : $ataTotalRival - $defTotalJugador;
                            $resTotalJugador = ($resTotalJugador - $resta) <= 0 ? 0 : $resTotalJugador - $resta;
                            $efectoRival =  "Ataque acertado $resta de daño";
                            break;
                        case 3:
                            $efectoRival = "Rival esquiva";
                            break;
                        case 4:
                            $resta = ($ataTotalRival - $defTotalJugador) <= 0 ? 0 : $ataTotalRival - $defTotalJugador;
                            $resTotalJugador = ($resTotalJugador - $resta) <= 0 ? 0 : $resTotalJugador - $resta;
                            $efectoRival = "Ataque acertado $resta de daño";
                            break;
                        case 5:
                            $efectoRival = "Rival esquiva";
                            break;
                        case 6:
                            $habilidadActivaRival = true;
                            if ($datosHabilidadRival != null) {
                                if ($datosHabilidadRival["atributo"] == "puntos" || $datosHabilidadRival["atributo"] == "creditos") {
                                    $resta = ($ataTotalRival - $defTotalJugador) <= 0 ? 0 : $ataTotalRival - $defTotalJugador;
                                    $resTotalJugador = ($resTotalJugador - $resta) <= 0 ? 0 : $resTotalJugador - $resta;
                                    $efectoRival = "Habilidad de final de partida activada y ataque acertado $resta de daño";
                                } else {
                                    $efectoRival = "Habilidad activada: Aumento de " . $datosHabilidadRival["atributo"] . " en " . $datosHabilidadRival["cantidad"] . " pts durante " . $datosHabilidadRival["tiempo"] . " turnos";
                                }
                            }
                            break;
                    }      //Fin tirada del rival
                }
                //Comprobar si algun jugador tiene aun resistencia
                if ($resTotalJugador <= 0 || $resTotalRival <= 0) {
                    $controlProcedimiento = false;
                    if ($resTotalRival <= 0) {
                        $victoriaJugador = true;
                    }
                }

                //Añadir a la log la accion del jugador
                $logJugador->cod_registro_batalla = $registroBatallaJugador->cod_registro_batalla;
                $logJugador->turno = $turno;
                $logJugador->dado = $dadoJugador;
                $logJugador->efecto = $efectoJugador;
                $logJugador->resistencia_actual = $resTotalJugador;
                $logJugador->ataque_actual = $ataTotalJugador;
                $logJugador->defensa_actual = $defTotalJugador;
                $logJugador->estado = $controlProcedimiento;
                $logJugador->save();

                //Añadir al log la accion del rival
                $logRIval->cod_registro_batalla = $registroBatallaRival->cod_registro_batalla;
                $logRIval->turno = $turno;
                $logRIval->dado = $dadoRival;
                $logRIval->efecto = $efectoRival;
                $logRIval->resistencia_actual = $resTotalRival;
                $logRIval->ataque_actual = $ataTotalRival;
                $logRIval->defensa_actual = $defTotalRival;
                $logRIval->estado = $controlProcedimiento;
                $logRIval->save();

                $turno++;
            }

            //COmprobar si la habilidad del jugador puede afectar al resultado de la batalla
            if ($datosHabilidadJugador != null) {
                $this->determinarGanador($registroBatallaJugador, $registroBatallaRival, $victoriaJugador, $datosHabilidadJugador["atributo"], $datosHabilidadJugador["cantidad"], $primeraVezSeisJugador, $horaInicial + 90);
            } else {
                $this->determinarGanador($registroBatallaJugador, $registroBatallaRival, $victoriaJugador, "", 0, $primeraVezSeisJugador, $horaInicial + 90);
            }
            return response()->json(["status" => 200]);
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }

    /**
     * Función que genera la eleccion del jugador rival al
     * que el jugador activo decidio enfrentarse
     * Se escogera los datos para este rival de forma aleatorio
     * en funcion de lo que tenga ese jugador guardado
     * Hara las insercciones necesarias en la BD para que se pueda montar la
     * batalla
     * @param $cod_usuario->Jugador rival elegido por el usuario
     * @param $cod_batalla->Batalla correspondiente al enfrentamiento
     */
    private function eleccionMaquina(int $cod_usuario, int $cod_batalla): int
    {
        try {
            $usuario = Usuario::find($cod_usuario);
            $registroBatalla = new RegistroBatalla;
            //eleccion de nave
            $nave = $usuario->naves()->get()->toArray();
            $numRandom = rand(1, count($nave)) - 1;
            $numMaxAccesorios = $nave[$numRandom]['num_accesorios'];
            $cod_usuario_nave = $nave[$numRandom]['pivot']['cod_usuario_nave'];

            //Eleccion de piloto
            $piloto = $usuario->pilotos()->get()->toArray();
            $cod_usuario_piloto = $piloto[rand(1, count($piloto)) - 1]['pivot']['cod_usuario_piloto'];

            //Creacion del registro batalla

            $registroBatalla->cod_batalla = $cod_batalla;
            $registroBatalla->cod_usuario = $cod_usuario;
            $registroBatalla->cod_usuario_nave = $cod_usuario_nave;
            $registroBatalla->cod_usuario_piloto = $cod_usuario_piloto;
            $registroBatalla->turno_actual = 0;
            $registroBatalla->vista_completa = false;
            $registroBatalla->save();
            $cod_registro_batalla = $registroBatalla->cod_registro_batalla;

            //Eleccion de los artefacots
            $this->insertarRegistoAccesoriosMaquina($cod_registro_batalla, $numMaxAccesorios, $usuario->accesorios()->get()->toArray());

            return $cod_registro_batalla;
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }


    /**
     * Función para elegir aleatoriamente los accesorios con los que
     * participara el jugador rival
     * @param int $cod_registro_batalla
     * @param int $nummax-> Número maximo de accesorios que puede tener en la batalla
     * @param array $accesorios->array con los accesorios que tiene el jugador en la bd
     * @return void
     */
    private function insertarRegistoAccesoriosMaquina(int $cod_registro_batalla, int $nummax, array $accesorios): void
    {
        $numRandom = 0;
        $i = 0;
        //Comprobar que el usuario no tiene menos accesorios de lo que permite su nave
        //Si tiene menos cambiamos el numMaximo por el count de accesorios
        if (count($accesorios) < $nummax) {
            $nummax = count($accesorios);
        }
        while ($i < $nummax) {
            $numRandom = rand(1, count($accesorios)) - 1;
            $RegistroAccesorios = new AccesorioRegistroBatalla;
            if (
                AccesorioRegistroBatalla::select('cod_usuario_accesorio')
                ->where('cod_registro_batalla', '=', "'" . $cod_registro_batalla . "'")
                ->where('cod_usuario_accesorio', '=', "'" . $accesorios[$numRandom]['pivot']['cod_usuario_accesorio'] . "'")->get()->toArray() == []
            ) {
                $RegistroAccesorios->cod_usuario_accesorio = $accesorios[$numRandom]['pivot']['cod_usuario_accesorio'];
                $RegistroAccesorios->cod_registro_batalla = $cod_registro_batalla;
                $RegistroAccesorios->save();
                $i++;
            }
        }
    }

    /**
     * Función que calcula el ganador del duelo y
     * actualiza los puntos,victorias,derrotas y creditos del los
     * usuarios implicados en una batalla en función de lo ocurrido
     * en la propia batalla
     *
     * @param RegistroBatalla $regJugador Registro de la batalla para el jgador activo de
     *                          la actual batalla
     * @param RegistroBatalla $regRival Registro de la batalla para el jugador rival de la actual batalla
     * @param bool $victoriaJugador true si el jugador activo salio gananador del duelo
     *                              false si el jugador acitvo perdió, emparo o no pudo ganar antes de acabar el tiempo
     * @param string $tipoHabilidad Cadena con el tipo de hailidad y comprbar si se afecta al resultado final o no
     * @param int $cantidad Cantidad total que aumenta o disminuye al atributo afectado por la habilidad del piloto
     * @param bool $primeraVezSeis True SI la habilidad del piloto se activo durante el combate.
     *                              False si la habilidad no se activo durante el combate
     * @param int $horaFInal Hora finala a la que acabo el combate
     */

    private function determinarGanador(RegistroBatalla $regJugador, RegistroBatalla $regRival, bool $victoriaJugador, string $tipoHabilidad, int $cantidad, bool $primeraVezSeis, int $horaFInal): void
    {

        if ($victoriaJugador) {
            //Aumentar victoria y derrotas
            $regJugador->usuario->victorias++;
            $regRival->usuario->derrotas++;
            $regJugador->batalla->usuario_ganador = $regJugador->usuario->cod_usuario;
            $regJugador->batalla->hora_final = $horaFInal;
            $regJugador->batalla->estado = 0;
            $regJugador->batalla->save();

            //Aumentar creditos
            if ($tipoHabilidad == 'creditos' && $primeraVezSeis) {
                $regJugador->usuario->creditos += ($this->creditosGanados + $cantidad);
            } else {
                $regJugador->usuario->creditos += $this->creditosGanados;
            }
            //Aumentar puntos
            if ($tipoHabilidad == 'puntos' && $primeraVezSeis) {
                $regJugador->usuario->puntos += ($this->puntosGanados + $cantidad);
            } else {
                $regJugador->usuario->puntos += $this->puntosGanados;
            }
            $calcPuntos = $regRival->usuario->puntos - $this->puntosPerdida;
            $regRival->usuario->puntos = ($calcPuntos < 0 ? 0 : $calcPuntos);
        } else {
            //Aumentar derrotas y victoria
            $regJugador->usuario->derrotas++;
            $regRival->usuario->victorias++;
            $regRival->batalla->hora_final = $horaFInal;
            $regRival->batalla->estado = 0;
            $regRival->batalla->usuario_ganador = $regRival->usuario->cod_usuario;
            $regRival->batalla->save();
            $calcPuntos = $regJugador->usuario->puntos - $this->puntosPerdida;
            $regJugador->usuario->puntos = ($calcPuntos < 0 ? 0 : $calcPuntos);
            $regRival->usuario->puntos += $this->puntosGanados;
        }
        $regJugador->usuario->save();
        $regRival->usuario->save();
        //Actualiza divisiones si fuera necesario
        $regJugador->usuario->comprobarDivision();
        $regRival->usuario->comprobarDivision();
    }

    /**
     * Función para mostrar la batalla del jugador activo.
     *
     * @param Request $request Objeto request con toda la información
     * necesaria para mostrar la batalla que llega desde el cliente.
     *
     */
    public function muestraBatalla(Request $request)
    {
        $datos = json_decode($request->getContent(), true);
        $datosDevuelta = [];

        try {
            //14/06/2023
            if (isset($datos["cod_batalla"])) {
                $regJugador = RegistroBatalla::where("cod_batalla", "=", $datos["cod_batalla"])
                    ->where("cod_usuario", "=", Auth::user()->cod_usuario)
                    ->get();
                $regRival = RegistroBatalla::where("cod_batalla", "=", $datos["cod_batalla"])
                    ->where("cod_usuario", "<>", Auth::user()->cod_usuario)
                    ->get();
            } else {
                $regJugador = RegistroBatalla::find($datos["cod_registro_batalla_jugador"]);
                $regRival = RegistroBatalla::find($datos["cod_registro_batalla_rival"]);
            }
            $logActualJug = $regJugador->log_batallas()->where('turno', '=', $regJugador->turno_actual)->first();
            $logActualRiv = $regRival->log_batallas()->where('turno', '=', $regJugador->turno_actual)->first();
            $datosDevuelta["vidaJugador"] = $logActualJug->resistencia_actual;
            $datosDevuelta["vidaRival"] = $logActualRiv->resistencia_actual;
            $datosDevuelta["efectoJugador"] = $logActualJug->efecto;
            $datosDevuelta["efectoRival"] = $logActualRiv->efecto;
            $datosDevuelta["turno"] = $regJugador->turno_actual;
            $datosDevuelta["estado"] = intval($logActualJug->estado);
            $regJugador->turno_actual++;
            $regRival->turno_actual++;

            $regJugador->save();

            return response()->json($datosDevuelta);
        } catch (\Exception $e) {
            $regJugador->vista_completa = true;
            $regRival->vista_completa = false;
            $regJugador->turno_actual = 0;
            $regRival->turno_actual = 0;
            $regJugador->save();
            $regRival->save();
            return response()->json(["batalla finalizada" => "Fin"]);
        }
    }

    /**
     * Crear el registro de la btalla en la base de datos
     *
     * @param int $codBatalla ->Cod de la batalla al que corresponde el registro batalla
     * @param int $codJugador ->cod del jugador implicado en la batalla
     * @param int $cod_usuario_nave ->cod de la nave que el usuario elegio parar esa batalla
     * @param int $cod_usuario_piloo ->Cod del piloto que elegio el jugador para esa batalla
     *
     * @return int cod_registro_batalla que genero el insert en bd
     */
    private function crearRegistroBatalla(int $codBatalla, int $codJugador, int $cod_usuario_nave, int $cod_usuario_piloto): int
    {
        $registroBatalla = new RegistroBatalla;
        $registroBatalla->cod_batalla = $codBatalla;
        $registroBatalla->cod_usuario = $codJugador;
        $registroBatalla->cod_usuario_piloto = $cod_usuario_piloto;
        $registroBatalla->cod_usuario_nave = $cod_usuario_nave;
        $registroBatalla->turno_actual = 0;
        $registroBatalla->vista_completa = false;
        $registroBatalla->save();

        return $registroBatalla->cod_registro_batalla;
    }

    /**
     * Función para guardar la batalla en la base de datos
     * @return int cod_batalla generado
     */
    private function guardarBatalla(): int
    {
        $batalla = new Batalla;
        $batalla->hora_inicio = Carbon::now()->toTimeString();
        $batalla->estado = 1;
        $batalla->hora_final = null;
        $batalla->usuario_ganador = null;
        $batalla->fecha = Carbon::now()->toDateString();
        $batalla->tiempo_batalla = 90;
        $batalla->save();
        return $batalla->cod_batalla;
    }

    /**
     * Función para gestionar la vista de clasificación de los jugadores 
     * 
     * @param Request 
     * @return View 
     */
    public function verClasificacion(Request $request)
    {
        $divisiones = new Divisiones;

        //Posibles filtros
        if ($request->isMethod('post')) {
            if ($request->divisiion != null && $request->nickJugador == null) {
                $usuarios = Usuario::where('cod_division', '=', Divisiones::getCodDivision($request->division))->get();
            }
            if ($request->nickJugador != null && $request->divisiion == null) {
                $usuarios = Usuario::where('nick', 'like', '%' . $request->nickJugador . '%')->get();
            }
            if ($request->nickJugador != null && $request->divisiion != null) {
                $usuarios = Usuario::where('cod_division', '=', Divisiones::getCodDivision($request->division))->where('nick', 'like', '%' . $request->nickJugador . '%')->get();
            }
        } else {
            $usuarios = Usuario::orderBy('puntos', 'desc')->paginate(5);
        }

        return view("juego.clasificacion", compact('usuarios', 'divisiones'));
    }

    /**
     * Función statica para obtener los datos de una partida ya 
     * realizada
     * @param int $batalla->cod_batalla que se quiere consultar
     */
    public static function obtenerDatos(int $batalla)
    {
        $datosDevuelta = [];
        $codRegJugador = RegistroBatalla::where("cod_batalla", "=", $batalla)
            ->where("cod_usuario", "=", Usuario::usuarioActivo()->cod_usuario)->first()->cod_registro_batalla;
        $codRegRival = RegistroBatalla::where("cod_batalla", "=", $batalla)
            ->where("cod_usuario", "<>", Usuario::usuarioActivo()->cod_usuario)->first()->cod_registro_batalla;
        $registroBatallaJugador = RegistroBatalla::find($codRegJugador);
        $datosIniciales = [
            "nombre" => Usuario::usuarioActivo()->nick,
            "resistencia" => $registroBatallaJugador->totalResistencia(),
            "ataque" => $registroBatallaJugador->totalAtaque(),
            "defensa" => $registroBatallaJugador->totalDefensa(),
            "imagenNave" => $registroBatallaJugador->usuario_nave->nave->imagen
        ];
        $datosDevuelta["inicialesJugador"] = $datosIniciales;
        $registroBatallaRival = RegistroBatalla::find($codRegRival);
        $rival = Usuario::find($registroBatallaRival->cod_usuario);
        $datosInicialesRival = [
            "nombre" => $rival->nick,
            "resistencia" => $registroBatallaRival->totalResistencia(),
            "ataque" => $registroBatallaRival->totalAtaque(),
            "defensa" => $registroBatallaRival->totalDefensa(),
            "imagenNave" => $registroBatallaRival->usuario_nave->nave->imagen
        ];

        $datosDevuelta["inicialesRival"] = $datosInicialesRival;
        $datosDevuelta["cod_registro_batalla_jugador"] = $codRegJugador;
        $datosDevuelta["cod_registro_batalla_rival"] = $codRegRival;
        return $datosDevuelta;
    }
}
