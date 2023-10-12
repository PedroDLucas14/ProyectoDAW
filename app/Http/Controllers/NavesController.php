<?php

namespace App\Http\Controllers;

use App\Models\Nave;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;


/**
 * Controlador para naves
 */
class NavesController extends Controller
{
    /**
     * Constructor
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el crud de naves en formato tabla
     */
    public function index(Request $request): View
    {
        try {
            $naves = Nave::paginate(5);

            //Comprobar filtros
            if ($request->isMethod('post')) {
                $naves = Nave::select('*')
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
        return view('gestion.naves.index', compact('naves'));
    }

    /**
     * Función para mostrar la vista que permite crear un 
     * registro de naves
     * 
     * @return View para crear un registro
     */
    public function create(): View
    {
        return view('gestion.naves.create');
    }

    /**
     * Función para crear una nave y añadirlo en la base de datos desde
     * el cliente 
     * @param Request con la información introducida por usuario desde el cliente
     * @return RedirectResponse reedirige a la ficha de la nave recien creado o a errores si los hubiera 
     * habido en el proceso de guardado de la bd 
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'nombre' => "required|max:50|unique:naves,nombre",
            'ataque' => 'required|numeric|min:0',
            'aumento_ataque' => 'required|numeric|min:0',
            'defensa' => 'required|numeric|min:0',
            'aumento_defensa' => 'required|numeric|min:0',
            'resistencia' => 'required|numeric|min:0',
            'aumento_resistencia' => 'required|numeric|min:0',
            'num_accesorios' => 'required|numeric|min:0',
            "valor" => "required|numeric|min:0",
            "coste_nivel" => "required|numeric|min:0",
            'imagen' => "required|image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);
        try {
            $nave = $this->creaNave($request);
        } catch (\Exception $e) {
            return View('errors.500');
        }
        return redirect()->route('verNave', compact('nave'));
    }

    /**
     * Función para mostrar la ficha de un naves
     * @param Nave nave del cual veremos la información
     * @return View con el objeto $nave
     */
    public function show(Nave $nave): View
    {
        try {
            return view('gestion.naves.show', compact('nave'));
        } catch (\Exception $e) {
            return View('errors.500');
        }
    }

    /**
     * Función que permite actualizar desde el cliente los datos de la ficha de una nave
     * 
     * @param Request información introducida por el usuario desde el cliente
     * @param Nave objeto nave que se modificará
     * 
     */
    public function update(Request $request, Nave $nave): RedirectResponse
    {
        $request->validate([
            'nombre' => [Rule::unique('naves')->ignore($nave)],
            'ataque' => 'required|numeric|min:0',
            'aumento_ataque' => 'required|numeric|min:0',
            'defensa' => 'required|numeric|min:0',
            'aumento_defensa' => 'required|numeric|min:0',
            'resistencia' => 'required|numeric|min:0',
            'aumento_resistencia' => 'required|numeric|min:0',
            "valor" => "required|numeric|min:0",
            "coste_nivel" => "required|numeric|min:0",
            'num_accesorios' => 'required|numeric|min:0',
        ]);
        try {

            $nave->update($request->all());
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                $fileName = $request->nombre . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('imgBD/naves'), $fileName);
                $nave->imagen = 'imgBD/naves/' . $fileName;
            }
            $nave->save();
        } catch (\Exception $e) {
            return View('errors.500');
        }

        return redirect()->route('listaNaves')->with('success', 'Nave updated successfully');
    }



    /**
     * ///// Métodos privados ///////
     */

    /**
     * Metodo privado que gestiona la creación de un nave a traves de un 
     * objeto Request que llega desde el cliente
     * @param Request 
     * @return nave objeto nave recién creado
     */
    private function creaNave(Request $request)
    {
        $naves = new Nave();
        $naves->nombre = $request->nombre;
        $naves->ataque = $request->ataque;
        $naves->aumento_ataque = $request->aumento_ataque;
        $naves->defensa = $request->defensa;
        $naves->aumento_defensa = $request->aumento_defensa;
        $naves->resistencia = $request->resistencia;
        $naves->aumento_resistencia = $request->aumento_resistencia;
        $naves->valor = $request->valor;
        $naves->coste_nivel = $request->coste_nivel;

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $fileName = $request->nombre . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('imgBD/naves'), $fileName);
            $naves->imagen = 'imgBD/naves/' . $fileName;
        }
        $naves->save();
        return $naves;
    }
}
