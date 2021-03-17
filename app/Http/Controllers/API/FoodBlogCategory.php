<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FoodBlogCategoryRepository;
class FoodBlogCategory extends Controller
{
    public function __construct(FoodBlogCategoryRepository $foodBlogCategoryRepo)
    {
       $this->foodBlogCategoryRepo = $foodBlogCategoryRepo;
    }
    public function getAllCategories()
    {
        return $this->foodBlogCategoryRepo->getAllCategories();
    }
}
