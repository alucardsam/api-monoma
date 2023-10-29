<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Candidato;
use App\Models\Usuario;

class CandidatoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidato::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'source' => $this->faker->word,
            'owner' => Usuario::factory(),
            'created_by' => Usuario::factory(),
        ];
    }
}
