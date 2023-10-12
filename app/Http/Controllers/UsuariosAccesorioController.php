<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\UsuariosAccesorio;
use Illuminate\Http\Request;

/**
 * Controlador que gestiona los accesorios que 
 * poseen los usuarios
 */
class UsuariosAccesorioController extends Controller
{
    /**
     *  Muestra la vista con los accesorios del usuario
     * @param usuario $usuario Usuario propiatorio
     */
    public function index(Usuario $usuario)
    {
        try {
            $accesorios = UsuariosAccesorio::where('cod_usuario', '=', $usuario->cod_usuario)->paginate(5);
        } catch (\Exception $e) {
            return View('errors.500');
        }
        return view('gestion.inventario.accesorios.index', compact('accesorios', 'usuario'));
    }

    /**
     * Muestra la vista con la informacion de un accesorio perteneciente al usuario
     * 
     * @param Usuario $usuario
     * @param UsuariosAccesorio $UsuariosAccesorio
     */
    public function show(Usuario $usuario, UsuariosAccesorio $usuarioAccesorio)
    {
        return view('gestion.inventario.accesorios.show', compact('usuarioAccesorio', 'usuario'));
    }
}
