<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AclUsuario;
use App\Models\Usuario;
use Illuminate\View\View;

/**
 * Controlador que controla las acciones para la gestión
 * de la aplicación
 */
class GestionController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
     * Funcion que muestra la vista con la pantalla principal de 
     * la gestión
     * 
     * @param Request
     * @return View
     */
    public function gestion(Request $request):View
    {
        try {
            $acl = new AclUsuario();
            $usuarios = Usuario::paginate(5);

            if ($request->isMethod('post')) {
                $usuarios = Usuario::nick($request->nick)
                    ->email($request->email)
                    ->paginate(5);
            }
        } catch (\Exception $e) {
            return View('errors.500');
        }
        return view('gestion.gestion', compact('usuarios', 'acl'));
    }

    /**
     * Función que muestra la vista de gestión del inventario
     * @param Request 
     * @return View 
     */
    public function gestionInvetario(Request $request):View
    {
        try {
            $acl = new AclUsuario();
            $usuarios = Usuario::paginate(5);
            $datosFiltrados=[];
            if ($request->isMethod('post')) {
                $usuarios = Usuario::nick($request->nick)
                    ->paginate(5);
                $datosFiltrados["nick"]=$request->nick;
            }

        } catch (\Exception $e) {
        }
        return view('gestion.inventario.index', compact('usuarios', 'acl','datosFiltrados'));
    }
}
