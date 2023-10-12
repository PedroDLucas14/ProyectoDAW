<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsuariosAccesorio
 *
 * Contiene la información relacionada con la tabla usuarios_accesorios de 
 * la base de datos 
 * 
 * @property int $cod_usuario_accesorio
 * @property int $cod_usuario
 * @property int $cod_accesorio
 * @property null|int $ataque_actual
 * @property null|int $defensa_actual
 * @property null|int $resistencia_actual
 * @property int $nivel
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Accesorio $accesorio
 * @property Usuario $usuario
 * @property Collection|AccesorioRegistroBatalla[] $accesorio_registro_batallas
 *
 * @package App\Models
 */
class UsuariosAccesorio extends Model
{
    protected $table = 'usuarios_accesorios';
    protected $primaryKey = 'cod_usuario_accesorio';

    protected $casts = [
        'cod_usuario' => 'int',
        'cod_accesorio' => 'int',
        'ataque_actual' => 'int',
        'defensa_actual' => 'int',
        'resistencia_actual' => 'int',
        'nivel' => 'int'
    ];

    protected $fillable = [
        'cod_usuario',
        'cod_accesorio',
        'ataque_actual',
        'defensa_actual',
        'resistencia_actual',
        'nivel'
    ];

    /**
     * Accede a la información del usuario relacioando por el cod_accesorio
     */
    public function accesorio()
    {
        return $this->belongsTo(Accesorio::class, 'cod_accesorio');
    }

    /**
     * Accede a la información de usuario relaciodo por el cod_usuaurio
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario');
    }

    /**
     * Accede al registro batalla relacioado con usuario_accesorio relaciodo
     * por el cod_accesorio_usuario
     */
    public function accesorio_registro_batallas()
    {
        return $this->hasMany(AccesorioRegistroBatalla::class, 'cod_accesorio_usuario');
    }


    /**
     * Método para subir de nivel accesorio asociado a un usuario
     * @param int $cod_usuario_accesorio
     * @return boolean True si ha reliazado todos los cambios con exito
     *                 Falso si no se ha encontrado la linea en la BD
     */
    static function subirNivel(int $cod_usuario_accesorio, int $niveles = 1)
    {
        $usuarioAccesorio = UsuariosAccesorio::find($cod_usuario_accesorio);
        $costeMejora = $usuarioAccesorio->accesorio->coste_nivel;
        if ($usuarioAccesorio === null) {
            return false;
        }
        if ($niveles != 1) {
            $costeMejora += $niveles;
        }
        //Comprobar si el usuario tiene creditos para relaizar la mejora
        if ($usuarioAccesorio->usuario->creditos < $costeMejora) {
            return false;
        }
        $usuarioAccesorio->nivel += $niveles;
        $usuarioAccesorio->save();
        if ($usuarioAccesorio->accesorio->aumento_defensa != null) {
            $usuarioAccesorio->defensa_actual = ($usuarioAccesorio->accesorio->defensa + ($niveles * $usuarioAccesorio->accesorio->aumento_defensa));
        }
        if ($usuarioAccesorio->accesorio->aumento_ataque != null) {
            $usuarioAccesorio->ataque_actual = ($usuarioAccesorio->accesorio->ataque + ($niveles * $usuarioAccesorio->accesorio->aumento_ataque));
        }
        if ($usuarioAccesorio->accesorio->aumento_resistencia != null) {
            $usuarioAccesorio->resistencia_actual = ($usuarioAccesorio->accesorio->resistencia + ($niveles * $usuarioAccesorio->accesorio->aumento_resistencia));
        }
        $usuarioAccesorio->save();
        //actualizar creditos del jugador
        $usuarioAccesorio->usuario->creditos -= $costeMejora;
        $usuarioAccesorio->usuario->save();
        return true;
    }

    /**
     * Método para añadir un piloto a la lista de piltos del jugador
     *
     * @param int $cod_piltoo->cod del piloto que se comprarara
     * @param int $cod_jugador->cod del jugador que compra el piloto
     *
     * @return boolean true si ha realizado la compra correctamente sin fallos
     *                  false si hubo algún problema para insertar 
     *               
     */

    public function comprarAccesorio(int $cod_accesorio, int $cod_jugador): bool|int
    {
        $accesorio = Accesorio::find($cod_accesorio);
        $jugador = Usuario::find($cod_jugador);

        if ($accesorio === null || $jugador === null) {
            return false;
        }

        //Comprobar si se puede comprar el piloto con los creditos del jugador
        if ($accesorio->valor > $jugador->creditos) {
            return false;
        }
        //Comprobar si el jugador tiene creditos suficientes para comprar el accesorio
        $this->cod_accesorio = $accesorio->cod_accesorio;
        $this->cod_usuario = $jugador->cod_usuario;
        $this->ataque_actual = $accesorio->ataque;
        $this->defensa_actual = $accesorio->defensa;
        $this->resistencia_actual = $accesorio->resistencia;
        $this->nivel = 1;
        $this->save();

        //actualizar creditos del jugador
        $jugador->creditos -= $accesorio->valor;
        $jugador->save();
        return $this->cod_usuario_accesorio;
    }

}
