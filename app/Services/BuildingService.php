<?php

namespace App\Services;

use App\Models\Building;

class BuildingService
{
    public function getAll()
    {
        return Building::all();
    }

    public function getById(int $id)
    {
        return Building::with('organizations.phones', 'organizations.activities')->findOrFail($id);
    }
}
