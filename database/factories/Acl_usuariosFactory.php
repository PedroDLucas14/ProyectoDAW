<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\acl_usuarios>
 */
class acl_usuariosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nick'=>$this->faker->unique()->userName(),
            'nombre'=>$this->faker->name(),
            'email'=>$this->faker->unique()->email(),
            'password'=>$this->faker->password(),
            'cod_acl_role'=>2
        ];
    }
}
