<?php

namespace App\Http\Controllers;

/**
 * @OA\Schema(
 *     schema="Organization",
 *     type="object",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
 *     @OA\Property(
 *         property="phones",
 *         type="array",
 *
 *         @OA\Items(type="string", example="2-222-222")
 *     ),
 *
 *     @OA\Property(
 *         property="building",
 *         ref="#/components/schemas/Building"
 *     ),
 *     @OA\Property(
 *         property="activities",
 *         type="array",
 *
 *         @OA\Items(ref="#/components/schemas/Activity")
 *     ),
 *
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="OrganizationFull",
 *     allOf={@OA\Schema(ref="#/components/schemas/Organization")},
 *
 *     @OA\Property(
 *         property="building",
 *         ref="#/components/schemas/Building"
 *     ),
 *     @OA\Property(
 *         property="activities",
 *         type="array",
 *
 *         @OA\Items(ref="#/components/schemas/Activity")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Building",
 *     type="object",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="address", type="string", example="г. Москва, ул. Ленина 1, офис 3"),
 *     @OA\Property(
 *         property="coordinates",
 *         type="object",
 *         @OA\Property(property="latitude", type="number", format="float", example=55.755826),
 *         @OA\Property(property="longitude", type="number", format="float", example=37.6173)
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Activity",
 *     type="object",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Молочная продукция"),
 *     @OA\Property(property="parent_id", type="integer", nullable=true, example=2),
 *     @OA\Property(property="level", type="integer", example=2)
 * )
 *
 * @OA\Schema(
 *     schema="OrganizationCollection",
 *     type="object",
 *
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *
 *         @OA\Items(ref="#/components/schemas/Organization")
 *     ),
 *
 *     @OA\Property(
 *         property="meta",
 *         type="object",
 *         @OA\Property(property="count", type="integer", example=5)
 *     )
 * )
 */
abstract class Controller
{
    //
}
