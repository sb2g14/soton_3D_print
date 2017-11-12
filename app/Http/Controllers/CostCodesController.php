<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cost_code;

class CostCodesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $cost_codes = cost_code::all();
        return view('costCodes.index',compact('cost_codes'));
    }
    public function edit($id)
    {
        $cost_code = cost_code::find($id);
        return view('costCodes.edit',compact('cost_code'));
    }
    public function update($id)
    {
        $cost_code_update = request()->validate([
           'shortage' => [
               'min:3',
               'max:13',
               'alpha_dash'
           ],
            'cost_code' => [
                'digits:9'
            ],
            'aproving_member_of staff' => [
                'min:3',
                'max:100'
            ]
        ]);

        $cost_code = findOrFail($id);

        $cost_code->update([
           ''
        ]);
    }
}
