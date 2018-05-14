<?php

namespace App\Http\Controllers\Traits;

use App\cost_code;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/**
 * This Trait provides functions useful to both online and workshop jobs
 **/
trait JobsTrait
{

    /**
     * Defines the payment category based on the 9 digit uni id
     * @param $customer_id string
     * @return string
     */
    private function getPaymentCategory($customer_id){
        $firstdigit = substr($customer_id, 0, 1);
        switch ($firstdigit) {
            case '1':
                $payment_category = 'staff';
                break;
            case '2':
                $payment_category = 'postgraduate';
                break;
            case '3':
                $payment_category = 'masters';
                break;
            default:
                $payment_category = 'undergraduate';
                break;
        }
        return $payment_category;
    }

    /**
     * checks the payment details and returns the corrected details
     * takes a shortage or costcode as $use_case and the $budget_holder
     * returns the use_case as shortage or known/unknown cost code,
     * looks up the shortage/ cost code in the database and returns the
     * data from the database if found. Returns the provided data otherwise
     * @param string $use_case 
     * @param string $budget_holder 
     * @return array $cost_code, $use_case, $budget_holder
     */
    private function getPaymentDetails($use_case,$budget_holder){
        // Define a cost code
        // check the module shortage exists
        $query = cost_code::all()->where('shortage','=',strtoupper($use_case))->first();
        if ($query !== null){
            // If shortage exists, then populate cost code and shortage with the DB data
            $cost_code = $query->value('cost_code');
            $use_case = strtoupper($use_case);
            $budget_holder = $query->holder;
        } else { // If shortage is not found in the DB, check whether the cost code can be found in the DB
            $query = cost_code::all()->where('cost_code','=',$use_case)->first();
            $cost_code = $use_case;
            if ($query !== null){ // The cost code was found. Set a corresponding flag
                $use_case = 'Cost Code - approved';
                $budget_holder = $query->holder;
            } else { // The cost code was not found. Set a corresponding flag
                $use_case = 'Cost Code - unknown';
                //$budget_holder = $budget_holder;
            }
        }
        return [$cost_code, $use_case, $budget_holder];
    }
    
    /** Deletes a job from the database, leaving no trace of it. This should never be called for started jobs! **/
    private function deleteJob($id){
        $job = Jobs::findOrFail($id);
        
        $job->deleteAll(); // Delete job
    }

    /** Deletes a job from the database, leaving no trace of it. This should never be called for started jobs! **/
    private function approveJob($id,$comment = ""){
        $job = Jobs::findOrFail($id);
        
        // Update the Job
        $job->update([
            'status' => 'Approved',
            'approved_at' => Carbon::now('Europe/London'),
            'job_approved_by' => Auth::user()->staff->id,
            'job_approved_comment' => $comment,
        ]);
    }
}
