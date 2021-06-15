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
        $this->data = [];
    }
    
    public function getPostalCodes($request, $filter)
    {
        if ($request->nextId != "" && $request->nextId != 'null') {
            $queryInfo = $this->model->filter($filter);
            $data = $this->getDataByNextId('id',$request->nextId,$queryInfo);
            return $this->responseRepo->successResponse(new PostalCodeListCollection($data['result'],$data['nextId']), $this->responseRepo->successStatusCode, trans('message.successMsg'));
        }
        return $this->responseRepo->successResponse(new PostalCodeListCollection($this->data,$this->nextId), $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }
}