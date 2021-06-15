<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PostalCodeRepository;
use App\Filters\PostalCodeFilter;

class PostalCodeController extends Controller
{
    public function __construct(PostalCodeRepository $postalCodeRepo)
    {
        $this->postalCodeRepo = $postalCodeRepo;
    }

    public function getPostalCodes(Request $request,PostalCodeFilter $filter)
    {
    	return $this->postalCodeRepo->getPostalCodes($request, $filter);
    }
}
