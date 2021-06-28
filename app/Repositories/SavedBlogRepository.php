<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Http\Resources\SavedBlogListCollection;
use App\Models\TravelBlog;
use App\Models\TravelSavedBlog;
use App\PersonalInformation;

class SavedBlogRepository extends BaseRepository
{
    public function __construct(
        TravelSavedBlog $savedModel,
        PersonalInformation $personalInfoModel,
        TravelBlog $travelBlogModel,
        ResponseRepository $responseRepo
    ) {
        $this->savedModel = $savedModel;
        $this->personalInfoModel = $personalInfoModel;
        $this->travelBlogModel = $travelBlogModel;
        $this->responseRepo = $responseRepo;
        $this->nextId = null;
        $this->clientUserId = 'client_user_id';
        $this->travelBlogId = 'travel_blog_id';
        $this->perPage = config('enums.perPage');
        $this->enablePublishStatus = config('enums.enablePublishStatus');
    }

    public function saveBlog($blogId, $clientUserId)
    {
        $travelBlog = $this->travelBlogModel->where('publish_status', $this->enablePublishStatus)->find($blogId);
        if (!$travelBlog) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }
        $savedBlogInfo = $this->savedModel->where([[$this->clientUserId, $clientUserId], [$this->travelBlogId, $blogId]])->first();
        if (empty($savedBlogInfo)) {
            $this->savedModel->create([
                $this->clientUserId => $clientUserId,
                $this->travelBlogId => $blogId,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->responseRepo->successResponse(null, $this->responseRepo->successStatusCode, trans('message.saveSuccessMsg'));
    }

    public function getSavedBlogList($request)
    {
        $savedBlogInfos = [];
        $savedBlog = [];
        $savedBlogList = new SavedBlogListCollection($savedBlogInfos, $this->nextId);
        if ($request->nextId != '' && $request->nextId != 'null') {
            $savedBlogQuery = $this->savedModel->where($this->clientUserId, $request->auth_user_id);

            $savedBlogInfos = $this->getDataByNextId('id', $request->nextId, $savedBlogQuery);

            foreach ($savedBlogInfos['result'] as $savedBlogInfo) {
                $savedBlogInfo->travelBlogInfo = $this->travelBlogModel->where('id', $savedBlogInfo->travel_blog_id)->where('publish_status', config('enums.enablePublishStatus'))->first();

                if ($savedBlogInfo->travelBlogInfo) {
                    $savedBlog[] = $savedBlogInfo;
                }
            }
            $savedBlogList = new SavedBlogListCollection($savedBlog, $savedBlogInfos['nextId']);
        }

        return $this->responseRepo->successResponse($savedBlogList, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function deleteSavedBlog($travelBlogId, $clientUserId)
    {
        $savedTravelBlogInfos = $this->savedModel->where([[$this->travelBlogId, $travelBlogId], [$this->clientUserId, $clientUserId]])->first();

        if (empty($savedTravelBlogInfos)) {
            return $this->responseRepo->failResponse(null, $this->responseRepo->notFoundStatusCode, trans('message.notFoundMsg'));
        }

        $this->savedModel->where('id', $savedTravelBlogInfos->id)->delete();

        return $this->responseRepo->successResponse(null, $this->responseRepo->successStatusCode, trans('message.deleteSuccessMsg'));
    }
}
