<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::resources([
    'posts' => PostController::class,
    'comments' => CommentController::class
]);

Route::get('/user', function () {
    return \App\Models\User::query()->first('name');
});
