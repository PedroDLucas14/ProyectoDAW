<?php

namespace Database\Factories;

use App\Models\Usuarios;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuarios>
 */
class UsuariosFactory extends Factory
{

    protected $model=Usuarios::class;
    /**
     *  Define los valores de ejemplo de 
     * la base de datos
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $victorias=$this->faker->randomNumber(2);
        $derrotas=$this->faker->randomNumber(2);
        $puntos=($victorias*100)-($derrotas*50);
        return [
            'nick'=>$this->faker->unique()->name(),
            'fecha_nacimiento'=>$this->faker->dateTimeBetween('-30 year','-18 year'),
            'email'=>$this->faker->unique()->email(),
            'creditos'=>$this->faker->randomNumber(5,true),
            'victorias'=>$victorias,
            'derrotas'=>$derrotas,
            'puntos'=>($puntos<0?0:$puntos)
        ];
    }
}
