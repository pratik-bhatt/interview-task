<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


class EmployeeImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'country' => 'required|exists:countries,name',
            'state' => 'required|exists:states,name',
            'city' => 'required|exists:cities,name',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $country = Country::where('name', $row['country'])->first();
        $state = State::where('name', $row['state'])->first();
        $city = City::where('name', $row['city'])->first();

        return new Employee([
            'name' => $row['name'],
            'gender' => $row['gender'],
            'country_id' => $country->id,
            'state_id' => $state->id,
            'city_id' => $city->id,
            'skills' => explode(' | ', $row['skills']),
        ]);

    }
}
