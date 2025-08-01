<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BuildingCollection extends ResourceCollection
{
    public $collects = BuildingResource::class;
}
