<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

// Protected Routes
Route::group([
    "middleware" => ["auth:api"]
], function () {
    Route::resource('todos', TaskController::class);
    Route::get("logout", [ApiController::class, "logout"]);
});
