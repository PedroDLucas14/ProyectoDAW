<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Nave;
use App\Models\Piloto;
use App\Models\Accesorio;


/**
 * Controlador para el funcionamiento del mercado
 * para poder comprar pilotos, naves y accesorios
 *
 */
class MercadoController extends Controller
{

    /**
     * Acción que muestra que recoge el usuario conectado y
     * manda a la vista las naves,accesorios y pilotos que no
     * tiene en poseción el usuario
     * @param Request 
     */

    public function market(Request $request)
    {
        $link = "naves";

        //localizar lo que tiene el usuario en posesicón
        $usuario = Usuario::usuarioActivo();
        $codNavesUsuario = Usuario::usuarioActivo()->naves->pluck('cod_nave')->toArray();
        $codPilotosUsuario = Usuario::usuarioActivo()->pilotos->pluck('cod_piloto')->toArray();
        $codAccsUsuario = Usuario::usuarioActivo()->accesorios->pluck('cod_accesorio')->toArray();

        //Recoger los productos que no tiene el usuario

        $naves = Nave::whereNotIn('cod_nave', $codNavesUsuario)->paginate($perPage = 4, $colums = ['*'], $pageName = 'naves');
        $pilotos = Piloto::whereNotIn('cod_piloto', $codPilotosUsuario)->paginate($perPage = 4, $colums = ['*'], $pageName = 'pilotos');
        $accesorios = Accesorio::whereNotIn('cod_accesorio', $codAccsUsuario)->paginate($perPage = 4, $colums = ['*'], $pageName = 'accesorios');

        //Comprobar filtros
        if ($request->isMethod('post')) {
            if ($request->cat == "pilotos") {
                $link = "pilotos";
                $pilotos = Piloto::whereNotIn('cod_piloto', $codPilotosUsuario)
                    ->nombre($request->nombre)
                    ->when($request->ataque !== null, function ($query) use ($request) {
                        return $query->ataque($request->ataque, $request->operadorAtaque);
                    })
                    ->when($request->defensa !== null, function ($query) use ($request) {
                        return $query->defensa($request->defensa, $request->operadorDefensa);
                    })
                    ->when($request->resistencia !== null, function ($query) use ($request) {
                        return $query->resistencia($request->resistencia, $request->operadorResistencia);
                    })
                    ->when($request->valorTotal !== null, function ($query) use ($request) {
                        return $query->valor($request->valorTotal, $request->operadorCreditos);
                    })
                    ->paginate($perPage = 10, $colums = ['*'], $pageName = 'pilotos');
            }
            if ($request->cat == "naves") {
                $link = "naves";
                $naves = Nave::whereNotIn('cod_nave', $codNavesUsuario)
                    ->nombre($request->nombre)
                    ->when($request->ataque !== null, function ($query) use ($request) {
                        return $query->ataque($request->ataque, $request->operadorAtaque);
                    })
                    ->when($request->defensa !== null, function ($query) use ($request) {
                        return $query->defensa($request->defensa, $request->operadorDefensa);
                    })
                    ->when($request->resistencia !== null, function ($query) use ($request) {
                        return $query->resistencia($request->resistencia, $request->operadorResistencia);
                    })
                    ->when($request->valorTotal !== null, function ($query) use ($request) {
                        return $query->valor($request->valorTotal, $request->operadorCreditos);
                    })
                    ->paginate($perPage = 10, $colums = ['*'], $pageName = 'naves');
            }
            if ($request->cat == "accesorios") {
                $link = "accesorios";
                $accesorios = Accesorio::whereNotIn('cod_accesorio', $codAccsUsuario)
                    ->nombre($request->nombre)
                    ->when($request->ataque !== null, function ($query) use ($request) {
                        return $query->ataque($request->ataque, $request->operadorAtaque);
                    })
                    ->when($request->defensa !== null, function ($query) use ($request) {
                        return $query->defensa($request->defensa, $request->operadorDefensa);
                    })
                    ->when($request->resistencia !== null, function ($query) use ($request) {
                        return $query->resistencia($request->resistencia, $request->operadorResistencia);
                    })
                    ->when($request->valorTotal !== null, function ($query) use ($request) {
                        return $query->valor($request->valorTotal, $request->operadorCreditos);
                    })
                    ->paginate($perPage = 10, $colums = ['*'], $pageName = 'accesorios');
            }
        }

        return view('juego.mercado', compact('usuario', 'naves', 'pilotos', 'accesorios', 'link'));
    }



    /**
     * Función que permite añadir un piloto al usuario activo 
     * @param Piloto objeto piloto con la información del piloto que se desea comprar
     * 
     */
    public function comprarPiloto(Piloto $piloto)
    {
        $usuario = Usuario::usuarioActivo();

        if ($usuario->comprarPiloto($piloto->cod_piloto)) {
            return redirect()->route('mercado.ver');
        }
    }

    /**
     * Función que permite añadir un nave al usuario activo 
     * @param Nave objeto Nave con la información de la  nave que se desea comprar
     * 
     */
    public function comprarNaves(Nave $nave)
    {
        $usuario = Usuario::usuarioActivo();
        if ($usuario->comprarNave($nave->cod_nave)) {
            return redirect()->route('mercado.ver');
        } else {
            return redirect()->route('error')->withErrors(['creditos' => 'Creditos insuficientes']);
        }
    }

    /**
     * Función que permite añadir un Accesorio al usuario activo 
     * @param Accesorio objeto Accesorio con la información del Accesorio que se desea comprar
     * 
     */
    public function comprarAccesorio(Accesorio $accesorio)
    {
        $usuario = Usuario::usuarioActivo();
        if ($usuario->comprarAccesorios($accesorio->cod_accesorio)) {
            return redirect()->route('mercado.ver');
        }
    }
}
