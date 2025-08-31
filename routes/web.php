<?php

use App\Http\Controllers\Backend\Country\CountryController;
use App\Http\Controllers\Backend\State\StateController;
use Illuminate\Support\Facades\Route;

    ///Dashboard Route
    Route::get('/dashboard', [App\Http\Controllers\Backend\Dashboard\DashboardController::class, 'index'])
        ->name('backend.dashboard');

    //Country management route start here
    Route::get('/country', [CountryController::class, 'index'])->name('backend.country');
    Route::get('/country/data', [CountryController::class, 'data'])->name('backend.country.data');
    Route::post('/country/store', [CountryController::class, 'store'])->name('backend.country.store');
    Route::get('/country/edit/{id}', [CountryController::class, 'edit']);
    Route::post('/country/update/{id}', [CountryController::class, 'update']);
    Route::delete('/country/delete/{id}', [CountryController::class, 'delete']);


    //State management route start here
    Route::get('/state', [StateController::class, 'index'])->name('backend.state');
    Route::get('/state/data', [StateController::class, 'data'])->name('backend.state.data');
    Route::post('/state/store', [StateController::class, 'store'])->name('backend.state.store');
    Route::get('/state/edit/{id}', [StateController::class, 'edit']);
    Route::post('/state/update/{id}', [StateController::class, 'update']);
    Route::delete('/state/delete/{id}', [StateController::class, 'delete']);
    





// Route::get('/{page?}', function ($page = null) {
//     $page = $page ?? 'index.html';

//     $path = public_path("html/{$page}");

//     if (File::exists($path)) {
//         return response()->file($path);
//     }

//     abort(404);
// });


