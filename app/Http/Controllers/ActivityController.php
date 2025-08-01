<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityCollection;
use App\Http\Resources\ActivityResource;
use App\Services\ActivityService;

/**
 * @OA\Tag(name="Activities")
 */
class ActivityController extends Controller
{
    public function __construct(protected ActivityService $service) {}

    /**
     * @OA\Get(
     *   path="/api/activities",
     *   tags={"Activities"},
     *   summary="Get all activities",
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/ActivityCollection")),
     *   security={{"api_key":{}}}
     * )
     */
    public function index()
    {
        return new ActivityCollection($this->service->getAll());
    }

    /**
     * @OA\Get(
     *   path="/api/activities/{id}",
     *   tags={"Activities"},
     *   summary="Get activity by ID",
     *
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/ActivityResource")),
     *   security={{"api_key":{}}}
     * )
     */
    public function show(int $id)
    {
        return new ActivityResource($this->service->getById($id));
    }
}
