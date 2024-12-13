<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'index'])
    ->name('books.index');

Route::resource('books', BookController::class)->only([
    'index', 'create', 'store', 'edit', 'update'
]);
