<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Printers;
use App\faq;
class FAQController extends Controller
{
    
    /**
     * function to load all the information for a printer type
     * differentiates between workshop and online printers
     * requires $name to be the name of the printer type
     * $isWorkshopto be true or false depending on if printers
     * for workshop use or for online use should be counted
     */
    private function getTypeInfo($name, $isWorkshop){
        // This defines the properties for the different printer types to display.
        $printer_descriptions = [ 
            "UP!" => ['material' => "ABS or PLA",
                      'speed' => "10-100 cm&sup3;/h",
                      'size' => "140×140×135mm"],
            "UP Plus 2" => ['material' => "ABS or PLA",
                      'speed' => "10-100 cm&sup3;/h",
                      'size' => "140×140×135mm"],
            "UP BOX" => ['material' => "ABS or PLA",
                      'speed' => "",
                      'size' => "255x205x205mm"],
            "Malyan M200" => ['material' => "ABS or PLA",
                      'speed' => "180 mm/s",
                      'size' => "120x120x120mm"],
            "Original Prusa i3 MK3" => ['material' => "Any thermoplastic including Nylon and Polycarbonate",
                      'speed' => "200+ mm/s",
                      'size' => "250x210x210mm"],
            "Prusa i3 MK3" => ['material' => "Any thermoplastic including Nylon and Polycarbonate",
                      'speed' => "200+ mm/s",
                      'size' => "250x210x210mm"],
        ];
        // default description is empty (but contains the same keys!)
        $printer_description_def = ['material' =>'', 'speed' => '', 'size' => ''];
        // first add the description
        $p = [];
        if(array_key_exists($name,$printer_descriptions)){
            $p = $printer_descriptions[$name];
        }else{
            $p = $printer_description_def;
        }
        // then add the printer type name
        $p['name'] = $name;
        // finally add the count
        $p['count'] = Printers::where('printer_type',$name)
                ->where('printer_status','!=','Signed out')
                ->where('isWorkshop',$isWorkshop)->count(); 
        return $p;
    }
    
    /**
     * Display faq blade
     */
    public function index()
    {
        //We currently show information about the different printers in the workshop
        //this is where we load them...
        // Get printer types
        $printer_types = Printers::select('printer_type')->groupBy('printer_type')->orderBy('printer_type')->get();
        // Initiate variables
        $workshop_printers = [];
        $online_printers = [];
        // Go through all printer types
        foreach($printer_types as $ptype){
            $name = $ptype->printer_type;
            // Get an array with all the information for this type
            $pworkshop = $this->getTypeInfo($name, true);
            $ponline = $this->getTypeInfo($name, false);
            // Only add it to the list, if it is available for workshop/ online
            if($pworkshop['count'] > 0){
                $workshop_printers[] = $pworkshop;
            }
            if($ponline['count'] > 0){
                $online_printers[] = $ponline;
            }
        }
        $faq = faq::get();
        return view('faq.index',compact('workshop_printers','online_printers','faq'));
    }

    public function create()
    {
        // This blade is to create the FAQ entry
        return view('faq.create');
    }
}
