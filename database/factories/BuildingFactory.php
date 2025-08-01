<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingFactory extends Factory
{
    protected $model = Building::class;

    public function definition()
    {
        return [
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(55, 56),
            'longitude' => $this->faker->longitude(37, 38),
        ];
    }
}
