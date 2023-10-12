<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogBatalla
 * 
 * Contiene la información relacionada con la tabla log_batalla de 
 * la base de datos 
 * 
 * @property int $cod_log_batalla
 * @property int $cod_registro_batalla
 * @property int $turno
 * @property int $dado
 * @property string $efecto
 * @property int $resistencia_actual
 * @property int $ataque_actual
 * @property int $defensa_actual
 * @property bool $estado
 *
 * @property RegistroBatalla $registro_batalla
 *
 * @package App\Models
 */
class LogBatalla extends Model
{
	protected $table = 'log_batalla';
	protected $primaryKey = 'cod_log_batalla';
	public $timestamps = false;

	protected $casts = [
		'cod_registro_batalla' => 'int',
		'turno' => 'int',
		'dado' => 'int',
		'resistencia_actual' => 'int',
		'ataque_actual' => 'int',
		'defensa_actual' => 'int',
		'estado' => 'bool'
	];

	protected $fillable = [
		'cod_registro_batalla',
		'turno',
		'dado',
		'efecto',
		'resistencia_actual',
		'ataque_actual',
		'defensa_actual',
		'estado'
	];

	/**
	 * Accede al registro batalla relacionado con un log por el cod_registro_batalla
	 */
	public function registro_batalla()
	{
		return $this->belongsTo(RegistroBatalla::class, 'cod_registro_batalla');
	}
}
