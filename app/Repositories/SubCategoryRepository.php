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
        if ($request->header('Content-Language') == 'zh'){
            $categories = $this->subCategoryListByLang($categoryId,'subcategory_name_zh');

        }  elseif ($request->header('Content-Language') == 'mm'){
            $categories = $this->subCategoryListByLang($categoryId,'subcategory_name_mm');

        } else {
            $categories = $this->subCategoryListByLang($categoryId,'subcategory_name');
        }

        $paginator = $this->subCategory->where('deleted_status', $this->disableDeletedStatus)
                                       ->paginate($this->perPage);

        return $this->responseRepo->successResponse(new SubCategoryListCollection($categories, $paginator), $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function subCategoryListByLang($categoryId,$categoryName){
        
        $subCategories = $this->subCategory->select('id', $categoryName,'service_code')
                                            ->where('deleted_status', $this->disableDeletedStatus)
                                            ->where('category_id', $categoryId)
                                            ->paginate($this->perPage);
        
        $data =[];
        foreach ($subCategories as $key =>  $category) {
            $data[$key]['id'] = $category->id;
            $data[$key]['categoryName'] = $category->$categoryName;
            $data[$key]['totalContact'] = $this->serviceRepo->checkServiceModel($category->service_code)->count();
        }

        return $data;
    }
}
