<?php

use App\Http\Controllers\Api\AgencyController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    // Users
    Route::apiResource('users', UserController::class);
    Route::get('users/{user}/subordinates', [UserController::class, 'subordinates']);
    Route::get('users/{user}/manager', [UserController::class, 'manager']);

    // Departments
    Route::apiResource('departments', DepartmentController::class);
    Route::get('departments/{department}/members', [DepartmentController::class, 'members']);

    // Teams
    Route::apiResource('teams', TeamController::class);
    Route::get('teams/{team}/members', [TeamController::class, 'members']);

    // Roles
    Route::apiResource('roles', RoleController::class);
    Route::get('roles/{role}/members', [RoleController::class, 'members']);

    // Agencies
    Route::apiResource('agencies', AgencyController::class);
    Route::get('agencies/{agency}/members', [AgencyController::class, 'members']);

    // Offices
    Route::apiResource('offices', OfficeController::class);
    Route::get('offices/{office}/members', [OfficeController::class, 'members']);

    // Organization Chart
    Route::get('org-chart', [UserController::class, 'orgChart']);
    Route::get('org-chart/department/{department}', [UserController::class, 'orgChartByDepartment']);
    Route::get('org-chart/team/{team}', [UserController::class, 'orgChartByTeam']);
});