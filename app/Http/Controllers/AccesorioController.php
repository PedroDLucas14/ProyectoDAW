<?php

namespace App\Http\Controllers;

use App\Models\Accesorio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class AccesorioController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el crud de accesorio en formato tabla
     */
    public function index(Request $request)
    {
        try {
            $accesorios = Accesorio::paginate(5);

            //Comprobar filtros
            if ($request->isMethod('post')) {
                $accesorios = Accesorio::select('*')
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
                        return $query->resistencia($request->defensa, $request->operadorResistencia);
                    })
                    ->when($request->valorTotal !== null, function ($query) use ($request) {
                        return $query->valor($request->valorTotal, $request->operadorCreditos);
                    })
                    ->paginate(5);
            }
        } catch (\Exception $e) {
            return View('errors.500');
        }
        return view('gestion.accesorios.index', compact('accesorios'));
    }

    /**
     * Función para mostrar la vista que permite crear un 
     * registro de accesorio
     * 
     * @return View para crear un registro
     */
    public function create()
    {
        return view('gestion.accesorios.create');
    }


    /**
     * Función para crear un accesorio y añadirlo en la base de datos desde
     * el cliente 
     * 
     * @param Request con la información introducida por usuario desde el cliente
     * @return RedirectResponse reedirige a la ficha de la accesorio recien creado o a errores si los hubiera 
     * habido en el proceso de guardado de la bd 
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => "required|max:50|unique:accesorios,nombre",
            'descripcion' => 'required|max:200',
            'ataque' => 'nullable|numeric|min:0',
            'aumento_ataque' => 'nullable|numeric|min:0',
            'defensa' => 'nullable|numeric|min:0',
            'aumento_defensa' => 'nullable|numeric|min:0',
            'resistencia' => 'nullable|numeric|min:0',
            'aumento_resistencia' => 'nullable|numeric|min:0',
            "valor" => "required|numeric|min:0",
            "coste_nivel" => "required|numeric|min:0",
            'imagen' => "required|image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);

        try {
            $accesorio = $this->crearAccesorio($request);
        } catch (\Exception $e) {
            return View('errors.500');
        }
        return redirect()->route('verAccesorio', compact('accesorio'));
    }

    /**
     * Función que devuelve la vista con 
     * la ficha de un accesorio
     * @param Accesorio
     */
    public function show(Accesorio $accesorio)
    {
        try {
            return view('gestion.accesorios.show', compact('accesorio'));
        } catch (\Exception $e) {
            return redirect()->route('errores.error')->with('mensaje', "Página no encontrada");
        }
    }


    /**
     * Función que permite actualizar desde el cliente los datos de la ficha de un Accesorio
     * 
     * @param Request información introducida por el usuario desde el cliente
     * @param Accesorio objeto Accesorio que se modificara
     * 
     */
    public function update(Request $request, Accesorio $accesorio)
    {
        $request->validate([
            'nombre' => [Rule::unique('accesorio')->ignore($accesorio)],
            'descripcion' => 'required|max:200',
            "ataque" => "nullable|numeric|min:0",
            "aumento_ataque" => "nullable|numeric|min:0",
            "defensa" => "nullable|numeric|min:0",
            "aumento_defensa" => "nullable|numeric|min:0",
            "resistencia" => "nullable|numeric|min:0",
            "aumento_resistencia" => "nullable|numeric|min:0",
            "valor" => "required|numeric|min:0",
            "coste_nivel" => "required|numeric|min:0",
            "imagen" => "required|image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);
    }


  
    /**
     * ///// Métodos privados ///////
     */

    /**
     * Metodo privado que gestiona la creación de un Accesorio a traves de un 
     * objeto Request que llega desde el cliente
     * @param Request 
     * @return Accesorio objeto Accesorio recién creado
     */
    private function crearAccesorio(Request $request)
    {
        $accesorio = new Accesorio();
        $accesorio->nombre = $request->nombre;
        $accesorio->ataque = $request->ataque;
        $accesorio->aumento_ataque = $request->aumento_ataque;
        $accesorio->defensa = $request->defensa;
        $accesorio->aumento_defensa = $request->aumento_defensa;
        $accesorio->resistencia = $request->resistencia;
        $accesorio->aumento_resistencia = $request->aumento_resistencia;
        $accesorio->valor = $request->valor;
        $accesorio->coste_nivel = $request->coste_nivel;

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $fileName = $request->nombre . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('imgBD/accesorio'), $fileName);
            $accesorio->imagen = 'imgBD/accesorio/' . $fileName;
        }
        $accesorio->save();
        return $accesorio;
    }
}
