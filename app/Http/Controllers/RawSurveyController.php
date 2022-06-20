<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RawSurvey;

class RawSurveyController extends Controller
{
    public function update(Request $req)
    {
        try {
            $_respondentId = $req->respondent_id;
            $_sircommend = $req->sircommend;
            $survey = RawSurvey::where('respondent_id', $_respondentId)->first();
            
            $survey->sircommend = $_sircommend;
            $survey->save();

            return json_encode('success', JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return json_encode($th, JSON_UNESCAPED_UNICODE);
        }
        
    }

    public function get(Request $req)
    {
        try {
            $_respondentId = $req->respondent_id;
            $survey = RawSurvey::where('respondent_id', $_respondentId)->first();

            return json_encode([$survey], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return json_encode($th, JSON_UNESCAPED_UNICODE);
        }
        
    }
}
