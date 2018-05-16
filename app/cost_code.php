<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class cost_code
 * This class handles cost_codes from the printing service that relate to university agresso codes
 *
 * @package App
 * @property string $shortage short code to be used by users instead of the official university cost code
 * @property int $cost_code official university cost code
 * @property string $aproving_member_of_staff the university staff who approves this print
 * @property date $expires the date when the code will expire/ expired
 * @property string $holder budget holder for the university cost code
 * @property string $description official name of the university cost code
 * @property string $explanation explanation of the project this shortage applies to
 **/
class cost_code extends Model
{
    protected $guarded = [];
}
