<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AclRole
 * 
 * Contiene la información relacionada con la tabla acl_roles de 
 * la base de datos 
 * 
 * @property int $cod_acl_role
 * @property string $nombre
 * @property bool $perm1
 * @property bool $perm2
 * @property bool $perm3
 * @property bool $perm4
 * @property bool $perm5
 * @property bool $perm6
 * @property bool $perm7
 * @property bool $perm8
 * @property bool $perm9
 * @property bool $perm10
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|AclUsuario[] $acl_usuarios
 *
 * @package App\Models
 */
class AclRole extends Model
{
	protected $table = 'acl_roles';
	protected $primaryKey = 'cod_acl_role';

	protected $casts = [
		'perm1' => 'bool',
		'perm2' => 'bool',
		'perm3' => 'bool',
		'perm4' => 'bool',
		'perm5' => 'bool',
		'perm6' => 'bool',
		'perm7' => 'bool',
		'perm8' => 'bool',
		'perm9' => 'bool',
		'perm10' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'perm1',
		'perm2',
		'perm3',
		'perm4',
		'perm5',
		'perm6',
		'perm7',
		'perm8',
		'perm9',
		'perm10'
	];

    /**
     * Accede a la tabla acl_usuarios con el cod_acl_role que tiene
     * un usuario
     */
	public function acl_usuarios()
	{
		return $this->hasMany(AclUsuario::class, 'cod_acl_role');
	}

	/**
	 * Función estática que devuelve el cod_acl_role 
	 * de un rol 
	 * @param string role cadena que representa el nombre de del rol
	 * @return int|false int si encuentra la cadena y pertence al nombre de un rol
	 * 					false si no encuentra la cadena
	 */
	public static function dameCodRol(string $rol): int|false
	{
		$rolDb = self::all()->where("nombre", "=", $rol);
		if (count($rolDb)) {
			$rolDb = $rolDb->first();
			return $rolDb->cod_acl_role;
		}
		return false;
	}
}
