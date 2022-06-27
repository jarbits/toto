<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FormulaService;
use App\RawSurvey;
use Carbon\Carbon;
use DateTime;
use DB;

class LowScoreController extends Controller
{
    public $FormulaService;
    public function __construct(Request $req)
    {
        $this->FormulaService = new FormulaService();
    }
    
    public function getTable1(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($EndMonth).'-01 00:00:00'));

        $Table = $this->FormulaService->getLowScoreTable01(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
                        
        return json_encode($Table, JSON_UNESCAPED_UNICODE);
    }

    public function getTable2(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($EndMonth+1).'-01 00:00:00'));

        $Table = $this->FormulaService->getLowScoreTable02(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
                        
        return json_encode($Table, JSON_UNESCAPED_UNICODE);
    }
}
