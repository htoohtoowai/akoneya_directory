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

    public function getServiceList($subCategoryId, $filter, $request)
    {
        $totalResultCount = 0;
        $serviceInformation = [];
        $serviceList = new ServiceResourceCollection($serviceInformation, $this->nextId, $totalResultCount);

        $subCategory = $this->checkSubCategory($subCategoryId);
        $serviceModel = $this->checkServiceModel($subCategory->service_code);
       
        if ($request->nextId != ""  && $request->nextId != 'null') {
            $totalResultCount = $serviceModel->filter($filter)->where('deleted_status', $this->disableDeletedStatus)->count();
            
            $serviceInformationQuery = $serviceModel->filter($filter)->where('deleted_status', $this->disableDeletedStatus);

            $name = $this->getNameByMultiLanguage($request, 'name', 'name_mm', 'name_zh');
            
            $serviceInformation = $this->getDataOrderedByName($name, $request->nextId, $serviceModel, $serviceInformationQuery);

            $serviceList = new ServiceResourceCollection($serviceInformation['result'], $serviceInformation['nextId'], $totalResultCount);
        }
        
        return $this->responseRepo->successResponse($serviceList, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }
}
