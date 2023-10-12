<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsuariosPiloto
 *
 * Contiene la información relacionada con la tabla usuarios_naves de 
 * la base de datos 
 * 
 * @property int $cod_usuario_piloto
 * @property int $cod_usuario
 * @property int $cod_piloto
 * @property int $ataque_actual
 * @property int $defensa_actual
 * @property int $resistencia_actual
 * @property int $nivel
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UsuariosPiloto extends Model
{
    protected $table = 'usuarios_pilotos';
    protected $primaryKey = 'cod_usuario_piloto';

    protected $casts = [
        'cod_usuario' => 'int',
        'cod_piloto' => 'int',
        'ataque_actual' => 'int',
        'defensa_actual' => 'int',
        'resistencia_actual' => 'int',
        'nivel' => 'int'
    ];

    protected $fillable = [
        'cod_usuario',
        'cod_piloto',
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
     * Accede a la información del usuario relacioando por el cod_piloto
     */
    public function piloto()
    {
        return $this->belongsTo(Piloto::class, 'cod_piloto');
    }
    /**
     * Accede al registro batalla relacioado con usuario_piloto relaciodo
     * por el cod_usuario_piloto
     */
    public function registro_batallas()
    {
        return $this->hasMany(RegistroBatalla::class, 'cod_usuario_piloto');
    }
    /**
     * Método para subir de nivel piloto asociado a un usuario
     * @param int $cod_usuario_piloto
     * @return boolean True si ha reliazado todos los cambios con exito
     *                 Falso si no se ha encontrado la linea en la BD
     */
    public static function subirNivel(int $cod_usuario_piloto, int $niveles = 1): bool
    {
        $usuarioPiloto = UsuariosPiloto::find($cod_usuario_piloto);
        $costeMejora = $usuarioPiloto->piloto->coste_nivel;
        if ($usuarioPiloto === null) {
            return false;
        }
        if ($niveles != 1) {
            $costeMejora *= $niveles;
        }
        //Comprobar si el usuario tiene creditos para relaizar la mejora
        if ($usuarioPiloto->usuario->creditos < $costeMejora) {
            return false;
        }
        $usuarioPiloto->nivel += $niveles;
        $usuarioPiloto->save();
        if ($usuarioPiloto->piloto->aumento_defensa != null) {
            $usuarioPiloto->defensa_actual = ($usuarioPiloto->piloto->defensa + ($niveles * $usuarioPiloto->piloto->aumento_defensa));
        }
        if ($usuarioPiloto->piloto->aumento_ataque != null) {
            $usuarioPiloto->ataque_actual = ($usuarioPiloto->piloto->ataque + ($niveles * $usuarioPiloto->piloto->aumento_ataque));
        }
        if ($usuarioPiloto->piloto->aumento_resistencia != null) {
            $usuarioPiloto->resistencia_actual = ($usuarioPiloto->piloto->resistencia + ($niveles * $usuarioPiloto->piloto->aumento_resistencia));
        }
        $usuarioPiloto->save();
        //actualizar creditos del jugador
        $usuarioPiloto->usuario->creditos -= $costeMejora;
        $usuarioPiloto->usuario->save();
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
    public function comprarPiloto(int $cod_piloto, int $cod_jugador): bool
    {
        $piloto = Piloto::find($cod_piloto);
        $jugador = Usuario::find($cod_jugador);

        if ($piloto === null || $jugador === null) {
            return false;
        }
        //Comprobar si se puede comprar el piloto con los creditos del jugador
        if ($piloto->valor > $jugador->creditos) {
            return false;
        }
        $this->cod_usuario = $jugador->cod_usuario;
        $this->cod_piloto = $piloto->cod_piloto;
        $this->ataque_actual = $piloto->ataque;
        $this->defensa_actual = $piloto->defensa;
        $this->resistencia_actual = $piloto->resistencia;
        $this->nivel = 1;
        $this->save();

        //actualizar creditos del jugador
        $jugador->creditos -= $piloto->valor;
        $jugador->save();
        return $this->cod_usuario_piloto ? true : false;
    }
}
