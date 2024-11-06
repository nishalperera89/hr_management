<?php

use App\Http\Controllers\AdminSignInController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user-sign-in',[AdminSignInController::class,'adminSignIn']);
