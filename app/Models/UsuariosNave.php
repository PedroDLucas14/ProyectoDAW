<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UsuariosNave
 *
 * Contiene la información relacionada con la tabla usuarios_naves de 
 * la base de datos 
 * 
 * @property int $cod_usuario_nave
 * @property int $cod_usuario
 * @property int $cod_nave
 * @property int|null $ataque_actual
 * @property int|null $defensa_actual
 * @property int|null $resistencia_actual
 * @property int $nivel
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Nave $nave
 * @property Usuario $usuario
 * @property Collection|RegistroBatalla[] $registro_batallas
 * @package App\Models
 */
class UsuariosNave extends Model
{
    protected $table = 'usuarios_naves';
    protected $primaryKey = 'cod_usuario_nave';

    protected $casts = [
        'cod_usuario' => 'int',
        'cod_nave' => 'int',
        'ataque_actual' => 'int',
        'defensa_actual' => 'int',
        'resistencia_actual' => 'int',
        'nivel' => 'int'
    ];

    protected $fillable = [
        'cod_usuario',
        'cod_nave',
        'ataque_actual',
        'defensa_actual',
        'resistencia_actual',
        'nivel'
    ];

    /**
     * Accede a la información de usuario relaciodo por el cod_usuaurio
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario');
    }
    /**
     * Accede a la información del usuario relacioando por el cod_nave
     */
    public function nave()
    {
        return $this->belongsTo(Nave::class, 'cod_nave');
    }
    /**
     * Accede al registro batalla relacioado con usuario_nave relaciodo
     * por el cod_usuario_nave
     */
    public function registro_batallas()
    {
        return $this->hasMany(RegistroBatalla::class, 'cod_usuario_nave');
    }

    /**
     * Método para subir de nivel nave asociada a un usuario
     * @param int $cod_uusario_nave
     * @param int niveles=1
     * @return boolean True si ha reliazado todos los cambios con exito
     *                 Falso si no se ha encontrado la linea en la BD
     */
    public static function subirNiveles(int $cod_usuario_nave, int $niveles = 1): bool
    {
        $usuarioNave = UsuariosNave::find($cod_usuario_nave);
        $costeMejora = $usuarioNave->nave->coste_nivel;
        if ($usuarioNave === null) {
            return false;
        }
        if ($niveles != 1) {
            $costeMejora *= $niveles;
        }
        //Comprobar si el usuario tiene creditos para relaizar la mejora
        if ($usuarioNave->usuario->creditos < $costeMejora) {
            return false;
        }
        $usuarioNave->nivel += $niveles;
        $usuarioNave->save();
        if ($usuarioNave->nave->aumento_defensa != null) {
            $usuarioNave->defensa_actual = ($usuarioNave->nave->defensa + ($niveles * $usuarioNave->nave->aumento_defensa));
        }
        if ($usuarioNave->nave->aumento_ataque != null) {
            $usuarioNave->ataque_actual = ($usuarioNave->nave->ataque + ($niveles * $usuarioNave->nave->aumento_ataque));
        }
        $usuarioNave->resistencia_actual = ($usuarioNave->nave->resistencia + ($niveles * $usuarioNave->nave->aumento_resistencia));
        $usuarioNave->save();
        //Coste mejoras
        $usuarioNave->usuario->creditos -= $costeMejora;
        $usuarioNave->usuario->save();
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
     */
    public function comprarNave(int $cod_nave, int $cod_jugador): bool|int
    {

        $nave = Nave::find($cod_nave);
        $jugador = Usuario::find($cod_jugador);

        if ($nave === null || $jugador === null) {
            return false;
        }
        //Comprobar si se puede comprar el piloto con los creditos del jugador
        if ($nave->valor > $jugador->creditos) {
            return false;
        }
        $this->cod_nave = $nave->cod_nave;
        $this->cod_usuario = $jugador->cod_usuario;
        $this->ataque_actual = $nave->ataque;
        $this->defensa_actual = $nave->defensa;
        $this->resistencia_actual = $nave->resistencia;
        $this->nivel = 1;
        $this->save();

        //actualizar creditos del jugador
        $jugador->creditos -= $nave->valor;
        $jugador->save();

        return $this->cod_usuario_nave;
    }
}
