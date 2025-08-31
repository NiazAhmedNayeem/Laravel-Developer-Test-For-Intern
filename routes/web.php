<?php

use App\Http\Controllers\Backend\Country\CountryController;
use Illuminate\Support\Facades\Route;

///Dashboard Route
    Route::get('/dashboard', [App\Http\Controllers\Backend\Dashboard\DashboardController::class, 'index'])
        ->name('backend.dashboard');

    //Country management route start here
    Route::get('/country', [CountryController::class, 'index'])->name('backend.country');
    Route::get('/country/data', [CountryController::class, 'data'])->name('backend.country.data');
    Route::post('/country/store', [CountryController::class, 'store'])->name('backend.country.store');


//country route start here

// Route::get('/{page?}', function ($page = null) {
//     $page = $page ?? 'index.html';

//     $path = public_path("html/{$page}");

//     if (File::exists($path)) {
//         return response()->file($path);
//     }

//     abort(404);
// });


