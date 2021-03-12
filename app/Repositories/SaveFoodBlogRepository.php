<?php
namespace App\Repositories;

use App\Models\FoodSavedBlog;
use App\Models\FoodBlog;
use App\Repositories\ResponseRepository;
use App\Exceptions\NotFoundException;

class SaveFoodBlogRepository extends BaseRepository
{
    public function __construct(FoodSavedBlog $foodSavedBlogModel, ResponseRepository $responseRepo)
    {
        $this->foodSavedBlogModel = $foodSavedBlogModel;
        $this->responseRepo = $responseRepo;
    }
    public function saveFoodBlog($foodBlogId, $authUserId)
    {
        $foodBlog = FoodBlog::where('id', $foodBlogId)->first();
        if (!$foodBlog) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }
        $savedFoodBlog = $this->foodSavedBlogModel->where('client_user_id', $authUserId)->where('food_id', $foodBlogId)->first();
        if (!$savedFoodBlog) {
            $this->foodSavedBlogModel->create([
                'client_user_id' => $authUserId,
                'food_id' => $foodBlogId
            ]);
        }
        return $this->responseRepo->successResponse(null, $this->responseRepo->successStatusCode, trans('message.saveSuccessMsg'));
    }
    public function deleteSaveFoodBlog($foodBlogId, $authUserId)
    {
        $savedFoodBlog = $this->foodSavedBlogModel->where('client_user_id', $authUserId)->where('food_id', $foodBlogId)->first();
        if (!$savedFoodBlog) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }
        $savedFoodBlog->delete();
        return $this->responseRepo->successResponse(null, $this->responseRepo->successStatusCode, trans('message.deleteSuccessMsg'));

    }
}
