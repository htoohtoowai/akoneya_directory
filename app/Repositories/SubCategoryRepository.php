<?php
namespace App\Repositories;
use App\Models\SubCategory;


class SubCategoryRepository extends BaseRepository
{   

    public function __construct(SubCategory $subCategory)
    {
        $this->subCategory = $subCategory;
        $this->successStatusCode = config('http_status.success');
        $this->badRequestStatusCode = config('http_status.badRequest');
        $this->notFoundStatusCode = config('http_status.badRequest');
        $this->unauthorizedStatusCode = config('http_status.unauthorized');
    }

    public function getSubCategory()
    {
        $subCategory = $this->subCategory->get();

        return $subCategory;
      
    }
}
