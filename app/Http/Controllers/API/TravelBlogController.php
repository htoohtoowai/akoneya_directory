<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TravelBlogRepository;
use App\Filters\TravelBlogFilter;

class TravelBlogController extends Controller
{
    public function __construct(TravelBlogRepository $travelBlogRepo, TravelBlogFilter $travelBlogFilter)
    {
        $this->travelBlogRepo = $travelBlogRepo;
        $this->travelBlogFilter = $travelBlogFilter;
    }
    public function getTravelBlogList(Request $request)
    {
        return $this->travelBlogRepo->getTravelBlogList($this->travelBlogFilter, $request->nextId, $request->auth_user_id);
    }
    public function getDetail($id, Request $request)
    {
        return $this->travelBlogRepo->getDetail($id, $request->auth_user_id);
    }
}
