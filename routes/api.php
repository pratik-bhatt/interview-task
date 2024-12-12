<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;

Route::get('export', [EmployeeController::class, 'export']);
Route::post('import', [EmployeeController::class, 'import']);


Route::get('employees', [EmployeeController::class, 'index']);
Route::post('employees', [EmployeeController::class, 'store']);
Route::put('employees/{employee}', [EmployeeController::class, 'update']);
Route::delete('employees/{employee}', [EmployeeController::class, 'destroy']);



Route::get('countries', [CountryController::class, 'getCountries']);
Route::get('states/{country_id}', [StateController::class, 'getStates']);
Route::get('cities/{state_id}', [CityController::class, 'getCities']);
