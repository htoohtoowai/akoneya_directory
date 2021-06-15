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

	public function getByZoneId($request, $zoneId)
	{
		$townshipName = $this->getNameByMultiLanguage($request, 'township_name', 'township_name_mm', 'township_name_zh');
		
		$townships = $this->townshipModel->where('zone_id',$zoneId)->where('deleted_status', $this->disableDeletedStatus)->orderBy($townshipName)->get();
		
		$data['townships'] = TownshipListResource::collection($townships);

		return $this->responseRepo->successResponse($data,$this->responseRepo->successStatusCode, trans('message.successMsg'));
	}
}