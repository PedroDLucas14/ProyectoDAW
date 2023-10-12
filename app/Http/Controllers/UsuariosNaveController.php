<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\UsuariosNave;
use Illuminate\Http\Request;

class UsuariosNaveController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Usuario $usuario)
    {
        try {
            $naves = UsuariosNave::where('cod_usuario', '=', $usuario->cod_usuario)->paginate(5);
        } catch (\Exception $e) {
            return View('errors.500');
        }
        return view('gestion.inventario.naves.index', compact('naves', 'usuario'));
    }

    /**
     * Muestra la vista con la informacion de una nave perteneciente al usuario
     * 
     * @param Usuario $usuario
     * @param UsuariosNave $usuariosNave
     */
    public function show(Usuario $usuario, UsuariosNave $usuariosNave)
    {
        return view('gestion.inventario.naves.show', compact('usuariosNave', 'usuario'));
    }



}
