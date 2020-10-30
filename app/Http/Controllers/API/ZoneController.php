<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ZoneRepository;

class ZoneController extends Controller
{
	public function __construct(ZoneRepository $zoneRepo)
    {
        $this->zoneRepo = $zoneRepo;
    }

    public function getZoneList()
    {
    	return $this->zoneRepo->getZoneList();
    }
}
