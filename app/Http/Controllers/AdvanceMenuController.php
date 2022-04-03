<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RawSurvey;
use DB;

class AdvanceMenuController extends Controller
{
    public function regionLV1()
    {
        $Data = [];

        $Set = DB::select("
            SELECT DISTINCT(s_region) FROM rawsurvey AS T
        ");

        foreach ($Set as $key => $value) {
            array_push($Data, ['key'=>$value->s_region, 'value'=>$value->s_region]);
        }
        
        return json_encode($Data);
    }

    public function categoryLV2(Request $req)
    {
        $Data = [];
        $Set = DB::select("
            SELECT DISTINCT(s_category) FROM rawsurvey AS T
            WHERE 1=1
            AND T.s_region = '".$req->Region."'
        ");
        foreach ($Set as $key => $value) {
            array_push($Data, ['key'=>$value->s_category, 'value'=>$value->s_category]);
        }

        return $Set;
    }

    public function personLV3(Request $req)
    {
        $Data = [];
        $Set = DB::select("
            SELECT DISTINCT(s_person) FROM rawsurvey AS T
            WHERE 1=1
            AND T.s_region = '".$req->Region."'
            AND T.s_region = '".$req->Category."'
        ");
        foreach ($Set as $key => $value) {
            array_push($Data, ['key'=>$value->s_person, 'value'=>$value->s_person]);
        }

        return $Set;
    }
}
