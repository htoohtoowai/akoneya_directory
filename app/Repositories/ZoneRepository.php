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
	}

	public function getZoneList()
	{
		$data['zones'] = ZoneListResource::collection(trans('zones.zoneSelections'))->sortBy('name')->values();
		return $this->responseRepo->successResponse($data,$this->responseRepo->successStatusCode, trans('message.successMsg'));
	}
}