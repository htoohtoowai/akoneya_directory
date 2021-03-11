<?php
namespace App\Repositories;

use App\Repositories\ResponseRepository;
use App\Models\FoodBlogCategory;
use App\Http\Resources\FoodBlogCategoryResourceCollection;
class FoodBlogCategoryRepository extends BaseRepository
{
    public function __construct(ResponseRepository $responseRepo)
    {
        $this->responseRepo = $responseRepo;
    }
    public function getAllCategories()
    {
        $data = FoodBlogCategory::get();
        return $this->responseRepo->successResponse(new FoodBlogCategoryResourceCollection($data),$this->responseRepo->successStatusCode, trans('message.successMsg'));
    }
}
