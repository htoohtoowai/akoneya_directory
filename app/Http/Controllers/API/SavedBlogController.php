<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SavedBlogRepository;

class SavedBlogController extends Controller
{
    public function __construct(SavedBlogRepository $savedRepo)
    {
        $this->savedRepo  = $savedRepo;
    }

    public function saveBlog(Request $request, $blogId)
    {
        return $this->savedRepo->saveBlog($blogId, $request->auth_user_id);
    }

    public function getSavedBlogList(Request $request)
    {
        return $this->savedRepo->getSavedBlogList($request);
    }

    public function deleteSavedBlog($travelBlogId, Request $request)
    {
        return $this->savedRepo->deleteSavedBlog($travelBlogId, $request->auth_user_id);
    }
}
