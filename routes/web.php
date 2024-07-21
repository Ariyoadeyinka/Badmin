<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Clients;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => auth()->user(),
            ],
            'employees' => [
                'employee' => Employee::all()
            ]
        ]);
    })->name('dashboard');

});

Route::middleware(['auth', 'verified'])->group(function () {


    Route::get('/client', function () {
        return Inertia::render('Client', [
            'auth' => [
                'user' => auth()->user(),
            ],

            'clients' => Clients::all()
        ]);
    })->name('client');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/**
 * ------------------------------------------------------------
 * EMPLOYEE ROUTE GROUPS 
 * ------------------------------------------------------------
 */
Route::group(['middleware '=> 'auth', 'prefix'=> 'employee'], function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employee');
    Route::post('/delete/{id}', [EmployeeController::class, 'delete']);
    Route::post('/update/{id}', [EmployeeController::class, 'update']);
    Route::post('/create', [EmployeeController::class, 'create']);

}); 







require __DIR__.'/auth.php';

