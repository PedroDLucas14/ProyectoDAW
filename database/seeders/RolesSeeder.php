<?php

namespace Database\Seeders;

use App\Models\acl_roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $rol = new acl_roles();
        $rol->nombre = 'administrador';
        $rol->perm1 = true;
        $rol->perm2 = true;
        $rol->save();

        $rol2 = new acl_roles();
        $rol2->nombre = 'jugador';
        $rol2->perm5 = true;
        $rol2->perm6 = true;
        $rol2->save();

        $rol3 = new acl_roles();
        $rol3->nombre = 'mantenimiento';
        $rol3->perm3 = true;
        $rol3->perm4 = true;
        $rol3->save();
    }
}
