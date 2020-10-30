<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\ZoneListResource;

class ZoneRepository extends BaseRepository
{
	public function __construct(ResponseRepository $responseRepo)
	{
		$this->responseRepo =$responseRepo;
		$this->zones = config('zones.zoneSelections');
	}

	public function getZoneList()
	{
		$data['zones'] = ZoneListResource::collection($this->zones);
		return $this->responseRepo->successResponse($data,$this->responseRepo->successStatusCode, $this->responseRepo->successMsg);
	}
}