<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SubCategoryRepository;
use App\Repositories\CategoryRepository;

class SubCategoryController extends Controller
{
    public function __construct(SubCategoryRepository $subCategoryRepo, CategoryRepository $categoryRepo)
    {
        $this->subCategoryRepo = $subCategoryRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function getSubCategoryList(Request $request, $categoryId)
    {
        return $this->subCategoryRepo->getSubCategory($request, $categoryId);
    }
}
