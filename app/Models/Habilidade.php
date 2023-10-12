<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Habilidade
 * Contiene la información relacionada con la tabla habilidades de 
 * la base de datos 
 * 
 * @property int $cod_habilidad
 * @property string $nombre
 * @property string $descripcion
 * @property int $cod_piloto
 * @property string $atributo
 * @property int $cantidad
 * @property int|null $tiempo_duracion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Piloto $piloto
 *
 * @package App\Models
 */
class Habilidade extends Model
{
	protected $table = 'habilidades';
	protected $primaryKey = 'cod_habilidad';

	protected $casts = [
		'cod_piloto' => 'int',
		'cantidad' => 'int',
		'tiempo_duracion' => 'int'
	];

	protected $fillable = [
		'nombre',
		'descripcion',
		'cod_piloto',
		'atributo',
		'cantidad',
		'tiempo_duracion'
	];
	/**
	 * Accede a la información de un piloto relacionado por el cod_piloto
	 */
	public function piloto()
	{
		return $this->belongsTo(Piloto::class, 'cod_piloto');
	}
}
