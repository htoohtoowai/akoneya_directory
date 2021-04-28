<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\CategoryListCollection;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryRepository extends BaseRepository
{
    protected $model;
    protected $subCategoryModel;
    protected $request;
    protected $responseRepo;

    public function __construct(Category $model, SubCategory $subCategoryModel, Request $request, ResponseRepository $responseRepo)
    {
        $this->model = $model;
        $this->subCategoryModel = $subCategoryModel;
        $this->request = $request;
        $this->responseRepo = $responseRepo;
        $this->perPage = config('enums.perPage');
        $this->enablePublishStatus = config('enums.enablePublishStatus');
        $this->nextId = null;
    }
    
    public function getCategoryList($request)
    {
        $categoryName = "category_name";

        if ($this->request->header('Content-Language') == 'zh') {
            $categoryName = 'category_name_zh';
        } elseif ($this->request->header('Content-Language') == 'mm') {
            $categoryName = 'category_name_mm';
        }
      
        $data =  $this->categoryListByLang($categoryName, $request);
        return $this->responseRepo->successResponse($data, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function categoryListByLang($categoryName, $request)
    {
        $categories = [];
        $categoryList = (new CategoryListCollection($categories, $this->nextId))->categoryName($categoryName);
        
        if ($request->nextId != "" && $request->nextId != 'null') {

            $categoryQuery =  $this->model->select('id', $categoryName, 'image', 'primary_color_code', 'secondary_color_code')->where('publish_status', $this->enablePublishStatus);
            
            $categories = $this->getDataOrderedByName($categoryName, $request->nextId, $this->model, $categoryQuery);
           

            $categoryList = (new CategoryListCollection($categories['result'], $categories['nextId']))->categoryName($categoryName);
        }

        return $categoryList;
    }
}
