<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;

class ApiController extends Controller
{
    //

    use ApiResponses;

    

    public function include(string $relationship): bool
    {


        // get the query param , from url
        $param = request()->get('include');

        // if user has does not want to include return false and extra param wont be included
        if (! isset($param)) {
            return false;
        }

        // explode lower case string

        $includeValues = explode(',', strtolower($param));

        // check rs and display
        return in_array(strtolower($relationship), $includeValues);

    }
}
