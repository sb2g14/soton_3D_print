<?php

namespace App\Http\Controllers\Traits;

use Excel;


trait ExcelTrait
{

    /**
     * function to export data into Excel and offer it as a download
     * $data is the collection to export
     * $header is an associative array where the keys are the table header and the values the corresponding collection keys
     */
    public function dataExport($data,$headers)
    {

        
        // Initialize the array which will be passed into the Excel
        // generator.
        $dataArray = [];

        // Define the Excel spreadsheet headers
//        $dataArray[] = ['Printer No Common', 'Printer No','Date','Use/Loan','Student Name','Student ID','Time','Material Amount','Price','Paid','Demonstrator Sign','Payment Category', 'Use Case','Cost Code','Comment','Month','Jobs No','Successful?','Email'];
        $dataArray[] = array_keys($headers);

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($data as $d) {
            $row = [];
            foreach ($headers as $h) {
                $row[] = $d->$h;
            }
            $dataArray[] = $row; //$d->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('DataExport', function($excel) use ($dataArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('exportet_data');
            $excel->setCompany('FEE 3D Printing Service'); //->setCreator(Auth::user()->name)
            $excel->setDescription('Excel file used as a backup for the FEE 3D Printing Service at the University of Southampton');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($dataArray) {
                $sheet->fromArray($dataArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }
}
