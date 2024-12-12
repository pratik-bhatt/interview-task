<?php

namespace App\Http\Controllers;

use App\Imports\EmployeeImport;
use App\Models\Employee;
use Illuminate\Http\Request;

use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    private $messages = [
        'name.required' => 'The employee name is required.',
        'name.string' => 'The employee name must be a valid string.',
        'gender.required' => 'Please select the employee gender.',
        'gender.in' => 'The selected gender is invalid.',
        'country_id.required' => 'Please select a country.',
        'country_id.exists' => 'The selected country is invalid.',
        'state_id.required' => 'Please select a state.',
        'state_id.exists' => 'The selected state is invalid.',
        'city_id.required' => 'Please select a city.',
        'city_id.exists' => 'The selected city is invalid.',
        'skills.required' => 'At least one skill is required.',
        'skills.array' => 'Skills must be an array.',
        'skills.*.required' => 'Each skill field is required.',
        'skills.*.string' => 'Each skill must be a valid string.',
        'skills.*.max' => 'Each skill cannot exceed 255 characters.',
    ];

    public function index()
    {
        $employees = Employee::with(['country', 'state', 'city'])->get();

        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'skills' => 'required|array',
            'skills.*' => 'required|string'
        ], $this->messages);
        $employee = Employee::create($validated);

        return response()->json($employee, 201);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'skills' => 'required|array',
            'skills.*' => 'required|string'
        ], $this->messages);
        $employee->update($validated);

        return response()->json($employee);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json(null, 204);
    }


    public function export(Request $request)
    {
        $format = $request->get('format', 'xlsx');

        return Excel::download(new EmployeesExport, 'employees.' . $format);
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new EmployeeImport, $request->file('file'));

            return response()->json(['message' => 'Employees imported successfully!'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Error importing file: ' . $e->getMessage()], 500);
        }
    }


}
