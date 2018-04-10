<?php

namespace App\Http\Controllers\Traits;

use App\Sessions;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/**
 * This Trait provides functions to get a default choice for each demonstrator in each session
 **/
trait RotaDefaultsTrait
{

    /**Finds the shortest option list (Step 1)**/
    private function defaultSelectShortestList($sessions, $demonstrators, $defaults){
        //TODO: not yet done
        // For now: Find first unset default and return
        foreach($sessions as $s){
            $dem_id = 0;
            foreach($defaults['session_'.$s->id] as $def){
                if($def['id'] <= 0){
                    return [$s->id, $dem_id];
                }
                $dem_id++;
            }
        }
        return null;
    }
    
    /** Pick first option in demonstrator option list for the specified session and demonstrator (Step 2)**/
    private function defaultPickFist($session_id, $dem_id, $demonstrators){
        //Get the appropriate list
        if($dem_id <= 0){
            $temp = $demonstrators['session_'.$session_id]['dem1'];
        }else{
            $temp = $demonstrators['session_'.$session_id]['dem2'];
        }
        //get first entry
        $name = reset($temp);
        $id = key($temp);
        return array('name' => $name, 'id' => $id);
    }
    
    /**removes the chosen demonstrator from the option lists in the same session (Step 3)**/
    private function defaultRemoveFromSameSession($session, $demonstrators, $choice){
        $dem1 = $demonstrators['session_'.$session->id]['dem1'];
        unset($dem1[$choice]);
        $demonstrators['session_'.$session->id]['dem1'] = $dem1;

        $dem2 = $demonstrators['session_'.$session->id]['dem2'];
        unset($dem2[$choice]);
        $demonstrators['session_'.$session->id]['dem2'] = $dem2;
        
        return $demonstrators;
    }
    
    /**moves the specified staff to the bottom of every list it occurs (Step 4)**/
    private function defaultMoveToBottomOfLists($demonstrators, $staff_id){
        foreach($demonstrators as $session_id => $sdem){
            foreach($sdem as $dem_id => $dem){
                //if list contains staff
                if(array_key_exists($staff_id,$dem)){
                    //move staff to bottom of list
                    $staff_name = $dem[$staff_id];
                    unset($dem[$staff_id]);
                    $dem[$staff_id] = $staff_name;
                }
                $demonstrators[$session_id][$dem_id] = $dem;
            }
        }
        return $demonstrators;
    }
    
    /** check, if there are demonstrators allocated to a session and returns them as a default, otherwise returns empty (Step 0)**/
    private function defaultAssigned($sessions, $demonstrators)
    {
        //First step: check, if there are already demonstrators allocated
        $defaults = [];
        foreach($sessions as $s){
            $staffs = $s->staff;
            for($d=0;$d<$s->dem_required;$d++){
                if(count($staffs) > $d){
                    // Default choice should be previously assigned demonstrator
                    $staff = $staffs[$d];
                    $defaults['session_'.$s->id]['dem_'.$d] = array('name' => $staff->first_name.' '.$staff->last_name, 'id' => $staff->id);
                    $demonstrators = $this->defaultRemoveFromSameSession($s, $demonstrators, $staff->id);
                }else{
                    // No demonstrator allocated so far -> Default choice needs to be determined
                    $defaults['session_'.$s->id]['dem_'.$d] = array('name' => '', 'id' => 0);
                }
            }
        }
        return [$defaults,$demonstrators];
    }

    /** takes a list of sessions and demonstrators to choose for the sessions and returns the default choices 
     *  idea on how to approach this:
     *  1) select shortest option list, 
     *  2) pick first, 
     *  3) remove that entry from each list for same session, 
     *  4) move the entry to the bottom of every other list
     *  5) go back to step 1) until all lists are completed
     **/
    public function choosedefault($sessions, $demonstrators)
    {
        //0) check, if there are already demonstrators allocated
        $temp = $this->defaultAssigned($sessions, $demonstrators);
        $defaults = $temp[0];
        $demonstrators = $temp[1];
        //1) select shortest option list,
        $temp = $this->defaultSelectShortestList($sessions, $demonstrators, $defaults);
        while($temp != null){
            $session_id = $temp[0];
            $dem_id = $temp[1];
            //2) pick first,
            $defaults['session_'.$session_id]['dem_'.$dem_id] = $this->defaultPickFist($session_id, $dem_id, $demonstrators);
            //3) remove that entry from each list for same session,
            $staff_id = $defaults['session_'.$session_id]['dem_'.$dem_id]['id'];
            $session = Sessions::find($session_id);
            $demonstrators = $this->defaultRemoveFromSameSession($session, $demonstrators, $staff_id);
            //4) move the entry to the bottom of every other list
            $demonstrators = $this->defaultMoveToBottomOfLists($demonstrators, $staff_id);
            //5) go back to step 1) until all lists are completed
            $temp = $this->defaultSelectShortestList($sessions, $demonstrators, $defaults);
        }
        return $defaults;
    }
}
