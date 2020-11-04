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
    }
    
    public function getCategoryList()
    {
        if ($this->request->header('Content-Language') == 'zh'){
            $categories = $this->categoryListByLang('category_name_zh');

        }  elseif ($this->request->header('Content-Language') == 'mm'){
            $categories = $this->categoryListByLang('category_name_mm');

        } else {
            $categories = $this->categoryListByLang('category_name');
        }

        $paginator = $this->model->where('deleted_status', $this->disableDeletedStatus)->paginate($this->perPage);

        return $this->responseRepo->successResponse(new CategoryListCollection($categories, $paginator), $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function categoryListByLang($categoryName)
    {
        $categories = $this->model->select('id', $categoryName,'image')
                        ->where('deleted_status', $this->disableDeletedStatus)
                        ->orderBy($categoryName)
                        ->paginate($this->perPage);

        $data =[];
        foreach ($categories as $key =>  $category) {
            $data[$key]['id'] = $category->id;
            $data[$key]['name'] = $category->$categoryName;
            $data[$key]['logo'] = $category->image;
            $data[$key]['totalContent'] = $this->getSubCategoryCount($category->id);
        }

        return $data;
    }

    public function getSubCategoryCount($categoryId)
    {
        return $this->subCategoryModel->where('category_id', $categoryId)->where('deleted_status', $this->disableDeletedStatus)->count();
    }
}