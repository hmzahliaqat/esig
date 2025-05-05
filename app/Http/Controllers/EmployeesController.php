<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteEmployeeRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use League\Csv\Reader;

class EmployeesController extends Controller
{

    public function index()
    {
        $employees = User::with('employees')->first()->employees;
        return Inertia::render('Employees/Employees', [
            'employees' => $employees,
        ]);
    }


    public function save(EmployeeRequest $request)
    {

        if ($request->has('id')) {
            $employee = Employee::find($request->id);

            if ($employee) {
                $employee->name = $request->name;
                $employee->email = $request->email;
                $employee->save();
            }
            return response()->json($employee, 200);
        } else {
            $employee = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'user_id' => Auth::id(),
            ]);
            return response()->json($employee, 200);
        }
    }


    public function delete(Request $request, $id = null)
    {
        if ($request->has('ids')) {
            Employee::whereIn('id', $request->ids)->delete();
            return response()->json('Employees deleted', 200);
        }

        $employee = Employee::findOrFail($id);
        if ($employee) {
            $employee->delete();
        }

        return response()->json($employee, 200);
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $csv = Reader::createFromPath($request->file('file')->getPathname(), 'r');
        $csv->setHeaderOffset(0); // Assumes first row is header

        $records = $csv->getRecords(); // Get CSV rows
        $employees = [];

        foreach ($records as $record) {
            Log::info('Processing Record:', $record); //Log records for debugging

            // Validate each row
            $employees = [];

            foreach ($records as $record) {
                $validator = Validator::make($record, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:employees,email',
                ]);

                if ($validator->fails()) {
                    Log::warning('Validation Failed:', $validator->errors()->toArray()); //Log validation errors
                    continue; // Skip invalid records
                }

                // Create and retrieve the ID
                $employee = Employee::create([
                    'name' => $record['name'],
                    'email' => $record['email'],
                    'user_id' => auth()->id(),
                ]);

                // Store the full record (including ID)
                $employees[] = $employee;
            }

            if (!empty($employees)) {
                Log::info('Employees inserted successfully:', $employees);
            } else {
                Log::warning('No valid employees to insert.');
            }

            return response()->json(['message' => 'CSV imported successfully', 'data' => $employees], 200);
        }
    }
}
