<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends Controller
{
    use ApiResponses;

    //
    use AuthorizesRequests;

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

    // uses built in authorize functions to check permissions

    // wraps authorize() and forces the use of a specific policy class
    public function isAble($ability, $targetModel)
    {

        return $this->authorize($ability, [$targetModel, $this->policyClass]);

    }
}
