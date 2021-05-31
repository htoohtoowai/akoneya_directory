<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TownshipRepository;

class TownshipController extends Controller
{
    public function __construct(TownshipRepository $townshipRepo)
    {
        $this->townshipRepo = $townshipRepo;
    }

    public function getByZoneId(Request $request, $zoneId)
    {
    	return $this->townshipRepo->getByZoneId($request, $zoneId);
    }
}
