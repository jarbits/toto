<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FormulaService;
use App\RawSurvey;
use Carbon\Carbon;
use DateTime;
use DB;

class DeficiencyController extends Controller
{
    public $FormulaService;
    public function __construct(Request $req)
    {
        $this->FormulaService = new FormulaService();
    }

    /**
     * 整體：[Q8]不為空白的總數
     */
    public function getChart1(Request $req)
    {
        $Q8NumVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

            $Q8s = $this->FormulaService->getQ8isNotNullSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q8Num = count($Q8s);
            array_push($Q8NumVec, $Q8Num);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }
        
        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '整體',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    public function getChart2(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart3(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart4(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart5(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart6(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart7(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart8(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart9(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart10(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }
    
    public function getChart11(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart12(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart13(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart14(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart15(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart16(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart17(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart18(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart19(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart20(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart21(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart22(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart23(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart24(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart25(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }

    public function getChart26(Request $req)
    {
        $Data = ['OK'];
        return json_encode($Data);
    }
}
