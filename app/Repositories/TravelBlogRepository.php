<?php

namespace App\Repositories;

use App\Repositories\ResponseRepository;
use App\Models\TravelBlog;
use App\Http\Resources\TravelBlogResourceCollection;
use App\Models\TravelSavedBlog;
use App\Exceptions\NotFoundException;

class TravelBlogRepository extends BaseRepository
{
    public function __construct(ResponseRepository $responseRepo)
    {
        $this->responseRepo = $responseRepo;
        $this->disableDeletedStatus = config('enums.disableDeletedStatus');
        $this->perPage = config('enums.perPage');
        $this->nextId = null;
    }

    public function getTravelBlogList($filter, $nextId, $clientUserId)
    {
        $travelBlogInformation = [];

        if ($nextId != ""  && $nextId != 'null') {
            $travelBlogInformationQuery = TravelBlog::filter($filter);

            if ($nextId != 0) {
                $nextData = TravelBlog::find($nextId);
                if ($nextData) {
                    $travelBlogInformationQuery = $travelBlogInformationQuery->where('title', ">=", $nextData->name);
                }
            }
           
            $travelBlogInformation = $travelBlogInformationQuery->orderBy('title')
                                    ->limit($this->perPage+1)
                                    ->where('deleted_status', $this->disableDeletedStatus)
                                    ->get();
          
            $paginationCount = $travelBlogInformation->count();
            if ($paginationCount > $this->perPage) {
                $this->nextId  = $travelBlogInformation[$this->perPage]->id;
                
                unset($travelBlogInformation[$paginationCount - 1]);
            }
          
            foreach ($travelBlogInformation as $key => $value) {
                $travelBlogInformation[$key]['isSaved'] = (TravelSavedBlog::where('client_user_id', $clientUserId)->where('travel_blog_id', $value['id'])->first() != null);
            }
        }
        return $this->responseRepo->successResponse(new TravelBlogResourceCollection($travelBlogInformation, $this->nextId), $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function getDetail($id, $clientUserId)
    {
        $travelBlog = TravelBlog::find($id);
        if (!$travelBlog) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }
    }
}
