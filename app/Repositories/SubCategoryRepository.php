<?php
namespace App\Repositories;

use App\Models\Category;
use App\Models\SubCategory;
use App\Repositories\ResponseRepository;
use App\Http\Resources\SubCategoryListCollection;
use App\Repositories\ServiceRepository;
use App\Exceptions\NotFoundException;

class SubCategoryRepository extends BaseRepository
{
    public function __construct(SubCategory $subCategoryModel, ResponseRepository $responseRepo, ServiceRepository $serviceRepo)
    {
        $this->subCategoryModel = $subCategoryModel;
        $this->successStatusCode = config('http_status.success');
        $this->badRequestStatusCode = config('http_status.badRequest');
        $this->notFoundStatusCode = config('http_status.badRequest');
        $this->unauthorizedStatusCode = config('http_status.unauthorized');
        $this->enablePublishStatus = config('enums.enablePublishStatus');
        $this->responseRepo = $responseRepo;
        $this->serviceRepo = $serviceRepo;
        $this->perPage = config('enums.perPage');
        $this->nextId = null;
    }

    public function getSubCategory($request, $categoryId)
    {
        $subCategoryName = "subcategory_name";

        if ($request->header('Content-Language') == 'zh') {
            $subCategoryName = 'subcategory_name_zh';
        } elseif ($request->header('Content-Language') == 'mm') {
            $subCategoryName = 'subcategory_name_mm';
        }

        $category = Category::where('id', $categoryId)->where('publish_status', $this->enablePublishStatus)->first();
		if (!$category) {
            throw new NotFoundException(trans('message.notFoundMsg'));
		}
 
        $data = $this->subCategoryListByLang($categoryId, $subCategoryName, $request);
        return $this->responseRepo->successResponse($data, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function subCategoryListByLang($categoryId, $subCategoryName, $request)
    {
        $subCategories = [];
        $subCategoryList = (new SubCategoryListCollection($subCategories, $this->nextId))->subCategoryName($subCategoryName);

        if ($request->nextId != "" && $request->nextId != 'null') {

            $subCategoryQuery = $this->subCategoryModel->select('id', $subCategoryName, 'service_code')
                                                        ->where('publish_status', $this->enablePublishStatus)
                                                        ->where('category_id', $categoryId);
                                                        
            $subCategories = $this->getDataOrderedByName($subCategoryName, $request->nextId, $this->subCategoryModel, $subCategoryQuery);

            $subCategoryList = (new SubCategoryListCollection($subCategories['result'], $subCategories['nextId']))->subCategoryName($subCategoryName);
        }
        return $subCategoryList;
    }
}
