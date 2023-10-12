<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\UsuariosAccesorio;
use App\Models\UsuariosNave;
use App\Models\UsuariosPiloto;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use App\Utils\PaginateCollection;

/**
 * Controlador para la gestión del perfil de usuario activo
 */

class PerfilController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Accion para mostrar el perfil del jugador
     * @param Request
     */
    public function verPerfil(Request $request)
    {
        $usuario = Usuario::usuarioActivo();
        if ($request->isMethod('post')) {
            // Actualizar el perfil
            $request->validate(
                [
                    'nick' => [Rule::unique('acl_usuarios')->ignore(Auth::user()), Rule::unique('usuarios')->ignore($usuario)],
                    'email' => ['required', 'max:255', Rule::unique('acl_usuarios')->ignore(Auth::user()), Rule::unique('usuarios')->ignore($usuario)],
                    'password' => ['nullable', 'string', 'min:8', 'max:50', 'regex:/^(?=.*[A-Z])(?=.*\d).{8,}$/'],
                    "confirmarPassword" => 'nullable|same:password',
                    'fecha_nacimiento' => ['nullable', 'date', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
                    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
                ],
                [
                    "same" => "La contraseñas no coinciden",
                    "regex" => "La contraseña debe contener al menos una mayuscula  un número"
                ]
            );

            $usuario->fill($request->all());
            //
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $fileName = $usuario->cod_usuario . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('imgBD/usuarios'), $fileName);

                // Actualizar la ruta de la imagen de perfil en la base de datos
                $usuario->avatar = 'imgBD/usuarios/' . $fileName;
            }
            //
            $usuario->save();
            // Puedes mostrar un mensaje de éxito si lo deseas
        }
        $batallasUsu = $usuario->registro_batallas->all();
        $btl = [];
        //sacaar los nullos si los hubiera
        foreach ($batallasUsu as $batallas) {
            if ($batallas != null) {
                array_push($btl, $batallas->batalla);
            }
        }
        foreach ($btl as $clave => $valor) {
            if (empty($valor)) unset($btl[$clave]);
        }
        // Convertir el array en una instancia de Collection
        $collection = new Collection($btl);
        //Paginar la colección
        $paginatedData = PaginateCollection::paginate($collection, 5);

        return view('perfil.index', compact('usuario', 'paginatedData'));
    }

    /**
     * Acción para mostrar el inventario del jugador
     * Pilotos,Accesorios o Naves
     * @param Request 
     */
    public function inventario(Request $request)
    {
        $link = 'naves';
        $usuario = Usuario::usuarioActivo();

        $pilotos = $usuario->pilotos()->paginate($perPage = 4, $colums = ['*'], $pageName = 'pilotos');
        $naves = $usuario->naves()->paginate($perPage = 4, $colums = ['*'], $pageName = 'naves');
        $accesorios = $usuario->accesorios()->paginate($perPage = 4, $colums = ['*'], $pageName = 'accesorios');

        //Comprobar filtros
        if ($request->isMethod('post')) {
            if ($request->cat == "pilotos") {
                $link = 'pilotos';
                $pilotos = $usuario->pilotos()
                    ->when($request->defensa_actual !== null, function ($query) use ($request) {
                        return $query->defensa($request->defensa_actual, $request->operadorDefensa);
                    })
                    ->when($request->ataque_actual !== null, function ($query) use ($request) {
                        return $query->ataque($request->ataque_actual, $request->operadorAtaque);
                    })
                    ->when($request->resistencia_actual !== null, function ($query) use ($request) {
                        return $query->resistencia($request->resistencia_actual, $request->operadorResistencia);
                    })
                    ->when($request->nivel !== null, function ($query) use ($request) {
                        return $query->nivel($request->nivel, $request->operadorNivel);
                    })
                    ->paginate($perPage = 4, $colums = ['*'], $pageName = 'pilotos');
            }
            if ($request->cat == "naves") {
                $link = 'naves';
                $naves = $usuario->naves()
                    ->when($request->defensa_actual !== null, function ($query) use ($request) {
                        return $query->defensaActual($request->defensa_actual, $request->operadorDefensa);
                    })
                    ->when($request->ataque_actual !== null, function ($query) use ($request) {
                        return $query->ataqueActual($request->ataque_actual, $request->operadorAtaque);
                    })
                    ->when($request->resistencia_actual !== null, function ($query) use ($request) {
                        return $query->resistenciaActual($request->resistencia_actual, $request->operadorResistencia);
                    })
                    ->when($request->nivel !== null, function ($query) use ($request) {
                        return $query->nivel($request->nivel, $request->operadorNivel);
                    })
                    ->paginate($perPage = 4, $colums = ['*'], $pageName = 'naves');
            }
            if ($request->cat == "accesorios") {
                $link = 'accesorios';
                $accesorios = $usuario->accesorios()
                    ->when($request->defensa_actual !== null, function ($query) use ($request) {
                        return $query->defensa($request->defensa_actual, $request->operadorDefensa);
                    })
                    ->when($request->ataque_actual !== null, function ($query) use ($request) {
                        return $query->ataque($request->ataque_actual, $request->operadorAtaque);
                    })
                    ->when($request->resistencia_actual !== null, function ($query) use ($request) {
                        return $query->resistencia($request->resistencia_actual, $request->operadorResistencia);
                    })
                    ->when($request->nivel !== null, function ($query) use ($request) {
                        return $query->nivel($request->nivel, $request->operadorNivel);
                    })
                    ->paginate($perPage = 4, $colums = ['*'], $pageName = 'accesorios');
            }
        }
        return view('perfil.inventario', compact('usuario', 'pilotos', 'naves', 'accesorios', 'link'));
    }

    /**
     * Comprueba la subida de nivel antes de realizarla
     * @param Request 
     */
    public function compruebaSubida(Request $request)
    {
        try {
            $datos = json_decode($request->getContent(), true);
            $usuario = Usuario::usuarioActivo();

            $tipo = $datos["tipo"];
            $cod = $datos["cod"];

            $datosDevueltos = [];
            switch ($tipo) {
                case "nave":
                    $nave = $usuario->naves()->where('cod_usuario_nave', '=', $cod)->first();
                    $datosDevueltos["coste"] = $nave->coste_nivel * $datos["subida"];
                    $nivel = $datos["subida"];
                    $datosDevueltos["resistencia"] = $nave->pivot->resistencia_actual + ($nave->aumento_resistencia * $nivel);
                    $datosDevueltos["ataque"] = $nave->pivot->ataque_actual + ($nave->aumento_ataque * $nivel);
                    $datosDevueltos["defensa"] = $nave->pivot->defensa_actual + ($nave->aumento_defensa * $nivel);
                    break;
                case "piloto":
                    $piloto = $usuario->pilotos()->where('cod_usuario_piloto', '=', $cod)->first();
                    $datosDevueltos["coste"] = $piloto->coste_nivel * $datos["subida"];
                    $nivel = $datos["subida"] + $piloto->pivot->nivel;
                    $datosDevueltos["resistencia"] = $piloto->pivot->resistencia_actual + ($piloto->aumento_resistencia * $nivel);
                    $datosDevueltos["ataque"] = $piloto->pivot->ataque_actual + ($piloto->aumento_ataque * $nivel);
                    $datosDevueltos["defensa"] = $piloto->pivot->defensa_actual + ($piloto->aumento_defensa * $nivel);
                    break;
                case "accesorio":
                    $accesorio = $usuario->accesorios()->where('cod_usuario_accesorio', '=', $cod)->first();
                    $datosDevueltos["coste"] = $accesorio->coste_nivel * $datos["subida"];
                    $nivel = $datos["subida"] + $accesorio->pivot->nivel;
                    $datosDevueltos["resistencia"] = $accesorio->pivot->resistencia_actual + ($accesorio->aumento_resistencia * $nivel);
                    $datosDevueltos["ataque"] = $accesorio->pivot->ataque_actual + ($accesorio->aumento_ataque * $nivel);
                    $datosDevueltos["defensa"] = $accesorio->pivot->defensa_actual + ($accesorio->aumento_defensa * $nivel);
                    break;
            }
            return response()->json($datosDevueltos);
        } catch (\Exception $e) {
            return response()->json($datosDevueltos["error"] = "Ha ocurrido un error intentelo más tarde");
        }
    }

    /**
     * Función para subir de nivel el objeto elegido
     * @param Request 
     */
    public function subirNiveles(Request $request)
    {
        try {
            $datos = json_decode($request->getContent(), true);
            $tipo = $datos["tipo"];
            $cod = $datos["cod"];
            $nivel = $datos["niveles"];
            $datosDevueltos = [];

            switch ($tipo) {
                case "nave":
                    if (UsuariosNave::subirNiveles($cod, $nivel)) {
                        $datosDevueltos["mensaje"] = "Nivel subido correctamente";
                    } else {
                        $datosDevueltos["error"] = "Error al subir de nivel compruebe sus créditos";
                    }
                    break;
                case "piloto":
                    if (UsuariosPiloto::subirNivel($cod, $nivel)) {
                        $datosDevueltos["mensaje"] = "Nivel subido correctamente";
                    } else {
                        $datosDevueltos["error"] = "Error al subir de nivel compruebe sus créditos";
                    }
                    break;
                case "accesorio":
                    if (UsuariosAccesorio::subirNivel($cod, $nivel)) {
                        $datosDevueltos["mensaje"] = "Nivel subido correctamente";
                    } else {
                        $datosDevueltos["error"] = "Error al subir de nivel compruebe sus créditos";
                    }
                    break;
            }
            return response()->json($datosDevueltos);
        } catch (\Exception $e) {
            return response()->json($datosDevueltos["error"] = "Ha ocurrido un error intentelo más tarde");
        }
    }

    /**
     * Función que gestiona la vista para recrear la partida jugada
     * @param int cod_batalla
     */
    public function verPartida(int $cod_batalla)
    {
        $datosDevuelta = JuegoController::obtenerDatos($cod_batalla);
        return view('perfil.verPartida', compact('cod_batalla', 'datosDevuelta'));
    }
    /**
     * Funcion que pide los datos de una batalla para poder recrearla
     */
    public function datosPartida(Request $request)
    {
        $datosDevuelta = JuegoController::obtenerDatos($request->cod_batalla);
        return response()->json($datosDevuelta);
    }
}
