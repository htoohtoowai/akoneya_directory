<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\HolidayCollection;
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
        $holidays = $this->model->select('date','description')
                        ->whereYear('date',$year)
                        ->orderBy('date','DESC')
                        ->paginate($this->perPage);

        $data = new HolidayCollection($holidays);

        return $this->responseRepo->successResponse($data, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    
}