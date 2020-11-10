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

	public function getServiceList($subCategoryId,$filter,$perPage)
	{
		$subCategory = $this->checkSubCategory($subCategoryId);
        $serviceModel = $this->checkServiceModel($subCategory->service_code);
        
        $serviceInformation = $serviceModel->filter($filter)
                                            ->where('deleted_status', $this->disableDeletedStatus)
                                            ->orderBy('name')->paginate($perPage);

        $serviceInformationCount = $serviceInformation->total();

		$data = new ServiceResourceCollection($serviceInformation,$serviceInformationCount);

		return $this->responseRepo->successResponse($data,$this->responseRepo->successStatusCode, trans('message.successMsg'));
	}
}