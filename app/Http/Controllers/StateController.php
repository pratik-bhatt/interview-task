<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function getStates($country_id)
    {
        return State::where('country_id', $country_id)->get();
    }
}
