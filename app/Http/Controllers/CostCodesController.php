<?php

namespace App\Http\Controllers;

use App\cost_code; // Load the Cost-code model
use App\Rules\CustomerNameValidation; // Load custom validations for customer name
use App\Rules\text; // Load custom validations for text
use Carbon\Carbon; // Load Carbon for time

/**
 * Class CostCodesController
 * Manage the cost code to shortage mappings used for claiming money for jobs
 * @package App\Http\Controllers
 */
class CostCodesController extends Controller
{
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//

    /**
     * CostCodesController constructor.
     *
     */
     public function __construct()
    {
        // One has to be authenticated to execute any functions from this controller
        $this->middleware('auth');
    }
    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    /**
     * Returns the blade showing active cost code to shortage mappings
     * @blade /costCodes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Request only active cost codes from the database
        $nowDate = new Carbon();
        $nowDate = $nowDate->toDateString();
        $cost_codes = cost_code::where('expires','>',$nowDate)->get();
        return view('costCodes.index',compact('cost_codes'));
    }

    /**
     * Returns the blade showing inactive cost code to shortage mappings
     * @blade /costCodes/expired
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexInactive()
    {
        // Return only the inactive cost codes
        $nowDate = new Carbon();
        $nowDate = $nowDate->toDateString();
        $cost_codes = cost_code::where('expires','<',$nowDate)->get();
        return view('costCodes.expired',compact('cost_codes'));
    }

    /**
     * Returns the blade with a form to create a new cost code to shortage mapping
     * @blade /costCodes/create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('costCodes.create');
    }

    /**
     * Returns a blade with the form to update information associated with the existing cost code to shortage mappings
     * @blade /costCodes/update/{id}
     * @param $id int cost-code id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $cost_code = cost_code::find($id);
        return view('costCodes.edit',compact('cost_code'));
    }
    
    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//

    /**
     * Retrieves the date from the form, validates it and creates a new cost code to shortage mapping in the database
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
        return redirect('/costCodes');
    }

    /**
     * This function updates the existing database entry with the new information from the edit cost code to shortage
     * mappings form
     * @param $id int cost-code id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
        return redirect('/costCodes');
    }

    /**
     * Delete the cost-code to shortage mapping from the database
     * @param $id int cost-code id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $cost_code = cost_code::findOrFail($id);
        $cost_code -> delete();
        notify()->flash('The record has been deleted!', 'success');
        return redirect('/costCodes');
    }
}
