<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Calendar;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request)
    {
        # Get date range from - to 
        $from =  date('Y-m-d', strtotime($request->from));
        $to =  date('Y-m-d', strtotime($request->to));
        $period = CarbonPeriod::create($from, $to);

        # Get all days selected, save to array 
        $days = [];
        foreach ($request->days as $key => $value) {
            if ($value) {
                $days[] = $key;
            }
        }

        # Creating a $dates array 
        # sample output date[ 'day' => 'Monday , 'date' => '2020-05-09']
        $dates = [];
        foreach ($period as $date) {
            $dates[] = ['day' => Carbon::parse($date)->englishDayOfWeek, 'date' => $date->format('Y-m-d')];
        }

        foreach ($dates as $value) {
            if(count($days)){   // count if days exist in the request
                if (in_array($value['day'], $days)) {   // filter all selected days on date range 
                    Calendar::updateOrCreate([  // insert all pass value
                        'title' => $request->event,
                        'date'  => $value['date']
                    ]);
                }
            } else {    // count if days !exist in the request
                Calendar::updateOrCreate([  // insert all value
                    'title' => $request->event,
                    'date'  => $value['date']
                ]); 
            }

        }
    }

    public function getEvent()
    {
        # Get all event save to database
        $event = Calendar::all()->map(function($event){
            return [
                'title' => $event->title,
                'date' => $event->date
            ];
        });
        return response()->json($event, 200);
    }
}
