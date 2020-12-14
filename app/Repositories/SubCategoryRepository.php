<?php
namespace App\Repositories;

use App\Models\SubCategory;
use App\Repositories\ResponseRepository;
use App\Http\Resources\SubCategoryListCollection;
use App\Repositories\ServiceRepository;

class SubCategoryRepository extends BaseRepository
{
    public function __construct(SubCategory $subCategory, ResponseRepository $responseRepo, ServiceRepository $serviceRepo)
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

        $subCategories = $this->subCategoryListByLang($categoryId, $subCategoryName, $request);
        $data = (new SubCategoryListCollection($subCategories, $this->nextId))->subCategoryName($subCategoryName);

        return $this->responseRepo->successResponse($data, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function subCategoryListByLang($categoryId, $categoryName, $request)
    {
        $subCategories = [];
        $subCategoryQuery = $this->subCategory->select('id', $categoryName, 'service_code')
                                            ->where('deleted_status', $this->disableDeletedStatus)
                                            ->where('category_id', $categoryId);

        if ($request->nextId != "" && $request->nextId != 'null') {
            if ($request->nextId != 0) {
                $nextData = $this->subCategory->find($request->nextId);
                if ($nextData) {
                    $subCategories =$subCategoryQuery->where($categoryName, '>=', $nextData->$categoryName);
                }
            }
            $subCategories = $subCategoryQuery->orderBy($categoryName)->limit($this->perPage+1)->get();
            $paginationCount = $subCategories->count();
            if ($paginationCount > $this->perPage) {
                $this->nextId  = $subCategories[$this->perPage]->id;
           
                unset($subCategories[$paginationCount - 1]);
            }
        }
        return $subCategories;
    }
}
