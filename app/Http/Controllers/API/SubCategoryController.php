<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SubcategoryRepository;
use App\Repositories\CategoryRepository;

class SubCategoryController extends Controller
{
    public function __construct(SubcategoryRepository $subCategoryRepo, CategoryRepository $categoryRepo)
    {
        $this->subCategoryRepo = $subCategoryRepo;
        $this->categoryRepo = $categoryRepo;
       
        $this->itemPerPage = config('enums.itemPerPage');
    }

    public function index(DirectorySubcategoryFilter $filter)
    {
        $subCategoryInfos = $this->subCategoryRepo->getSubCategory($filter,$this->itemPerPage);
        $directoryCategory = $this->directoryCategoryRepo->getDirectoryCategory();
        return view('directory.directory_subcategories.index',compact('subCategoryInfos','directoryCategory'));
    }
}
