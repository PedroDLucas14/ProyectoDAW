<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AccesorioRegistroBatalla
 * Contiene la información relacionada con la tabla accesorios_registro_batalla de 
 * la base de datos 
 * 
 * @property int $cod_accesorio_registro_batalla
 * @property int $cod_registro_batalla
 * @property int $cod_usuario_accesorio
 * 
 * @property UsuariosAccesorio $usuarios_accesorio
 * @property RegistroBatalla $registro_batalla
 *
 * @package App\Models
 */
class AccesorioRegistroBatalla extends Model
{
	protected $table = 'accesorio_registro_batalla';
	protected $primaryKey = 'cod_accesorio_registro_batalla';
	public $timestamps = false;

	protected $casts = [
		'cod_registro_batalla' => 'int',
		'cod_usuario_accesorio' => 'int'
	];

	protected $fillable = [
		'cod_registro_batalla',
		'cod_usuario_accesorio'
	];

	/**
	 * Accede a la tabla usuarios_accesorio con el cod_usuario_accesorio
	 */
	public function usuarios_accesorio()
	{
		return $this->belongsTo(UsuariosAccesorio::class, 'cod_usuario_accesorio');
	}
	/**
	 * Accede a la tabla registro_batalla con el cod_registro_batalla
	 */
	public function registro_batalla()
	{
		return $this->belongsTo(RegistroBatalla::class, 'cod_registro_batalla');
	}
}
