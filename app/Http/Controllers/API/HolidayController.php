<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\HolidayRepository;

class HolidayController extends Controller
{
    public function __construct(HolidayRepository $holidayRepo)
    {
        $this->holidayRepo = $holidayRepo;
      
    }
    public function getHolidays(Request $request)
    {
    	return $this->holidayRepo->getHolidayList($request->year);
    }
}
