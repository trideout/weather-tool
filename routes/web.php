<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * The base route for returning the only blade template in this project
 */
Route::get('/', function () {
    return view('home');
});
/**
 * use of a get route here allows users to share links easily
 */
Route::get('/weatherLookup', [\App\Http\Controllers\Controller::class, 'lookUpWeather']);
