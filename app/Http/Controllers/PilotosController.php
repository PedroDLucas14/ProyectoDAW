<?php

namespace App\Http\Controllers;

use App\Models\Piloto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Clase controlador para el crud de pilotos
 */
class PilotosController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el crud de pilotos en formato tabla
     */
    public function index(Request $request): View
    {
        try {
            $pilotos = Piloto::paginate(5);

            //Comprobar filtros
            if ($request->isMethod('post')) {
                $pilotos = Piloto::select('*')
                    ->when($request->nombre !== null, function ($query) use ($request) {
                        return $query->nombre($request->nombre);
                    })
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
                    ->paginate(5);
            }
        } catch (\Exception $e) {
           return View('errors.500');
        }
        return view('gestion.pilotos.index', compact('pilotos'));
    }

    /**
     * Función para mostrar la ficha de un piloto
     * @param Piloto piloto del cual veremos la información
     * @return View con el objeto $piloto
     */
    public function show(Piloto $piloto)
    {
        return view('gestion.pilotos.show', compact('piloto'));
    }

    /**
     * Función para mostrar la vista que permite crear un 
     * registro de pilotos
     * 
     * @return View para crear un registro
     */
    public function create(): View
    {
        return view('gestion.pilotos.create');
    }

    /**
     * Función para crear un piloto y añadirlo en la base de datos desde
     * el cliente 
     * @param Request con la información introducida por usuario desde el cliente
     * @return RedirectResponse reedirige a la ficha del piloto recien creado o a errores si los hubiera 
     * habido en el proceso de guardado de la bd 
     */
    public function store(Request $request): RedirectResponse
    {
        //Validar los datos de la respuesta desde el cliente
        $request->validate([
            "nombre" => "required|max:50|unique:pilotos,nombre",
            "ataque" => "required|numeric|min:0",
            "aumento_ataque" => "required|numeric|min:0",
            "defensa" => "required|numeric|min:0",
            "aumento_defensa" => "required|numeric|min:0",
            "resistencia" => "required|numeric|min:0",
            "aumento_resistencia" => "required|numeric|min:0",
            "valor" => "required|numeric|min:0",
            "coste_nivel" => "required|numeric|min:0",
            "imagen" => "required|image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);
        try {
            $piloto = $this->crearPiloto($request);
        } catch (\Exception $e) {
           return View('errors.500');
        }
        return redirect()->route('verPiloto', compact('piloto'));
    }

    /**
     * Función que permite actualizar desde el cliente los datos de la ficha de un piloto
     * 
     * @param Request información introducida por el usuario desde el cliente
     * @param Piloto objeto piloto que se modificara
     * 
     */
    public function update(Request $request, Piloto $piloto)
    {
        //Validaciones
        $request->validate([
            'nombre' => [Rule::unique('pilotos')->ignore($piloto)],
            "ataque" => "required|numeric|min:0",
            "aumento_ataque" => "required|numeric|min:0",
            "defensa" => "required|numeric|min:0",
            "aumento_defensa" => "required|numeric|min:0",
            "resistencia" => "required|numeric|min:0",
            "aumento_resistencia" => "required|numeric|min:0",
            "valor" => "required|numeric|min:0",
            "coste_nivel" => "required|numeric|min:0"
        ]);
        try {
            $piloto->update($request->all());
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                $fileName = $request->nombre . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('imgBD/pilotos'), $fileName);
                $piloto->imagen = 'imgBD/pilotos/' . $fileName;
            }
            $piloto->save();
        } catch (\Exception $e) {
           return View('errors.500');
        }
        return redirect()->route('listaPilotos')->with('success', 'Piloto updated successfully');
    }


    /**
     * ///// Métodos privados ///////
     */

    /**
     * Metodo privado que gestiona la creación de un piloto a traves de un 
     * objeto Request que llega desde el cliente
     * @param Request 
     * @return Piloto objeto piloto recién creado
     */
    private function crearPiloto(Request $request): Piloto
    {
        $piloto = new Piloto();
        $piloto->nombre = $request->nombre;
        $piloto->ataque = $request->ataque;
        $piloto->aumento_ataque = $request->aumento_ataque;
        $piloto->defensa = $request->defensa;
        $piloto->aumento_defensa = $request->aumento_defensa;
        $piloto->resistencia = $request->resistencia;
        $piloto->aumento_resistencia = $request->aumento_resistencia;
        $piloto->valor = $request->valor;
        $piloto->coste_nivel = $request->coste_nivel;

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $fileName = $request->nombre . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('imgBD/pilotos'), $fileName);
            $piloto->imagen = 'imgBD/pilotos/' . $fileName;
        }
        $piloto->save();

        return $piloto;
    }
}
