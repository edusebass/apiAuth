<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);

Route::post('/assignrole/{id}', [UserRoleController::class, 'assignRole']);

Route::post('/modules', [ModuleController::class, 'store']);
