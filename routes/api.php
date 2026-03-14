<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

Route::patch('/tasks/{id}/status', [TaskController::class, 'changeStatus']);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);
Route::apiResource('comments', CommentController::class);
