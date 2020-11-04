<?php
namespace App\Repositories;
use App\Models\SubCategory;
use App\Repositories\ResponseRepository;
use App\Http\Resources\SubCategoryListCollection;
use App\Repositories\ServiceRepository;

class SubCategoryRepository extends BaseRepository
{   

    public function __construct(SubCategory $subCategory,ResponseRepository $responseRepo, ServiceRepository $serviceRepo)
    {
        $this->subCategory = $subCategory;
        $this->successStatusCode = config('http_status.success');
        $this->badRequestStatusCode = config('http_status.badRequest');
        $this->notFoundStatusCode = config('http_status.badRequest');
        $this->unauthorizedStatusCode = config('http_status.unauthorized');
        $this->disableDeletedStatus = config('enums.disableDeletedStatus');
        $this->responseRepo = $responseRepo;
        $this->serviceRepo = $serviceRepo;

        $this->perPage = config('enums.perPage');


    }

    public function getSubCategory($request, $categoryId)
    {
        $subCategoryName = "subcategory_name";

        if ($request->header('Content-Language') == 'zh'){
            $subCategoryName = 'subcategory_name_zh';

        }  elseif ($request->header('Content-Language') == 'mm'){
            $subCategoryName = 'subcategory_name_mm';

        }

        $subCategories = $this->subCategoryListByLang($categoryId,$subCategoryName);
        $data = (new SubCategoryListCollection($subCategories))->subCategoryName($subCategoryName);

        return $this->responseRepo->successResponse($data, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function subCategoryListByLang($categoryId,$categoryName){
        
        $subCategories = $this->subCategory->select('id', $categoryName,'service_code')
                                            ->where('deleted_status', $this->disableDeletedStatus)
                                            ->where('category_id', $categoryId)
                                            ->orderBy($categoryName)
                                            ->paginate($this->perPage);

        return $subCategories;
    }
}
