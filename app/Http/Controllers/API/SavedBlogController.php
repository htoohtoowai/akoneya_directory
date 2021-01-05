<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SavedBlogRepository;
use App\Http\Requests\CreateSavedBlogRequest;

class SavedBlogController extends Controller
{
    public function __construct(SavedBlogRepository $savedRepo)
    {
        $this->savedRepo  = $savedRepo;
        $this->perPage = config('enums.perPage');
    }

    public function createSavedBlog(CreateSavedBlogRequest $request)
    {
        $clientUserId = $request->auth_user_id;
        return $this->savedRepo->createSavedBlog($request, $clientUserId);
    }

    public function getSavedBlogList(Request $request)
    {
        return $this->savedRepo->getSavedBlogList($request, $this->perPage);
    }

    public function deleteSavedBlog($travelBlogId, Request $request)
    {
        return $this->savedRepo->deleteSavedBlog($travelBlogId, $request->auth_user_id);
    }
}
