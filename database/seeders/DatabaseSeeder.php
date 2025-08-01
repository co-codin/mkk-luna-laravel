<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Models\Phone;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Building::factory()->count(5)->create();

        $food = Activity::factory()->create(['name' => 'Еда']);
        $meat = Activity::factory()->create(['name' => 'Мясная продукция', 'parent_id' => $food->id]);
        $dairy = Activity::factory()->create(['name' => 'Молочная продукция', 'parent_id' => $food->id]);
        $automobile = Activity::factory()->create(['name' => 'Автомобили']);
        $cargo = Activity::factory()->create(['name' => 'Грузовые', 'parent_id' => $automobile->id]);
        $pass = Activity::factory()->create(['name' => 'Легковые', 'parent_id' => $automobile->id]);

        Organization::factory()->count(10)->create()->each(function ($org) use ($meat, $dairy, $cargo, $pass) {
            $org->activities()->attach([$meat->id, $dairy->id, $cargo->id, $pass->id]);
            Phone::factory()->count(2)->create(['organization_id' => $org->id]);
        });
    }
}
