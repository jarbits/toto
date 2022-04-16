<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RawSurvey;
use DB;

class AdvanceMenuController extends Controller
{
    public function selectLV1()
    {
        $Data = [
            'data' => 
            [
                [
                    'key'=>'區域',
                    'value'=>'區域',
                ],
                [
                    'key'=>'經銷',
                    'value'=>'經銷',
                ],
                [
                    'key'=>'售服員',
                    'value'=>'售服員',
                ]
            ],
            'next' => 'true'
        ];
        
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    public function selectLV2(Request $req)
    {
        $Data = ['data'=>[]];
        $menu = $req->menu;
        if ($menu == '區域') {
            $Set = DB::select("
                SELECT DISTINCT(s_region) FROM rawsurvey AS T
            ");

            foreach ($Set as $key => $value) {
                array_push($Data['data'], ['key'=>$value->s_region, 'value'=>$value->s_region]);
            }
            $Data['next'] = 'false';
        }
        if ($menu == '經銷') {
            $Set = DB::select("
                SELECT DISTINCT(s_person) FROM rawsurvey AS T
            ");

            $isExist = [];
            foreach ($Set as $key => $value) {
                $Catgory =  explode('-', $value->s_person)[0];
                if (!in_array($Catgory, $isExist)) {
                    array_push($isExist, $Catgory);
                    array_push($Data['data'], [ 'key'=>$Catgory, 'value'=>$Catgory ]);
                }
            }
            $Data['next'] = 'false';
        }
        if ($menu == '售服員') {
            // $Set = DB::select("
            //     SELECT DISTINCT(s_category) FROM rawsurvey AS T
            // ");
            $Set = DB::select("
                SELECT DISTINCT(s_person) FROM rawsurvey AS T
            ");

            // foreach ($Set as $key => $value) {
            //     array_push($Data['data'], ['key'=>$value->s_category, 'value'=>$value->s_category]);
            // }

            $isExist = [];
            foreach ($Set as $key => $value) {
                $Catgory =  explode('-', $value->s_person)[0];
                if (!in_array($Catgory, $isExist)) {
                    array_push($isExist, $Catgory);
                    array_push($Data['data'], [ 'key'=>$Catgory, 'value'=>$Catgory ]);
                }
            }
            $Data['next'] = 'true';
        }
        
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    public function selectLV3(Request $req)
    {
        $Data = ['data'=>[]];
        $menu = $req->menu;
        $category = $req->category;
        if ($menu == '售服員') {
            $Set = DB::select("
                SELECT DISTINCT(s_person) FROM rawsurvey AS T
                WHERE 1=1
                AND T.s_category = '".$category."'
            ");

            foreach ($Set as $key => $value) {
                array_push($Data['data'], ['key'=>$value->s_person, 'value'=>$value->s_person]);
            }
            $Data['next'] = 'false';
        }
        
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }
}
