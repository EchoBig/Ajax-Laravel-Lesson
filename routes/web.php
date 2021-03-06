<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/countries.list', [CountriesController::class,'index'])->name('countries.list');
Route::post('/add-country', [CountriesController::class,'addCountry'])->name('add.country');
Route::get('/getCountriesList',[CountriesController::class,'getCountriesList'])->name('get.contyies.list');
Route::post('/getCountryDetails',[CountriesController::class,'getCountryDetails'])->name('get.country.details');
Route::post('/updateCountry',[CountriesController::class,'updateCountry'])->name('update.country');
Route::post('/deleteCountry',[CountriesController::class,'deleteCountry'])->name('deleteCountry');