<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\UsuariosPiloto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UsuariosPilotoController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Usuario $usuario): View
    {
        try {
            $pilotos = UsuariosPiloto::where('cod_usuario', '=', $usuario->cod_usuario)->paginate(5);
        } catch (\Exception $e) {
            return View('errors.500');
        }

        return view('gestion.inventario.pilotos.index', compact('pilotos', 'usuario'));
    }

   /**
     * Muestra la vista con la informacion de un piloto perteneciente al usuario
     * 
     * @param Usuario $usuario
     * @param UsuariosPiloto $usuarioPiloto
     */
    public function show(Usuario $usuario, UsuariosPiloto $usuarioPiloto)
    {
        return view('gestion.inventario.pilotos.show', compact('usuarioPiloto', 'usuario'));
    }
}
