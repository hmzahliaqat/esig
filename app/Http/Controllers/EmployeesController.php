<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeesController extends Controller
{

    public function index()
    {
        $employees = User::with('employees')->first()->employees;
        return Inertia::render('Employees/Employees', [
            'employees' => $employees,
        ]);
    }


}
