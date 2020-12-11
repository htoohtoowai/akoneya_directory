<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\ServiceResourceCollection;
use App\Models\SubCategory;
use App\Models\Hotel;
use App\Models\HotelAgency;
use App\Models\PrivateHospital;
use App\Models\PublicHospital;
use App\Models\Bank;
use App\Models\Microfinance;
use App\Exceptions\NotFoundException;

class ServiceRepository extends BaseRepository
{
    public function __construct(ResponseRepository $responseRepo)
    {
        $this->responseRepo = $responseRepo;
        $this->disableDeletedStatus = config('enums.disableDeletedStatus');
        $this->directoryServiceCodes = config('directory_services.codes');
        $this->perPage = config('enums.perPage');
        $this->nextId = null;
    }

    public function checkSubCategory($subCategoryId)
    {
        $subCategory = SubCategory::find($subCategoryId);
        if (!$subCategory) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }
        return $subCategory;
    }

    public function checkServiceModel($serviceCode)
    {
        $directoryService = $this->directoryServiceCodes[$serviceCode];
        $serviceModelClassName = $directoryService["model"];
        $serviceModel = new $serviceModelClassName();
        if (!class_exists($serviceModelClassName)) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }
        return $serviceModel;
    }

    public function getServiceList($subCategoryId, $filter, $nextId)
    {
        $totalResultCount = 0;
        $serviceInformation = [];
        $subCategory = $this->checkSubCategory($subCategoryId);
        $serviceModel = $this->checkServiceModel($subCategory->service_code);
        
        if ($nextId != ""  && $nextId != 'null') {
            $totalResultCount = $serviceModel->filter($filter)->count();
            $serviceInformationQuery = $serviceModel->filter($filter);

            if ($nextId != 0) {
                $nextData = $serviceModel->find($nextId);
                if ($nextData) {
                    $serviceInformationQuery = $serviceInformationQuery->where('name', ">=", $nextData->name);
                }
            }

            $serviceInformation = $serviceInformationQuery->orderBy('name')
                                    ->limit($this->perPage+1)
                                    ->where('deleted_status', $this->disableDeletedStatus)
                                    ->get();

            $paginationCount = $serviceInformation->count();
            if ($paginationCount > $this->perPage) {
                $this->nextId  = $serviceInformation[$this->perPage]->id;
                
                unset($serviceInformation[$paginationCount - 1]);
            }
        }
        
        return $this->responseRepo->successResponse(new ServiceResourceCollection($serviceInformation, $this->nextId, $totalResultCount), $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }
}
