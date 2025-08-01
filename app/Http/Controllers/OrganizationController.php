<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Building;

class OrganizationController extends Controller
{
    public function byBuilding(Building $building)
    {
        return $building->organizations()->with(['phones', 'activities'])->get();
    }

    public function byActivity(Activity $activity)
    {
        return $activity->organizations()->with(['phones', 'building'])->get();
    }
}
