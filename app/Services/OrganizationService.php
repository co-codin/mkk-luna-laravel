<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationService
{
    public function getByBuilding(int $buildingId)
    {
        return Organization::with(['phones', 'activities'])
            ->where('building_id', $buildingId)
            ->get();
    }

    public function getByActivity(int $activityId)
    {
        $ids = Activity::getDescendantIds($activityId);

        return Organization::with(['phones', 'building'])
            ->whereHas('activities', fn ($q) => $q->whereIn('activities.id', $ids))
            ->get();
    }

    public function getNearby(Request $request)
    {
        $query = Organization::with(['building', 'phones', 'activities']);

        if ($request->filled(['lat', 'lng', 'radius'])) {
            [$lat, $lng, $radius] = [$request->lat, $request->lng, $request->radius];
            $query->whereHas('building', fn ($q) => $q->whereRaw(
                'ST_Distance_Sphere(point(longitude, latitude), point(?, ?)) < ?',
                [$lng, $lat, $radius]
            )
            );
        } elseif ($request->filled('bbox')) {
            $bbox = explode(',', $request->bbox);
            [$minLat, $minLng, $maxLat, $maxLng] = $bbox;
            $query->whereHas('building', fn ($q) => $q->whereBetween('latitude', [$minLat, $maxLat])
                ->whereBetween('longitude', [$minLng, $maxLng])
            );
        } else {
            throw new \InvalidArgumentException('Missing parameters');
        }

        return $query->get();
    }

    public function getById(int $id)
    {
        return Organization::with([
            'phones',
            'building',
            'activities' => fn ($q) => $q->with('parent.parent'),
        ])->findOrFail($id);
    }

    public function searchByActivity(int $activityId)
    {
        $ids = Activity::getDescendantIds($activityId);

        return Organization::with(['phones', 'building'])
            ->whereHas('activities', fn ($q) => $q->whereIn('activities.id', $ids))
            ->get();
    }

    public function searchByName(string $name)
    {
        return Organization::with(['phones', 'building', 'activities'])
            ->where('name', 'like', "%{$name}%")
            ->get();
    }
}
