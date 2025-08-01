<?php

namespace App\Services;

use App\Models\Activity;

class ActivityService
{
    public function getAll()
    {
        return Activity::with('children')->get();
    }

    public function getById(int $id)
    {
        return Activity::with('children')->findOrFail($id);
    }
}
