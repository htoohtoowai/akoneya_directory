<?php
namespace App\Repositories;

use App\Models\FoodSavedBlog;
use App\Models\FoodBlog;
use App\Repositories\ResponseRepository;
use App\Exceptions\NotFoundException;
use App\Http\Resources\SavedFoodBlogResourceCollection;

class SaveFoodBlogRepository extends BaseRepository
{
    public function __construct(FoodSavedBlog $foodSavedBlogModel, ResponseRepository $responseRepo)
    {
        $this->foodSavedBlogModel = $foodSavedBlogModel;
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
    public function getSavedFoodBlogList($authUserId, $nextId)
    {
        $savedFoodBlog = [];
        $savedFoodBlogList = new SavedFoodBlogResourceCollection($savedFoodBlog, $this->nextId);

        if ($nextId != "" && $nextId != 'null') {
            $savedFoodBlogQuery =  $this->foodSavedBlogModel->where('client_user_id', $authUserId);
            
            $savedFoodBlog = $this->getDataByNextId('id', $nextId, $savedFoodBlogQuery);
           
            $savedFoodBlogList = new SavedFoodBlogResourceCollection($savedFoodBlog['result'], $savedFoodBlog['nextId']);
        }
        return $this->responseRepo->successResponse($savedFoodBlogList, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }
}
