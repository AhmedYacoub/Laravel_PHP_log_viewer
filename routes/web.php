<?php

use App\Http\Controllers\PaginatorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PaginatorController::class, 'index']);
