<?php

namespace App\Http\Controllers;

use App\Rules\CustomerNameValidation;
use App\Rules\text;
//use Faker\Provider\ar_JO\Text;
use Illuminate\Http\Request;
use App\cost_code;
use Carbon\Carbon;

class CostCodesController extends Controller
{
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    // This controller is created to manage all pages connected with the cost codes
    public function __construct()
    {
        // This controller manages comments to posts (issues)
        $this->middleware('auth');
    }
    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    
    public function index()
    {
        // Request only active cost codes from the database
        $nowDate = new Carbon();
        $nowDate = $nowDate->toDateString();
        $cost_codes = cost_code::where('expires','>',$nowDate)->get();
        return view('costCodes.index',compact('cost_codes'));
    }
    
    public function indexInactive()
    {
        // Return only the inactive cost codes
        $nowDate = new Carbon();
        $nowDate = $nowDate->toDateString();
        $cost_codes = cost_code::where('expires','<',$nowDate)->get();
        return view('costCodes.expired',compact('cost_codes'));
    }
    
    public function create()
    {
        return view('costCodes.create');
    }
    
    public function edit($id)
    {
        $cost_code = cost_code::find($id);
        return view('costCodes.edit',compact('cost_code'));
    }
    
    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    public function store()
    {
        // Validate input cost code
        $cost_code_request = request()->validate([
            // Shortage min 3, max 13, alpha-numeric characters, as well as dashes and underscores
            'shortage' => [
                'min:3',
                'max:13',
                'alpha_dash'
            ],
            'explanation' => [
                'min:15',
                'max:2048',
                new text
            ],
            // Cost code numeric with 11 digits
            'cost_code' => [
                'digits:9'
            ],
            // Name of the member od staff who approves
            'aproving_member_of_staff' => [
                'min:3',
                'max:100',
                new CustomerNameValidation
            ],
            // Expiry date
            'expires' => [
                'date_format:Y-m-d'
            ],
            // Name of the budget holder
            'holder' => [
                'min:3',
                'max:100',
                new CustomerNameValidation
            ],
            // Message with description
            'description' => [
                'min:3',
                'max:255',
                'string'
            ]
        ]);

        $cost_code_request['shortage'] = strtoupper($cost_code_request['shortage']);
        cost_code::create($cost_code_request);

        notify()->flash('The record has been created!', 'success', [
            'text' => 'Thank you for creating a new cost code',
        ]);
        return redirect('/costCodes/index');
    }
    
    public function update($id)
    {
        $cost_code_request = request()->validate([
           'shortage' => [
               'min:3',
               'max:13',
               'alpha_dash'
           ],
            'explanation' => [
                'min:15',
                'max:2048',
                new text
            ],
            'cost_code' => [
                'digits:9'
            ],
            'aproving_member_of_staff' => [
                'min:3',
                'max:100',
                new CustomerNameValidation
            ],
            'expires' => [
                'date_format:Y-m-d'
            ],
            'holder' => [
                'min:3',
                'max:100',
                new CustomerNameValidation
            ],
            'description' => [
                'min:3',
                'max:255',
                'string'
            ]
        ]);

        $cost_code = cost_code::findOrFail($id);

        $cost_code->update($cost_code_request);
        notify()->flash('The record has been updated!', 'success', [
            'text' => 'Thank you for the cost code update',
        ]);
        return redirect('/costCodes/index');
    }
    
    public function destroy($id)
    {
        $cost_code = cost_code::findOrFail($id);
        $cost_code -> delete();
        notify()->flash('The record has been deleted!', 'success');
        return redirect('/costCodes/index');
    }
}
