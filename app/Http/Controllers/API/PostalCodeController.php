<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PostalCodeRepository;
use App\Filters\TownshipFilter;

class PostalCodeController extends Controller
{
    public function __construct(PostalCodeRepository $postalCodeRepo, TownshipFilter $townshipFilter)
    {
        $this->postalCodeRepo = $postalCodeRepo;
        $this->townshipFilter = $townshipFilter;
    }

    public function getPostalCodes(Request $request)
    {
    	return $this->postalCodeRepo->getPostalCodes($request, $this->townshipFilter);
    }
}
