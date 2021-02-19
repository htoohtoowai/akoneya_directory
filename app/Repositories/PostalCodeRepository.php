<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\PostalCodeListCollection;
use App\Models\PostalCode;
use App\Models\Township;

class PostalCodeRepository extends BaseRepository
{
    protected $model;
    protected $responseRepo;

    public function __construct(PostalCode $model, ResponseRepository $responseRepo)
    {
        $this->model = $model;
        $this->responseRepo = $responseRepo;
        $this->perPage = config('enums.perPage');
        $this->disableDeletedStatus = config('enums.disableDeletedStatus');
        $this->nextId = null;
    }
    
    public function getPostalCodes($request, $filter)
    {
        $postalCodeInfos = [];
        $postalCodeList = new PostalCodeListCollection($postalCodeInfos, $this->nextId);

        if ($request->nextId != "" && $request->nextId != 'null') {
            
            if ($request->township != null || $request->township != "") {
                $postalCodeId = 'postal_codes.id';
                $postalCodeQuery = $this->searchByTownshipName($request->zoneId, $filter);
                
            } else {
                $postalCodeId = 'id';
                $postalCodeQuery = $this->model->where('zone_id', $request->zoneId);
            }
            $postalCodeInfos = $this->getDataByNextId($postalCodeId, $request->nextId, $postalCodeQuery);

            foreach ($postalCodeInfos['result'] as $postalCodeInfo) {
                $postalCodeInfo->townshipInfo = Township::select('township_name')->where('id',$postalCodeInfo->directory_township_id)
                                                    ->where('deleted_status', $this->disableDeletedStatus)->first();
            }
            $postalCodeList = new PostalCodeListCollection($postalCodeInfos['result'], $postalCodeInfos['nextId']);
        }
        return $this->responseRepo->successResponse($postalCodeList, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function searchByTownshipName($zoneId, $filter)
    { 
        return $this->model->join('directory_townships','postal_codes.directory_township_id', '=', 'directory_townships.id')
                                ->select('postal_codes.*')
                                ->filter($filter)
                                ->where('postal_codes.zone_id', $zoneId);
    }
}