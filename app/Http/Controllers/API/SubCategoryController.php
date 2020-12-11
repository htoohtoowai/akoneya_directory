<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SubCategoryRepository;

class SubCategoryController extends Controller
{
    public function __construct(SubCategoryRepository $subCategoryRepo)
    {
        $this->subCategoryRepo = $subCategoryRepo;
    }

    public function getSubCategoryList(Request $request, $categoryId)
    {
        return $this->subCategoryRepo->getSubCategory($request, $categoryId);
    }
}
