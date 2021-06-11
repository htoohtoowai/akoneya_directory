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
    protected $responseRepo;

	public function __construct(Holiday $model, ResponseRepository $responseRepo)
	{
        $this->model = $model;
        $this->responseRepo = $responseRepo;
        $this->enabledHolidayStatus = config('enums.enabledHolidayStatus');
    }

    public function isHoliday($holidays)
    {
        foreach ($holidays as $holiday) {
            $holiday->isHoliday = ($holiday->is_holiday == $this->enabledHolidayStatus ? true : false);
        } 
        return $holidays;
    }

    public function getHolidayList($year, $month)
    {
        if ($year && $month){
            $holidays = $this->model->whereYear('date', $year)
                                    ->whereMonth('date', $month)
                                    ->orderBy('date','ASC')
                                    ->get();
            $holidayList = $this->isHoliday($holidays);                    
        }
        elseif ($year){
            $holidays = $this->model->whereYear('date', $year)
                                    ->orderBy('date','ASC')
                                    ->get();
            $holidayList = $this->isHoliday($holidays);      
        }
        else {
            $holidayList = [];
        }

        $data = HolidayResource::collection($holidayList);
        return $this->responseRepo->successResponse(["holidays" => $data], $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }
}