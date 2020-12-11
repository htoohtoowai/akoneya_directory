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
        $this->disableDeletedStatus = config('enums.disableDeletedStatus');
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
      
        $categories = $this->categoryListByLang($categoryName, $request);
        $data = (new CategoryListCollection($categories, $this->nextId))->categoryName($categoryName);
        return $this->responseRepo->successResponse($data, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function categoryListByLang($categoryName, $request)
    {
        if ($request->nextId == "" || $request->nextId == 'null') {
            $categories = [];
        } else {
            $categories = $this->model->select('id', $categoryName, 'image', 'primary_color_code', 'secondary_color_code')
                                        ->where(function ($q) use ($request) {
                                            if ($request->nextId !=0) {
                                                $q->where('directory_categories.id', '<=', $request->nextId);
                                            }
                                        })
                                        ->where('deleted_status', $this->disableDeletedStatus)
                                        ->orderBy('id', 'DESC')
                                        ->limit($this->perPage+1)
                                        ->get();
            $paginationCount = $categories->count();
            if ($paginationCount > $this->perPage) {
                $this->nextId  = $categories[$this->perPage]->id;
           
                unset($categories[$paginationCount - 1]);
            }
        }
        return $categories;
    }
}
