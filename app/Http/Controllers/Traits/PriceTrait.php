<?php

namespace App\Http\Controllers\Traits;

use App\Settings;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/**
 * This Trait provides functions for calculating the price for services
 **/
trait PriceTrait
{

    /**
     * calculates the price of a job, based on print duration and material amount used
     * @param int $hours
     * @param int $minutes
     * @param float $material_amount
     * @return float
     */
    private static function _getPriceOfJob($hours,$minutes,$material_amount){
        // Load prices from database
        $settingsPrices = Settings::where('key','PriceMaterial')
                        ->orWhere('key','PriceTime')
                        ->get();
        $prices = $settingsPrices->mapWithKeys(function ($item) {
            return [$item->key => $item->value()];
        });
        
        //// Load prices from config file
        //$prices = config('prices');
        
        // Calculation the job price £x per h + £y per 100g
        $cost = round($prices['PriceTime'] * ($hours + $minutes / 60) + $prices['PriceMaterial'] * $material_amount / 100, 2);
        return $cost;
    }
}
