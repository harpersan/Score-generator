<?php

namespace App\Http\Controllers\API;

use App\Score;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class ScoreController extends Controller
{
    public function generateScore()
    {
        $random_score = rand(1, 20);
        Score::create(['score' => $random_score]); // Generate Random Number
    }

    public function getScore(Request $request)
    {
        $data = [];
        $label = [];
        if ($request->type == 'TIME') { // time score was generated
            $score = Score::all()->map(function ($score) {
                return [
                    'label' => Carbon::parse($score->created_at)->isoFormat('dddd h:mm:ss a'),
                    'data' => $score->score
                ];
            });

            foreach ($score as $value) {
                $label[] = $value['label'];
                $data[]  = $value['data'];
            }

            return response()->json(['label' => $label, 'data' => $data], 200);

        } else { // number of times a score was generated per day

            $score = Score::select('score', DB::raw("COUNT(score) as count"), DB::raw("DAY(created_at) as day"))
                ->groupBy('score', DB::raw("DAY(created_at)"))->get();

            foreach ($score as $value) {
                $label[] = 'Score:' . $value['count'] . ' Day:' . Carbon::parse($value['day'])->englishDayOfWeek;
                $data[]  = $value['score'];
            }

            return response()->json(['label' => $label, 'data' => $data], 200);
        }
    }
}
