<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\CategoryListCollection;
use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayRepository extends BaseRepository
{
	protected $model;
    protected $request;
    protected $responseRepo;

	public function __construct(Holiday $model,  ResponseRepository $responseRepo)
	{
        $this->model = $model;
        $this->responseRepo = $responseRepo;
        $this->perPage = config('enums.perPage');
        $this->disableDeletedStatus = config('enums.disableDeletedStatus');
    }
    
    public function getHolidayList($year)
    {
        $holidays = $this->model
                        ->whereYear('date',$year)
                        ->orderBy('date','DESC')
                        ->paginate($this->perPage);

        return $this->responseRepo->successResponse($holidays, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    
}