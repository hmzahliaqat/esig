<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/login', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('login');





Route::get('/', function () {
   return view('home');
});


Route::get('/thank-you', function(){
    return view('thankyou');
});


Route::post('save/employee', [EmployeesController::class , 'save']);
Route::delete('delete/employee/{id}', [EmployeesController::class , 'delete']);
Route::delete('delete/employees', [EmployeesController::class , 'delete']);
Route::post('edit/employees', [EmployeesController::class , 'edit']);
Route::post('/employees/import', [EmployeesController::class, 'import'])->name('employees.import');


Route::post('save/document', [DocumentController::class , 'upload']);
Route::get('document/{id}/{shared}/preview', [DocumentController::class , 'show']);
Route::get('document/{id}/{shared}/edit', [DocumentController::class , 'edit']);

Route::post('/replace-pdf', [DocumentController::class , 'replacePdf']);
Route::post('/save-shared-pdf', [DocumentController::class , 'saveSharedPdf']);
Route::post('/share/document', [DocumentController::class , 'share']);
Route::delete('delete/document', [DocumentController::class , 'delete']);
Route::post('save-fields', [DocumentController::class , 'saveFields']);
Route::post('/reminder', [DocumentController::class , 'remindEmail']);



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
    Route::get('/track/documents' , [DocumentController::class, 'track'])->name('track.documents');


});
