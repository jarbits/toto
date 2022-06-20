<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RawSurvey;

class RawSurveyController extends Controller
{
    public function update(Request $req)
    {
        try {
            $_acceptanceCode = $req->acceptance_code;
            $_sircommend = $req->sircommend;
            $survey = RawSurvey::where('acceptance_code', $_acceptanceCode)->first();
            
            $survey->sircommend = $_sircommend;
            $survey->save();

            $survey = RawSurvey::where('acceptance_code', $_acceptanceCode)->first();

            return json_encode($survey, JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return json_encode($th, JSON_UNESCAPED_UNICODE);
        }
        
    }

    public function get(Request $req)
    {
        try {
            $_acceptanceCode = $req->acceptance_code;
            $survey = RawSurvey::where('acceptance_code', $_acceptanceCode)->first();

            return json_encode($survey, JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return json_encode($th, JSON_UNESCAPED_UNICODE);
        }
        
    }
}
