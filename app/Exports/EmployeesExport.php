<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::with(['country', 'state', 'city'])->get()->map(function ($employee) {
            $employee->skills = implode(' | ', $employee->skills);

            return [
                'name' => $employee->name,
                'gender' => $employee->gender,
                'country' => $employee->country->name,
                'state' => $employee->state->name,
                'city' => $employee->city->name,
                'skills' => $employee->skills
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Gender',
            'Country',
            'State',
            'City',
            'Skills'
        ];
    }
}
