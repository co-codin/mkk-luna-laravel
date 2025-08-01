<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationCollection;
use App\Http\Resources\OrganizationFullResource;
use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Organizations Directory API",
 *     version="1.0.0",
 *     description="API for managing organizations, buildings, and activities"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="api_key",
 *     type="apiKey",
 *     in="header",
 *     name="X-API-KEY"
 * )
 */
class OrganizationController extends Controller
{
    public function __construct(protected OrganizationService $service) {}

    /**
     * @OA\Get(
     *     path="/api/organizations/by-building/{building_id}",
     *     summary="Get organizations in a building",
     *     tags={"Organizations"},
     *
     *     @OA\Parameter(
     *         name="building_id",
     *         in="path",
     *         required=true,
     *         description="Building ID",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     ),
     *
     *     @OA\Response(response=404, description="Building not found"),
     *     security={{"api_key": {}}}
     * )
     */
    public function byBuilding(int $buildingId)
    {
        $orgs = $this->service->getByBuilding($buildingId);

        return new OrganizationCollection($orgs);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/by-activity/{activity_id}",
     *     summary="Get organizations by activity",
     *     tags={"Organizations"},
     *
     *     @OA\Parameter(
     *         name="activity_id",
     *         in="path",
     *         required=true,
     *         description="Activity ID",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     ),
     *
     *     @OA\Response(response=404, description="Activity not found"),
     *     security={{"api_key": {}}}
     * )
     */
    public function byActivity(int $activityId)
    {
        $orgs = $this->service->getByActivity($activityId);

        return new OrganizationCollection($orgs);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/nearby",
     *     summary="Find organizations nearby",
     *     tags={"Organizations"},
     *
     *     @OA\Parameter(
     *         name="lat",
     *         in="query",
     *         description="Latitude of center point",
     *
     *         @OA\Schema(type="number", format="float")
     *     ),
     *
     *     @OA\Parameter(
     *         name="lng",
     *         in="query",
     *         description="Longitude of center point",
     *
     *         @OA\Schema(type="number", format="float")
     *     ),
     *
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         description="Search radius in meters",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Parameter(
     *         name="bbox",
     *         in="query",
     *         description="Bounding box coordinates (min_lat,min_lng,max_lat,max_lng)",
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid parameters"
     *     ),
     *     security={{"api_key": {}}}
     * )
     */
    public function nearby(Request $request)
    {
        $orgs = $this->service->getNearby($request);

        return new OrganizationCollection($orgs);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/{id}",
     *     summary="Get organization by ID",
     *     tags={"Organizations"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Organization ID",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationFull")
     *     ),
     *
     *     @OA\Response(response=404, description="Organization not found"),
     *     security={{"api_key": {}}}
     * )
     */
    public function show(int $id)
    {
        $org = $this->service->getById($id);

        return new OrganizationFullResource($org);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/search-by-activity",
     *     summary="Search organizations by activity hierarchy",
     *     tags={"Organizations"},
     *
     *     @OA\Parameter(
     *         name="activity_id",
     *         in="query",
     *         required=true,
     *         description="Root activity ID",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     ),
     *     security={{"api_key": {}}}
     * )
     */
    public function searchByActivity(Request $request)
    {
        $request->validate(['activity_id' => 'required|integer|exists:activities,id']);
        $orgs = $this->service->searchByActivity($request->activity_id);

        return new OrganizationCollection($orgs);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/search-by-name",
     *     summary="Search organizations by name",
     *     tags={"Organizations"},
     *
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="Organization name or part of name",
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     ),
     *     security={{"api_key": {}}}
     * )
     */
    public function searchByName(Request $request)
    {
        $request->validate(['name' => 'required|string|min:2']);
        $orgs = $this->service->searchByName($request->name);

        return new OrganizationCollection($orgs);
    }
}
