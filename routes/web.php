<?php


use Illuminate\Support\Facades\Route;

///Dashboard Route
Route::get('/dashboard', [App\Http\Controllers\Backend\Dashboard\DashboardController::class, 'index'])
->name('backend.dashboard');



// Route::get('/{page?}', function ($page = null) {
//     $page = $page ?? 'index.html';

//     $path = public_path("html/{$page}");

//     if (File::exists($path)) {
//         return response()->file($path);
//     }

//     abort(404);
// });


