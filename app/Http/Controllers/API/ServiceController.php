<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ServiceRepository;
use App\Filters\DirectoryServiceFilter;

class ServiceController extends Controller
{
    public function __construct(ServiceRepository $serviceRepo, DirectoryServiceFilter $serviceFilter)
    {
        $this->serviceRepo = $serviceRepo;
        $this->serviceFilter = $serviceFilter;
       
    }

    public function getServiceList($subCategoryId, Request $request)
    {
        return $this->serviceRepo->getServiceList($subCategoryId, $this->serviceFilter, $request->nextId);
    }
}
