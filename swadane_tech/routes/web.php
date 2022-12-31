<?php

use App\Http\Controllers\RegistrationController;

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

Route::get('/',[RegistrationController::class,'form'])->name('form');
Route::post('form-data',[RegistrationController::class,'form_data'])->name('form_data');
