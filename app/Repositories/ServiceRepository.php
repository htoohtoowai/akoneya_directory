<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\ServiceListCollection;
use App\Models\SubCategory;
use App\Models\Hotel;
use App\Models\HotelAgency;
use App\Models\PrivateHospital;
use App\Models\PublicHospital;
use App\Exceptions\NotFoundException;

class ServiceRepository extends BaseRepository
{
	public function __construct(ResponseRepository $responseRepo)
	{
		$this->responseRepo = $responseRepo;
		$this->directoryServiceCodes = config('directory_services.codes');
	}

	public function checkSubCategory($subCategoryId)
    {
        $subCategory = SubCategory::find($subCategoryId);
        
        if (!$subCategory) {
            throw new NotFoundException($this->responseRepo->notFoundMsg);
        }
        
        return $subCategory;
    }

    public function checkServiceModel($serviceCode)
    {
    	$directoryService = $this->directoryServiceCodes[$serviceCode];
        $serviceModelClassName = $directoryService["model"];
        $serviceModel = new $serviceModelClassName();

        if (!class_exists($serviceModelClassName)) {
            throw new NotFoundException($this->responseRepo->notFoundMsg);
        }

        return $serviceModel;
    }

	public function getServiceList($subCategoryId,$filter,$perPage)
	{
		$subCategory = $this->checkSubCategory($subCategoryId);
        $serviceModel = $this->checkServiceModel($subCategory->service_code);
        
		$serviceInformation = $serviceModel->filter($filter)->paginate($perPage);
		$data = new ServiceListCollection($serviceInformation);

		return $this->responseRepo->successResponse($data,$this->responseRepo->successStatusCode, $this->responseRepo->successMsg);
	}
}