<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group([], function () {
    Route::get('organizations/by-building/{buildingId}', [OrganizationController::class, 'byBuilding']);
    Route::get('organizations/by-activity/{activityId}', [OrganizationController::class, 'byActivity']);
    Route::get('organizations/nearby', [OrganizationController::class, 'nearby']);
    Route::get('organizations/{id}', [OrganizationController::class, 'show']);
    Route::get('organizations/search-by-activity', [OrganizationController::class, 'searchByActivity']);
    Route::get('organizations/search-by-name', [OrganizationController::class, 'searchByName']);

// Buildings
    Route::get('buildings', [BuildingController::class, 'index']);
    Route::get('buildings/{id}', [BuildingController::class, 'show']);

// Activities
    Route::get('activities', [ActivityController::class, 'index']);
    Route::get('activities/{id}', [ActivityController::class, 'show']);

});
