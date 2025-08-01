<?php

namespace App\Http\Controllers;

use App\Http\Resources\BuildingCollection;
use App\Http\Resources\BuildingResource;
use App\Models\Building;
use App\Services\BuildingService;

class BuildingController extends Controller
{
    public function __construct(
        protected BuildingService $service
    ) {}

    /**
     * @OA\Get(
     *   path="/api/buildings",
     *   tags={"Buildings"},
     *   summary="Get all buildings",
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/BuildingCollection")),
     *   security={{"api_key":{}}}
     * )
     */
    public function index()
    {
        return new BuildingCollection($this->service->getAll());
    }

    /**
     * @OA\Get(
     *   path="/api/buildings/{id}",
     *   tags={"Buildings"},
     *   summary="Get building by ID",
     *
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/BuildingResource")),
     *   security={{"api_key":{}}}
     * )
     */
    public function show(int $id)
    {
        return new BuildingResource($this->service->getById($id));
    }
}
