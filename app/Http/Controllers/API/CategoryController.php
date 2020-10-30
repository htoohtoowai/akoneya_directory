<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ResponseRepository;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    public function __construct(ResponseRepository $responseRepo, CategoryRepository $categoryRepo)
    {
        $this->responseRepo = $responseRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function getCategoryList()
    {
        return $this->categoryRepo->getCategoryList();
    }

    public function getSubcategoriesByCategoryId($categoryId)
    {
        return $this->categoryRepo->getSubcategoriesByCategoryId($categoryId);
    }
}
