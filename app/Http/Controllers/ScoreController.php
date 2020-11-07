<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Score;

use App\Http\Resources\Score as ScoreResource;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get Users
        $scores = Score::orderBy('creation_date', 'desc')->orderBy('creation_time', 'desc')->get();

        //Get score collection
        $scoreCollection = ScoreResource::collection($scores);

        //Get Todays Score Count
        $todayCount = Score::where('creation_date', date('Y-m-d'))->count();

        //Return collection of scores as resource
        return [$scoreCollection, $todayCount];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $scoreMin = $request->input('scoreMin');
        $scoreMax = $request->input('scoreMax');

        $generatedScore = mt_rand($scoreMin, $scoreMax);

        $score = Score::create([
            'scores' => $generatedScore,
            'creation_date' => date('Y-m-d'),
            'creation_time' => date('h:i:s')
        ]); 

        echo json_encode(['score' => $score]);
    }
}
