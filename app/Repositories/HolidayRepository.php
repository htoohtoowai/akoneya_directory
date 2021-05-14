<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\ResponseRepository;
use App\Http\Resources\HolidayListCollection;
use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayRepository extends BaseRepository
{
	protected $model;
    protected $request;
    protected $responseRepo;

	public function __construct(Holiday $model, Request $request, ResponseRepository $responseRepo)
	{
        $this->model = $model;
        $this->responseRepo = $responseRepo;
        $this->request = $request;
    }

    public function getHolidayList($request)
    {
        $descriptionName = "description";
        if ($this->request->header('Content-Language') == 'zh') {
            $descriptionName = 'description_zh';
        } elseif ($this->request->header('Content-Language') == 'mm') {
            $descriptionName = 'description_mm';
        }
      
        $data = $this->getHolidayListByLang($descriptionName, $request->year, $request->month);
        return $this->responseRepo->successResponse($data, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function getHolidayListByLang($descriptionName, $year, $month)
    {
        if($year && $month){
            $holidays = $this->model->select('date', $descriptionName)
                                    ->whereYear('date', $year)
                                    ->whereMonth('date', $month)
                                    ->orderBy('date','ASC')
                                    ->get();
        }
        elseif($year){
            $holidays = $this->model->select('date', $descriptionName)
                                    ->whereYear('date', $year)
                                    ->orderBy('date','ASC')
                                    ->get();
        }
        else {
            $holidays = [];
        }
        
        return (new HolidayListCollection($holidays))->descriptionName($descriptionName);
    }
}