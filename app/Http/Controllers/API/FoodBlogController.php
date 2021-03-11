<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TravelBlogRepository;
use App\Filters\TravelBlogFilter;

class FoodBlogController extends Controller
{
    public function __construct(TravelBlogRepository $travelBlogRepo, TravelBlogFilter $travelBlogFilter)
    {
        $this->travelBlogRepo = $travelBlogRepo;
        $this->travelBlogFilter = $travelBlogFilter;
    }
    
}
