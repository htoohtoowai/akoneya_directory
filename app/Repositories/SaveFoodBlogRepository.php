<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Http\Resources\SavedFoodBlogResourceCollection;
use App\Models\FoodBlog;
use App\Models\FoodSavedBlog;

class SaveFoodBlogRepository extends BaseRepository
{
    public function __construct(FoodSavedBlog $foodSavedBlogModel, ResponseRepository $responseRepo, FoodBlog $foodBlogModel)
    {
        $this->foodSavedBlogModel = $foodSavedBlogModel;
        $this->foodBlogModel = $foodBlogModel;
        $this->responseRepo = $responseRepo;
        $this->nextId = null;
        $this->perPage = config('enums.perPage');
        $this->enablePublishStatus = config('enums.enablePublishStatus');
    }

    public function saveFoodBlog($foodBlogId, $authUserId)
    {
        $foodBlog = FoodBlog::where('id', $foodBlogId)->where('publish_status', $this->enablePublishStatus)->first();
        if (!$foodBlog) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }
        $savedFoodBlog = $this->foodSavedBlogModel->where('client_user_id', $authUserId)->where('food_id', $foodBlogId)->first();
        if (!$savedFoodBlog) {
            $this->foodSavedBlogModel->create([
                'client_user_id' => $authUserId,
                'food_id' => $foodBlogId,
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

    public function getSavedFoodBlogList($authUserId, $nextId)
    {
        $savedFoodBlog = [];
        $savedFoodBlogList = new SavedFoodBlogResourceCollection($savedFoodBlog, $this->nextId);
        $savedBlog = [];
        if ($nextId != '' && $nextId != 'null') {
            $savedFoodBlogQuery = $this->foodSavedBlogModel->where('client_user_id', $authUserId);

            $savedFoodBlogs = $this->getDataByNextId('id', $nextId, $savedFoodBlogQuery);

            foreach ($savedFoodBlogs['result'] as $savedFoodBlog) {
                $savedFoodBlog->foodBlog = $this->foodBlogModel->where('id', $savedFoodBlog->food_id)->where('publish_status', config('enums.enablePublishStatus'))->first();
                if ($savedFoodBlog->foodBlog) {
                    $savedBlog[] = $savedFoodBlog;
                }
            }
            $savedFoodBlogList = new SavedFoodBlogResourceCollection($savedBlog, $savedFoodBlogs['nextId']);
        }

        return $this->responseRepo->successResponse($savedFoodBlogList, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }
}
