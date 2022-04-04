<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FormulaService;
use App\RawSurvey;
use Carbon\Carbon;
use DateTime;
use DB;

class SimpleClass
{
    public $item = "";
    public $firstHalf = "";
    public $secondHalf = "";
    public $all = "";
};

class StatisticsController extends Controller
{
    public $FormulaService;
    public function __construct(Request $req)
    {
        $this->FormulaService = new FormulaService();
    }

    /**
     * 取得滿意度(Q1)百分比Chart(滿意度)
     * endpoint: /api/statistics/getChart1?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart1(Request $req)
    {
        $Q1RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q1s = $this->FormulaService->getQ1big4Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Qs = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q1Num = count($Q1s);
            $RawSurveyNum = count($Qs);
            $Q1Rate = 0;
            try {
                $Q1Rate = round($Q1Num/$RawSurveyNum, 1)*100;
            } catch (\Throwable $th) {}

            array_push($Q1RateVec, $Q1Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }
        
        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '滿意度',
                'data' => $Q1RateVec
            ]
            
        ];
        return json_encode($Data);
    }

    /**
     * 取得滿意度(Q1)為5分的百分比(感動率)
     * endpoint: /api/statistics/getChart2?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart2(Request $req)
    {
        $Q1RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q1s = $this->FormulaService->getQ1is5Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Qs = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q1Num = count($Q1s);
            $RawSurveyNum = count($Qs);
            $Q1Rate = 0;
            try {
                $Q1Rate = round($Q1Num/$RawSurveyNum, 1)*100;
            } catch (\Throwable $th) {}
            
            array_push($Q1RateVec, $Q1Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '感動率',
                'data' => $Q1RateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * 取得Q13計算該題目分數各項資料占筆的平均0-6,7-8,9-10(NPS Line Chart)
     * endpoint: /api/statistics/getChart3?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart3(Request $req)
    {
        $Calender = array();
        $NPSLineVec = array();
        $p0_6BarVec = array();
        $p7_8BarVec = array();
        $p9_10BarVec = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;

        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

            $Qs = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $p0_6Bar = $this->FormulaService->getQ13_0_6Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $p7_8Bar = $this->FormulaService->getQ13_7_8Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $p9_10Bar = $this->FormulaService->getQ13big9Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $p0_6Line = $this->FormulaService->getQ13_0_6Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
  
            $p9_10Line = $this->FormulaService->getQ13big9Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $RawSurveyNum = count($Qs);
            $p0_6BarRate = 0;
            $p7_8BarRate = 0;
            $p9_10BarRate = 0;
            $p0_6LineRate = 0;
            $p9_10LineRate = 0;

            try {
                $p0_6BarRate = round(count($p0_6Bar)/$RawSurveyNum, 1)*100;
                $p7_8BarRate = round(count($p7_8Bar)/$RawSurveyNum, 1)*100;
                $p9_10BarRate = round(count($p9_10Bar)/$RawSurveyNum, 1)*100;
                $p0_6LineRate = round(count($p0_6Line)/$RawSurveyNum, 1)*100;
                $p9_10LineRate = round(count($p9_10Line)/$RawSurveyNum, 1)*100;
            } catch (\Throwable $th) {
                //throw $th;
            }

            $NPSLine = abs($p0_6LineRate - $p9_10LineRate);
            
            array_push($p0_6BarVec, $p0_6BarRate);
            array_push($p7_8BarVec, $p7_8BarRate);
            array_push($p9_10BarVec, $p9_10BarRate);
            array_push($NPSLineVec, $NPSLine);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => 'NPS',
                'data' => $NPSLineVec
                // 'data' => [
                //     'p0_6bar' => $p0_6BarVec,
                //     'p7_8bar' => $p7_8BarVec,
                //     'p9_10bar' => $p9_10BarVec,
                //     'npsline' => $NPSLineVec,
                // ]
            ]
        ];            
        return json_encode($Data);
    }

    /**
     * Q1所有回答之分數平均(整體滿意度)
     * endpoint: /api/statistics/getChart4?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart4(Request $req)
    {
        $Q1RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q1s = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q1Num = 0;
            foreach ($Q1s as $Q) {
                $Q1Num += intval($Q->q1);
            }
            $RawSurveyNum = count($Q1s);
            $Q1Rate = 0;
            try {
                $Q1Rate = round($Q1Num/$RawSurveyNum, 2);
            } catch (\Throwable $th) {}
            
            array_push($Q1RateVec, $Q1Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '整體滿意度',
                'data' => $Q1RateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q2所有回答之分數平均(0800接聽服務品質)
     * endpoint: /api/statistics/getChart5?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart5(Request $req)
    {
        $Q2RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q2s = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q2Num = 0;
            foreach ($Q2s as $Q) {
                $Q2Num += intval($Q->q2);
            }
            $RawSurveyNum = count($Q2s);
            $Q2Rate = 0;
            try {
                $Q2Rate = round($Q2Num/$RawSurveyNum, 2);
            } catch (\Throwable $th) {}
            
            array_push($Q2RateVec, $Q2Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '0800接聽服務品質',
                'data' => $Q2RateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q3所有回答之分數平均(維修安排速度)
     * endpoint: /api/statistics/getChart6?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart6(Request $req)
    {
        $Q3RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q3s = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q3Num = 0;
            foreach ($Q3s as $Q) {
                $Q3Num += intval($Q->q3);
            }
            $RawSurveyNum = count($Q3s);
            $Q3Rate = 0;
            try {
                $Q3Rate = round($Q3Num/$RawSurveyNum, 2);
            } catch (\Throwable $th) {}
            
            array_push($Q3RateVec, $Q3Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '維修安排速度',
                'data' => $Q3RateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q5所有回答之分數平均(維修人員服務態度)
     * endpoint: /api/statistics/getChart7?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart7(Request $req)
    {
        $Q5RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q5s = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q5Num = 0;
            foreach ($Q5s as $Q) {
                $Q5Num += intval($Q->q5);
            }
            $RawSurveyNum = count($Q5s);
            $Q5Rate = 0;
            try {
                $Q5Rate = round($Q5Num/$RawSurveyNum, 2);
            } catch (\Throwable $th) {}
            
            array_push($Q5RateVec, $Q5Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '維修人員服務態度',
                'data' => $Q5RateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q9所有回答之分數平均(講解故障原因)
     * endpoint: /api/statistics/getChart8?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart8(Request $req)
    {
        $Q9RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q9s = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q9Num = 0;
            foreach ($Q9s as $Q) {
                $Q9Num += intval($Q->q9);
            }
            $RawSurveyNum = count($Q9s);
            $Q9Rate = 0;
            try {
                $Q9Rate = round($Q9Num/$RawSurveyNum, 2);
            } catch (\Throwable $th) {}
            
            array_push($Q9RateVec, $Q9Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '講解故障原因',
                'data' => $Q9RateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q10所有回答之分數平均(維修技術)
     * endpoint: /api/statistics/getChart9?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart9(Request $req)
    {
        $Q10RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q10s = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q10Num = 0;
            foreach ($Q10s as $Q) {
                $Q10Num += intval($Q->q10);
            }
            $RawSurveyNum = count($Q10s);
            $Q10Rate = 0;
            try {
                $Q10Rate = round($Q10Num/$RawSurveyNum, 2);
            } catch (\Throwable $th) {}
            
            array_push($Q10RateVec, $Q10Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '維修技術',
                'data' => $Q10RateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q11所有回答之分數平均(拆換零件處理)
     * endpoint: /api/statistics/getChart10?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart10(Request $req)
    {
        $Q11RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q11s = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q11Num = 0;
            foreach ($Q11s as $Q) {
                $Q11Num += intval($Q->q11);
            }
            $RawSurveyNum = count($Q11s);
            $Q11Rate = 0;
            try {
                $Q11Rate = round($Q11Num/$RawSurveyNum, 2);
            } catch (\Throwable $th) {}
            
            array_push($Q11RateVec, $Q11Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '拆換零件處理',
                'data' => $Q11RateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q12所有回答之分數平均(現場清潔)
     * endpoint: /api/statistics/getChart11?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart11(Request $req)
    {
        $Q12RateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Q12s = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $Q12Num = 0;
            foreach ($Q12s as $Q) {
                $Q12Num += intval($Q->q12);
            }
            $RawSurveyNum = count($Q12s);
            $Q12Rate = 0;
            try {
                $Q12Rate = round($Q12Num/$RawSurveyNum, 2);
            } catch (\Throwable $th) {}
            
            array_push($Q12RateVec, $Q12Rate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '現場清潔',
                'data' => $Q12RateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q4回答1的比例(是否按照約定時段抵達)
     * endpoint: /api/statistics/getChart12?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart12(Request $req)
    {
        $QRateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Qs = $this->FormulaService->getQ4is1Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $QsAll = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
                              
            $QNum = count($Qs);
            $RawSurveyNum = count($QsAll);
            $QRate = 0;
            try {
                $QRate = round($QNum/$RawSurveyNum, 1)*100;
            } catch (\Throwable $th) {}
            
            array_push($QRateVec, $QRate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '是否按照約定時段抵達',
                'data' => $QRateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q6回答9的比例(是否有缺失情形)
     * endpoint: /api/statistics/getChart13?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart13(Request $req)
    {
        $QRateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Qs = $this->FormulaService->getQ6is9Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $QsAll = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
                              
            $QNum = count($Qs);
            $RawSurveyNum = count($QsAll);
            $QRate = 0;
            try {
                $QRate = round($QNum/$RawSurveyNum, 1)*100;
            } catch (\Throwable $th) {}
            
            array_push($QRateVec, $QRate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '是否有缺失情形',
                'data' => $QRateVec
            ]
        ];
        return json_encode($Data);
    }

    /**
     * Q7回答1的比例(是否單趟完成)
     * endpoint: /api/statistics/getChart14?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getChart14(Request $req)
    {
        $QRateVec = array();
        $Calender = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
            $Qs = $this->FormulaService->getQ7is1Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $QsAll = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
                              
            $QNum = count($Qs);
            $RawSurveyNum = count($QsAll);
            $QRate = 0;
            try {
                $QRate = round($QNum/$RawSurveyNum, 1)*100;
            } catch (\Throwable $th) {}
            
            array_push($QRateVec, $QRate);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '是否單趟完成',
                'data' => $QRateVec
            ]
        ];
        return json_encode($Data);
    }

    //Table1
    public function getC1V($D1, $D2, $Region, $Category, $Person)
    {
        $Q1s = $this->FormulaService->getQ1big4Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );

        $Qs = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q1Num = count($Q1s);
        $RawSurveyNum = count($Qs);
        $Q1Rate = 0;
        try {
            $Q1Rate = round($Q1Num/$RawSurveyNum, 1)*100;
        } catch (\Throwable $th) {}
        return $Q1Rate;
    }

    public function getC2V($D1, $D2, $Region, $Category, $Person)
    {
        $Q1s = $this->FormulaService->getQ1is5Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Qs = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q1Num = count($Q1s);
        $RawSurveyNum = count($Qs);
        $Q1Rate = 0;
        try {
            $Q1Rate = round($Q1Num/$RawSurveyNum, 1)*100;
        } catch (\Throwable $th) {}
        return $Q1Rate;
    }

    public function getC3V($D1, $D2, $Region, $Category, $Person)
    {
        $Qs = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );

        $p0_6Bar = $this->FormulaService->getQ13less6Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );

        $p7_8Bar = $this->FormulaService->getQ13_7_8Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );

        $p9_10Bar = $this->FormulaService->getQ13big9Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );

        $p0_6Line = $this->FormulaService->getQ13_0_6Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );

        $p9_10Line = $this->FormulaService->getQ13big9Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );

        $RawSurveyNum = count($Qs);
        $p0_6BarRate = 0;
        $p7_8BarRate = 0;
        $p9_10BarRate = 0;
        $p0_6LineRate = 0;
        $p9_10LineRate = 0;
        try {
            $p0_6BarRate = round(count($p0_6Bar)/$RawSurveyNum, 1)*100;
            $p7_8BarRate = round(count($p7_8Bar)/$RawSurveyNum, 1)*100;
            $p9_10BarRate = round(count($p9_10Bar)/$RawSurveyNum, 1)*100;
            $p0_6LineRate = round(count($p0_6Line)/$RawSurveyNum, 1)*100;
            $p9_10LineRate = round(count($p9_10Line)/$RawSurveyNum, 1)*100;
        } catch (\Throwable $th) {}
        $NPSLine = abs($p0_6LineRate - $p9_10LineRate);

        return $NPSLine;
    }

    public function getC4V($D1, $D2, $Region, $Category, $Person)
    {
        $Q1s = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q1Num = 0;
        foreach ($Q1s as $Q) {
            $Q1Num += intval($Q->q1);
        }
        $RawSurveyNum = count($Q1s);
        $Q1Rate = 0;
        try {
            $Q1Rate = round($Q1Num/$RawSurveyNum, 1);
        } catch (\Throwable $th) {}
        return $Q1Rate;
    }

    public function getC5V($D1, $D2, $Region, $Category, $Person)
    {
        $Q2s = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q2Num = 0;
        foreach ($Q2s as $Q) {
            $Q2Num += intval($Q->q2);
        }
        $RawSurveyNum = count($Q2s);
        $Q2Rate = 0;
        try {
            $Q2Rate = round($Q2Num/$RawSurveyNum, 1);
        } catch (\Throwable $th) {}
        return $Q2Rate;
    }

    public function getC6V($D1, $D2, $Region, $Category, $Person)
    {
        $Q3s = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q3Num = 0;
        foreach ($Q3s as $Q) {
            $Q3Num += intval($Q->q3);
        }
        $RawSurveyNum = count($Q3s);
        $Q3Rate = 0;
        try {
            $Q3Rate = round($Q3Num/$RawSurveyNum, 1);
        } catch (\Throwable $th) {}
        return $Q3Rate;
    }

    public function getC7V($D1, $D2, $Region, $Category, $Person)
    {
        $Q5s = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q5Num = 0;
        foreach ($Q5s as $Q) {
            $Q5Num += intval($Q->q5);
        }
        $RawSurveyNum = count($Q5s);
        $Q5Rate = 0;
        try {
            $Q5Rate = round($Q5Num/$RawSurveyNum, 1);
        } catch (\Throwable $th) {}
        return $Q5Rate;
    }

    public function getC8V($D1, $D2, $Region, $Category, $Person)
    {
        $Q9s = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q9Num = 0;
        foreach ($Q9s as $Q) {
            $Q9Num += intval($Q->q9);
        }
        $RawSurveyNum = count($Q9s);
        $Q9Rate = 0;
        try {
            $Q9Rate = round($Q9Num/$RawSurveyNum, 1);
        } catch (\Throwable $th) {}
        return $Q9Rate;
    }

    public function getC9V($D1, $D2, $Region, $Category, $Person)
    {
        $Q10s = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q10Num = 0;
        foreach ($Q10s as $Q) {
            $Q10Num += intval($Q->q10);
        }
        $RawSurveyNum = count($Q10s);
        $Q10Rate = 0;
        try {
            $Q10Rate = round($Q10Num/$RawSurveyNum, 1);
        } catch (\Throwable $th) {}
        return $Q10Rate;
    }

    public function getC10V($D1, $D2, $Region, $Category, $Person)
    {
        $Q11s = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q11Num = 0;
        foreach ($Q11s as $Q) {
            $Q11Num += intval($Q->q11);
        }
        $RawSurveyNum = count($Q11s);
        $Q11Rate = 0;
        try {
            $Q11Rate = round($Q11Num/$RawSurveyNum, 1);
        } catch (\Throwable $th) {}
        return $Q11Rate;
    }

    public function getC11V($D1, $D2, $Region, $Category, $Person)
    {
        $Q12s = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $Q12Num = 0;
        foreach ($Q12s as $Q) {
            $Q12Num += intval($Q->q12);
        }
        $RawSurveyNum = count($Q12s);
        $Q12Rate = 0;
        try {
            $Q12Rate = round($Q12Num/$RawSurveyNum, 1);
        } catch (\Throwable $th) {}
        return $Q12Rate;
    }

    public function getC12V($D1, $D2, $Region, $Category, $Person)
    {
        $Qs = $this->FormulaService->getQ4is1Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $QsAll = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $QNum = count($Qs);
        $RawSurveyNum = count($QsAll);
        $QRate = 0;
        try {
            $QRate = round($QNum/$RawSurveyNum, 1)*100;
        } catch (\Throwable $th) {}
        return $QRate;
    }

    public function getC13V($D1, $D2, $Region, $Category, $Person)
    {
        $Qs = $this->FormulaService->getQ6is9Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );

        $QsAll = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $QNum = count($Qs);
        $RawSurveyNum = count($QsAll);
        $QRate = 0;
        try {
            $QRate = round($QNum/$RawSurveyNum, 1)*100;
        } catch (\Throwable $th) {}
        return $QRate;
    }

    public function getC14V($D1, $D2, $Region, $Category, $Person)
    {
        $Qs = $this->FormulaService->getQ7is1Set(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $QsAll = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $Region,
            $Category,
            $Person
        );
        $QNum = count($Qs);
        $RawSurveyNum = count($QsAll);
        $QRate = 0;
        try {
            $QRate = round($QNum/$RawSurveyNum, 1)*100;
        } catch (\Throwable $th) {}
        return $QRate;
    }

    public function getFirstHalfTable1($Date, $Region=null, $Category=null, $Person=null)
    {
        $NowYear = date('Y', strtotime($Date));
        $D1 = $NowYear."-01-01 00:00:00";
        $D2 = $NowYear."-05-31 23:59:59";

        return 
        [
            $this->getC1V($D1,$D2,$Region,$Category,$Person),
            $this->getC2V($D1,$D2,$Region,$Category,$Person),
            $this->getC3V($D1,$D2,$Region,$Category,$Person),
            $this->getC4V($D1,$D2,$Region,$Category,$Person),
            $this->getC5V($D1,$D2,$Region,$Category,$Person),
            $this->getC6V($D1,$D2,$Region,$Category,$Person),
            $this->getC7V($D1,$D2,$Region,$Category,$Person),
            $this->getC8V($D1,$D2,$Region,$Category,$Person),
            $this->getC9V($D1,$D2,$Region,$Category,$Person),
            $this->getC10V($D1,$D2,$Region,$Category,$Person),
            $this->getC11V($D1,$D2,$Region,$Category,$Person),
            $this->getC12V($D1,$D2,$Region,$Category,$Person),
            $this->getC13V($D1,$D2,$Region,$Category,$Person),
            $this->getC14V($D1,$D2,$Region,$Category,$Person)
        ];
    }

    public function getSecondHalfTable1($Date, $Region=null, $Category=null, $Person=null)
    {
        $NowYear = date('Y', strtotime($Date));
        $D1 = $NowYear."-07-01 00:00:00";
        $D2 = $NowYear."-12-31 23:59:59";
        
        return 
        [
            $this->getC1V($D1,$D2,$Region,$Category,$Person),
            $this->getC2V($D1,$D2,$Region,$Category,$Person),
            $this->getC3V($D1,$D2,$Region,$Category,$Person),
            $this->getC4V($D1,$D2,$Region,$Category,$Person),
            $this->getC5V($D1,$D2,$Region,$Category,$Person),
            $this->getC6V($D1,$D2,$Region,$Category,$Person),
            $this->getC7V($D1,$D2,$Region,$Category,$Person),
            $this->getC8V($D1,$D2,$Region,$Category,$Person),
            $this->getC9V($D1,$D2,$Region,$Category,$Person),
            $this->getC10V($D1,$D2,$Region,$Category,$Person),
            $this->getC11V($D1,$D2,$Region,$Category,$Person),
            $this->getC12V($D1,$D2,$Region,$Category,$Person),
            $this->getC13V($D1,$D2,$Region,$Category,$Person),
            $this->getC14V($D1,$D2,$Region,$Category,$Person)
        ];
    }

    public function getWholeTable1($Date, $Region=null, $Category=null, $Person=null)
    {
        $NowYear = date('Y', strtotime($Date));
        $D1 = $NowYear."-01-01 00:00:00";
        $D2 = $NowYear."-12-31 23:59:59";
        
        return 
        [
            $this->getC1V($D1,$D2,$Region,$Category,$Person),
            $this->getC2V($D1,$D2,$Region,$Category,$Person),
            $this->getC3V($D1,$D2,$Region,$Category,$Person),
            $this->getC4V($D1,$D2,$Region,$Category,$Person),
            $this->getC5V($D1,$D2,$Region,$Category,$Person),
            $this->getC6V($D1,$D2,$Region,$Category,$Person),
            $this->getC7V($D1,$D2,$Region,$Category,$Person),
            $this->getC8V($D1,$D2,$Region,$Category,$Person),
            $this->getC9V($D1,$D2,$Region,$Category,$Person),
            $this->getC10V($D1,$D2,$Region,$Category,$Person),
            $this->getC11V($D1,$D2,$Region,$Category,$Person),
            $this->getC12V($D1,$D2,$Region,$Category,$Person),
            $this->getC13V($D1,$D2,$Region,$Category,$Person),
            $this->getC14V($D1,$D2,$Region,$Category,$Person)
        ];
    }

    public function getTable1(Request $req)
    {
        $Date = $req->StartTime;
        $FirstHalfTable1 = $this->getFirstHalfTable1($Date, $req->Region, $req->Category, $req->Person);
        $SecondHalfTable1 = $this->getSecondHalfTable1($Date, $req->Region, $req->Category, $req->Person);
        $WholeTable1 = $this->getWholeTable1($Date, $req->Region, $req->Category, $req->Person);

        $Data = [];
        $item = ['滿意度', '感動率', 'NPS', '整體滿意度', '0800接聽及應對服務品質', '維修安排速度', 
        '維修人員服務態度', '講解故障原因', '維修技術', '拆換零件處理', '現場清潔', '是否按照約定時段抵達', '是否有缺失情形', '是否單趟完成'];
        $FirstHalfSUM = 0;
        $SecondHalfSUM = 0;
        $WholeSUM = 0;
        for ($i=0; $i < 14 ; $i++) { 
            $obj = new SimpleClass();
            $obj->item = $item[$i];
            $obj->firstHalf = $FirstHalfTable1[$i];
            $obj->secondHalf = $SecondHalfTable1[$i];
            $obj->all = $WholeTable1[$i];

            $FirstHalfSUM += $FirstHalfTable1[$i];
            $SecondHalfSUM += $SecondHalfTable1[$i];
            $WholeSUM += $WholeTable1[$i];

            array_push($Data ,$obj);
        }

        return json_encode($Data);
    }
}
