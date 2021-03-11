<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FoodBlogRepository;
use App\Filters\FoodBlogFilter;

class FoodBlogController extends Controller
{
    public function __construct(FoodBlogRepository $foodBlogRepo, FoodBlogFilter $foodBlogFilter)
    {
        $this->foodBlogRepo = $foodBlogRepo;
        $this->foodBlogFilter = $foodBlogFilter;
    }
    public function getFoodBlogList(Request $request)
    {
        $clientUserId = $this->foodBlogRepo->checkAuthExistOrNot($request);

        return $this->foodBlogRepo->getFoodBlogList($this->foodBlogFilter, $request->nextId, $clientUserId);
    }

    public function getFoodBlogDetail($id, Request $request)
    {
        $clientUserId = $this->foodBlogRepo->checkAuthExistOrNot($request);
        return $this->foodBlogRepo->getFoodBlogDetail($id, $clientUserId);
    }
}
