<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ChartsController extends Controller
{
    /* Charts that will be protected to normal users */
    public $protected_charts = ['printer_status','printspmpy','printspy','userspy'];

    /**
     * Show the chart, made to be displayed in an iframe.
     *
     * @param int $name
     * @param int $height
     */
    public function show($name, $height)
    {
        if (in_array($name, $this->protected_charts)) {
            $this->checkProtected();
        }
        return view("charts.$name", ['height' => $height-100]);
    }

    /**
     * Protected charts will go here first.
     * You can change this condition how you like.
     */
    public function checkProtected()
    {
        if(!Auth::check()) {
            abort(404);
        }
    }
}
?>
