<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

// Redirect root to employee index
Route::get('/', function () {
    return redirect()->route('employees.index');
});

// List all employees
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

// Show the form to create a new employee
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');

// Store a newly created employee (POST)
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

// Show a specific employee's details
Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

// Show the form to edit an existing employee
Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

// Update an existing employee (PUT/PATCH)
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');

// Delete an employee
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
