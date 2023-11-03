<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Contracts\ImportUsersContract;
use App\Models\ImportUser;
use App\Http\Controllers\ImportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/import', [ImportController::class, 'import'])->name('import');

// Route::get('test', function (Request $request) {
//     $first = memory_get_usage();
//     $importUsers = app(ImportUsersContract::class);
//     $importUsers->setUserModel(app(ImportUser::class));
//     dd($importUsers->import(5000));
//     var_dump(memory_get_usage() - $first);
// });