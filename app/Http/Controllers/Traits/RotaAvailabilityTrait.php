<?php

namespace App\Http\Controllers\Traits;

use App\staff;
use Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/**
 * This Trait provides a function to get a list of available and tentative demonstrators for 
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
    
    /** returns all the staff, that are busy, away or have not signed up for a session **/
    private function getAllDemonstrators(){
        $demonstrators = staff::where('role','!=', 'Former member')
                ->orderBy('last_name')
                ->get();
        return $demonstrators;
    }

    /** returns all the staff, that are tentatively available for that session and eligible to be assigned to a session **/
    private function getTentativeDemonstratorsForSession($id){
        $demonstrators = staff::whereHas('availability', function ($query) use ($id) {
                $query->where('status', 'tentative')->where('sessions_id', $id);
                })
                ->where('role','!=', 'Former member')
                ->orderBy('last_name')
                ->where('LWI_date','!=', NULL)
                ->get();
        return $demonstrators;
    }
    
    /** returns all the staff, that are available for that session and eligible to be assigned to a session **/
    private function getAvailableDemonstratorsForSession($id){
        $demonstrators = staff::whereHas('availability', function ($query) use ($id) {
                $query->where('status', 'available')->where('sessions_id', $id);
                })
                ->where('role','!=', 'Former member')
                ->orderBy('last_name')
                ->where('LWI_date','!=', NULL)
                ->get();
        return $demonstrators;
    }
    
    /** returns all the staff, that are tentatively available for that session and eligible to be assigned to a session **/
    private function getOtherDemonstratorsForSession($id,$demA,$demT){
        $demonstrators = $this->getAllDemonstrators();
        $demonstrators = $demonstrators->diff($demA);
        $demonstrators = $demonstrators->diff($demT);
        return $demonstrators;
    }
    
    /** returns two arrays with lists of demonstrators that can be assigned for each session, 
     * the first list for the html select input and 
     * the second array for the function choosing a default selection.
     **/
    public function getOptions($sessions){
        $demonstrators = array();
        $demonstratorsForDefs = array();
        // Go through sessions
        foreach($sessions as $s){
            $id = $s->id;
            // Get available and tentatively available demonstrators
            $demA = $this->getAvailableDemonstratorsForSession($id);
            $demT = $this->getTentativeDemonstratorsForSession($id);
            $demALL = $this->getOtherDemonstratorsForSession($id,$demA,$demT);
            $demALL = $this->orderByLastSession($demALL);
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
            $demonstrators['session_'.$id]['dem1'] = array(
                'experienced demonstrators'=>$demEA+$demET, 
                'inexperienced demonstrators'=>$demIA+$demIT
            ); //EA>ET>IA>IT
            $demonstrators['session_'.$id]['dem2'] = array(
                'available demonstrators'=>$demIA+$demEA, 
                'tentatively available demonstrators'=>$demIT+$demET
            ); //IA>EA>IT>ET
            if(Auth::user()->hasAnyRole(['administrator'])){
                $demonstrators['session_'.$id]['dem1']['Other'] = $demALL;
                $demonstrators['session_'.$id]['dem2']['Other'] = $demALL;
            }
            // Do the same but without the labels for the code choosing the defaults
            $demonstratorsForDefs['session_'.$id]['dem1'] = $demEA+$demET; //EA>ET>IA>IT
            $demonstratorsForDefs['session_'.$id]['dem2'] = $demIA+$demEA+$demIT+$demET; //IA>EA>IT>ET 
        }
        return [$demonstrators, $demonstratorsForDefs];
    }
}
