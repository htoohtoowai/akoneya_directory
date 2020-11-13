<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\Holiday as HolidayResource;
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
    
    public function getHolidayList($year,$month)
    {   
        if($year && $month){
            $holidays = $this->model->select('date','description')
                                    ->whereYear('date',$year)
                                    ->whereMonth('date',$month)
                                    ->orderBy('date','ASC')
                                    ->get();

        }
        elseif($year){
            $holidays = $this->model->select('date','description')
                                    ->whereYear('date',$year)
                                    ->orderBy('date','ASC')
                                    ->get();
        }
        else{
            $holidays=[];
        }
       
        $data = HolidayResource::collection($holidays);

        return $this->responseRepo->successResponse(["holidays"=>$data], $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    
}