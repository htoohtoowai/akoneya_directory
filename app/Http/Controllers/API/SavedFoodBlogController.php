<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SaveFoodBlogRepository;
class SavedFoodBlogController extends Controller
{
    public function __construct(SaveFoodBlogRepository $saveFoodBlogRepo)
    {
        $this->saveFoodBlogRepo = $saveFoodBlogRepo;
    }
    public function saveFoodBlog(Request $request, $foodBlogId)
    {
        return $this->saveFoodBlogRepo->saveFoodBlog($foodBlogId, $request->auth_user_id);
    }
    public function deleteSaveFoodBlog(Request $request, $foodBlogId)
    {
        return $this->saveFoodBlogRepo->deleteSaveFoodBlog($foodBlogId, $request->auth_user_id);
    }
}
