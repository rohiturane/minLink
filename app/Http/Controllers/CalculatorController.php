<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function isaCalculator()
    {
        return view('frontend.calculators.isa_calculator');
    }
}
