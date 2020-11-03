<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\TownshipListResource;
use App\Models\Township as TownshipModel;

class TownshipRepository extends BaseRepository
{
	public function __construct(ResponseRepository $responseRepo,TownshipModel $townshipModel)
	{
		$this->responseRepo = $responseRepo;
		$this->townshipModel = $townshipModel;
		$this->disableDeletedStatus = config('enums.disableDeletedStatus');
	}

	public function getByZoneId($zoneId)
	{
		$townships = $this->townshipModel->where('zone_id',$zoneId)->where('deleted_status', $this->disableDeletedStatus)->get();
		
		$data['townships'] = TownshipListResource::collection($townships);

		return $this->responseRepo->successResponse($data,$this->responseRepo->successStatusCode, $this->responseRepo->successMsg);
	}
}