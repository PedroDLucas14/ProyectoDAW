<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * Class RegistroBatalla
 * 
 * Contiene la información relacionada con la tabla registro_batalla de 
 * la base de datos 
 * 
 * @property int $cod_registro_batalla
 * @property int $cod_usuario
 * @property int $cod_batalla
 * @property int $cod_usuario_nave
 * @property int $cod_usuario_piloto
 *
 * @property Batalla $batalla
 * @property UsuariosPiloto $usuario_piloto
 * @property UsuariosNave $usuario_nave
 * @property Usuario $usuario
 * @property int $turno_actual
 * @property bool $vista_completa
 * @property Collection|AccesorioRegistroBatalla[] $accesorio_registro_batallas
 * @property Collection|LogBatalla[] $log_batallas
 *
 * @package App\Models
 */
class RegistroBatalla extends Model
{
	protected $table = 'registro_batalla';
	protected $primaryKey = 'cod_registro_batalla';
	public $timestamps = false;

	protected $casts = [
		'cod_usuario' => 'int',
		'cod_batalla' => 'int',
		'cod_usuario_nave' => 'int',
		'cod_usuario_piloto' => 'int',
		'turno_actual' => 'int',
		'vista_completa' => 'bool'
	];

	protected $fillable = [
		'cod_usuario',
		'cod_batalla',
		'cod_usuario_nave',
		'cod_usuario_piloto',
		'turno_actual',
		'vista_completa'
	];

	/**
	 * Accede a la información relacioanda con la batalla con el cod_batalla
	 */
	public function batalla()
	{
		return $this->belongsTo(Batalla::class, 'cod_batalla');
	}
	/**
	 * Accede a la información relacioanda con el usuario_piloto con el cod_usuario_piloto
	 */
	public function usuario_piloto()
	{
		return $this->belongsTo(UsuariosPiloto::class, 'cod_usuario_piloto');
	}
	/**
	 * Accede a la información relacioanda con el usuario_nave con el cod_usuario_nave
	 */
	public function usuario_nave()
	{
		return $this->belongsTo(UsuariosNave::class, 'cod_usuario_nave');
	}
	/**
	 * Accede a la información relacioanda con el usuario con el cod_usuario
	 */
	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'cod_usuario');
	}
	/**
	 * Accede a la información relacioanda con el accesorio_registro_batallas con el cod_registro_batalla
	 */
	public function accesorio_registro_batallas()
	{
		return $this->hasMany(AccesorioRegistroBatalla::class, 'cod_registro_batalla');
	}
	/**
	 * Accede a la información relacioanda con el log_batallas con el cod_registro_batalla
	 */
	public function log_batallas()
	{
		return $this->hasMany(LogBatalla::class, 'cod_registro_batalla');
	}

	/**
	 * Función que calcula la resistencia total de un jugador
	 * para una determinada batalla
	 * @return int Total de resistencia
	 */
	public function totalResistencia(): int
	{

		$resTotal = 0;
		$resTotal += $this->usuario_nave->resistencia_actual;
		$resTotal += $this->usuario_piloto->resistencia_actual;
		foreach ($this->accesorio_registro_batallas as $accesorio) {
			if ($accesorio->usuarios_accesorio->resistencia_actual != null) {
				$resTotal += $accesorio->usuarios_accesorio->resistencia_actual;
			}
		}

		return $resTotal;
	}

	/**
	 * Función que calcula el ataque total de un jugador
	 * para una determinada batalla
	 * @return int Total de ataque
	 */
	public function totalAtaque(): int
	{
		$ataTotal = 0;
		$ataTotal += $this->usuario_nave->ataque_actual;
		$ataTotal += $this->usuario_piloto->ataque_actual;
		foreach ($this->accesorio_registro_batallas as $accesorio) {
			if ($accesorio->usuarios_accesorio->ataque_actual != null) {
				$ataTotal += $accesorio->usuarios_accesorio->ataque_actual;
			}
		}

		return $ataTotal;
	}

	/**
	 * Función que calcula la defensa total de un jugador
	 * para una determinada batalla
	 * @return int Total de defensa
	 */
	public function totalDefensa(): int
	{
		$defTotal = 0;
		$defTotal += $this->usuario_nave->defensa_actual;
		$defTotal += $this->usuario_piloto->defensa_actual;
		foreach ($this->accesorio_registro_batallas as $accesorio) {
			if ($accesorio->usuarios_accesorio->defensa_actual != null) {
				$defTotal += $accesorio->usuarios_accesorio->defensa_actual;
			}
		}
		return $defTotal;
	}
}
