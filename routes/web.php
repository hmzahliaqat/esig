<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::post('save/document', [DocumentController::class , 'upload']);
Route::get('document/{id}/{shared}/preview', [DocumentController::class , 'show']);


Route::post('/replace-pdf', [DocumentController::class , 'replacePdf']);
Route::post('/save-shared-pdf', [DocumentController::class , 'saveSharedPdf']);

Route::post('/share/document', [DocumentController::class , 'share']);



Route::get('/documents/view/{filename}', function ($filename) {
    $path = storage_path('app/private/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/employees' , [EmployeesController::class, 'index'])->name('employees');
    Route::get('/documents' , [DocumentController::class, 'index'])->name('documents');


});
