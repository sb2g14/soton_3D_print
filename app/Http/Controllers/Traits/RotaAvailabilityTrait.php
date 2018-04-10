<?php

namespace App\Http\Controllers\Traits;

use App\staff;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/**
 * This Trait provides a function to get a list of available and tentative demosntrators for 
 * a list of sessions in an appropriate order.
 **/
trait RotaAvailabilityTrait
{

    /**takes a list of demonstrators and converts it into a list for a drop-down input**/
    private function pluckToList($demonstrators){
        $dems = [];
        foreach($demonstrators as $d){
            $dems[$d->id] = $d->first_name.' '.$d->last_name;
        }
        return $dems;
    }
    
    /**takes a list of demonstrators and orders them by how long it has been since they last demonstrated**/
    private function orderByLastSession($demonstrators){
        $temp = [];
        $dems = [];
        // Prepare array for sorting, by adding a new key
        foreach($demonstrators as $d){
            $lastsession = $d->lastSession();
            $dn = $d;
            $dn->lastsession = $lastsession;
            $temp[] = $dn;
        }
        // Do the sorting
        $temp = collect($temp)->sortBy('lastsession');
        $temp = $temp->values()->all();
        // $temp contains the demonstrators sorted by the last session they demonstrated - 
        // Now need to format for select form
        $dems = $this->pluckToList($temp);
        return $dems;
    }
    
    /** takes a list of staff and returns two list of staff,
        splitted by experience and order by last attended date
     **/
    private function splitByExperience($demonstrators){
        $demE = array();
        $demI = array();
        // Split into experienced and new demonstrators
        foreach($demonstrators as $dem){
            if($dem->isExperienced()){
                $demE[] = $dem;
            }else{
                $demI[] = $dem;
            }
        }
        // Order by date of last session asc
        $demE = $this->orderByLastSession($demE);
        $demI = $this->orderByLastSession($demI);
        $dems = [$demE,$demI];
        return $dems;
    }

    /** returns all the staff, that are tentatively available for that session and eligible to be assigned to a session **/
    private function getTentativeDemonstratorsForSession($id){
        $demonstrators = staff::whereHas('availability', function ($query) use ($id) {
                $query->where('status', 'tentative')->where('sessions_id', $id);
                })
                ->where('role','!=', 'Former member')
                ->orderBy('last_name')
                ->get();
                //->where('SMT_date','!=', NULL)
        return $demonstrators;
    }
    
    /** returns all the staff, that are available for that session and eligible to be assigned to a session **/
    private function getAvailableDemonstratorsForSession($id){
        $demonstrators = staff::whereHas('availability', function ($query) use ($id) {
                $query->where('status', 'available')->where('sessions_id', $id);
                })
                ->where('role','!=', 'Former member')
                ->orderBy('last_name')
                ->get();
                //->where('SMT_date','!=', NULL)
        return $demonstrators;
    }

    public function getOptions($sessions){
        $demonstrators = array();
        // Go through sessions
        foreach($sessions as $s){
            $id = $s->id;
            // Get available and tentatively available demontrators
            $demA = $this->getAvailableDemonstratorsForSession($id);
            $demT = $this->getTentativeDemonstratorsForSession($id);
            // Split the lists depending on the experience and
            // sort them so the ones who have not demonstrated for
            // a long time appear at the top of the list
            $temp = $this->splitByExperience($demA);
            $demEA = $temp[0];
            $demIA = $temp[1];
            $temp = $this->splitByExperience($demT);
            $demET = $temp[0];
            $demIT = $temp[1];
            // Create two prioritised lists - one for the first demonstrator in the session, and one for the others.
            $demonstrators['session_'.$id]['dem1'] = $demEA+$demET+$demIA+$demIT; //EA>ET>IA>IT
            $demonstrators['session_'.$id]['dem2'] = $demIA+$demEA+$demIT+$demET; //IA>EA>IT>ET
        }
        return $demonstrators;
    }
}
