<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FormulaService;
use App\RawSurvey;
use DateTime;
use Carbon\Carbon;
use DB;

class APIController extends Controller
{
    public $FormulaService;
    public function __construct(Request $req)
    {
        $this->FormulaService = new FormulaService();
    }

    /**
     * 取得發送數
     * endpoint: /api/get-post-num?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getPostNum(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));
        
        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($EndMonth+1).'-01 00:00:00'));

        $Qs = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
        $Data = [
            'value' => count($Qs)
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 取得回覆數
     * endpoint: /api/get-resp-num?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getRespNum(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));
        
        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($EndMonth+1).'-01 00:00:00'));

        $Qs = $this->FormulaService->getAllQSet(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
        $Data = [
            'value' => count($Qs)
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 取得低分數量
     * endpoint: /api/get-low-score-num?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getLScoreNum(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));
        
        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($EndMonth+1).'-01 00:00:00'));

        $LowScore = $this->FormulaService->getLScoreSet(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
        $Data = [
            'value' => count($LowScore)
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 取得滿意度(Q1)百分比Pie Chart
     * endpoint: /api/get-q1-rate?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getQ1Rate(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));
        
        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($EndMonth+1).'-01 00:00:00'));

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
            $Q1Rate = round($Q1Num/$RawSurveyNum, 2)*100;
        } catch (\Throwable $th) {}
        
        $Data = [
            'datasets' => [
                'type' => 'Pie',
                'label' => '滿意度',
                'data' => $Q1Rate
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 取得滿意度(Q1)百分比Chart(滿意度)
     * endpoint: /api/get-q1-rate-chart?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getQ1RateChart(Request $req)
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
                $Q1Rate = round($Q1Num/$RawSurveyNum, 2)*100;
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
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 取得滿意度(Q1)為5分的百分比(感動率)
     * endpoint: /api/get-q1-five-rate-chart?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getQ1FiveRateChart(Request $req)
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
                $Q1Rate = round($Q1Num/$RawSurveyNum, 2)*100;
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
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 取得Q13計算該題目分數各項資料占筆的平均0-6,7-8,9-10(NPS Bar)
     * endpoint: /api/get-nps-bar-chart?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getNPSBarChart(Request $req)
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
            
            // $Qs = $this->FormulaService->getQ13less6Set(
            //     $D1, 
            //     $D2, 
            //     $req->Region,
            //     $req->Category,
            //     $req->Person
            // );

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
                $p0_6BarRate = round(count($p0_6Bar)/$RawSurveyNum, 2)*100;
                $p7_8BarRate = round(count($p7_8Bar)/$RawSurveyNum, 2)*100;
                $p9_10BarRate = round(count($p9_10Bar)/$RawSurveyNum, 2)*100;
                $p0_6LineRate = round(count($p0_6Line)/$RawSurveyNum, 2)*100;
                $p9_10LineRate = round(count($p9_10Line)/$RawSurveyNum, 2)*100;
            } catch (\Throwable $th) {}
            
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
                'type' => 'Bar&line',
                'label' => 'NPS',
                'data' => [
                    'p0_6bar' => $p0_6BarVec,
                    'p7_8bar' => $p7_8BarVec,
                    'p9_10bar' => $p9_10BarVec,
                    'npsline' => $NPSLineVec,
                ]
            ]
        ];            
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 取得正負評價數
     * endpoint: /api/get-comments-bar-chart?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getCommentsChart(Request $req)
    {
        $Calender = array();
        $LowScoreVec = array();
        $CommentsVec = array();
        $NoCommentsVec = array();
        $HighScoreVec = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

            $LowScore = $this->FormulaService->getLScoreSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
            
            /*
            $Comments = $this->FormulaService->getRQ14_1000_9999Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $NoComments = $this->FormulaService->getRQ14is9999Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $HighScore = $this->FormulaService->getRQ14less999Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
            */

            $NotLowScoreSet = $this->FormulaService->getNotLowSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            $CommentsNum = 0;   //1000 ~ 9999
            $NoCommentsNum = 0;    //is 9999
            $HighScoreNum = 0;     //less then 999

            foreach($NotLowScoreSet as $item)
            {
                $rq14Set = $item->rq14;
                try {
                    $rq14Set = explode(',', $rq14Set);
                } catch (\Throwable $th) {}
                
                $rq14IntSet = array();
                foreach ($rq14Set as $rq14) 
                {
                    array_push($rq14IntSet, intval($rq14));
                }

                $theMaxVal = max($rq14IntSet);
                if ($theMaxVal < 9999 && $theMaxVal >= 1000) {
                    $CommentsNum++;
                }
                if ($theMaxVal = 9999) {
                    $NoCommentsNum++;
                }
                if ($theMaxVal <= 999) {
                    $HighScoreNum++;
                }
            }

            array_push($LowScoreVec, count($LowScore) );
            // array_push($CommentsVec, count($Comments) );
            // array_push($NoCommentsVec, count($NoComments) );
            // array_push($HighScoreVec, count($HighScore) );
            array_push($CommentsVec, $CommentsNum );
            array_push($NoCommentsVec, $NoCommentsNum );
            array_push($HighScoreVec, $HighScoreNum );
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'bar',
                'label' => '正負評價數',
                'data' => [
                    'lowscore' => $LowScoreVec,
                    'comments' => $CommentsVec,
                    'nocomments' => $NoCommentsVec,
                    'highscore' => $HighScoreVec,
                ]
            ]
        ];            
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 低分示警件數
     * endpoint: /api/get-lowscore-bar-chart?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getLowScoreChart(Request $req)
    {
        $Calender = array();
        $LowScoreVec = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

            $LowScore = $this->FormulaService->getLScoreSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
            
            array_push($LowScoreVec, count($LowScore) );
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'bar',
                'label' => '低分示警件數',
                'data' => [
                    'lowscore' => $LowScoreVec,
                ]
            ]
        ];            
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 簡訊數相關
     * endpoint: /api/get-sms-bar-chart?StartTime=2022-02-11&EndTime=2022-02-22&SendNum=1000
     */
    public function getSMSChart(Request $req)
    {
        $SendNum = $req->SendNum;
        $Calender = array();
        $LowScoreVec = array();
        $UselessNumVec = array();
        $UsefulNumVec = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

            $RawData = $this->FormulaService->getAllQSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
            
            $UselessNum = intval($req->SendNum) - count($RawData);

            $LowScore = $this->FormulaService->getLScoreSet(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
            
            array_push($LowScoreVec, count($LowScore) );
            array_push($UselessNumVec, $UselessNum );
            array_push($UsefulNumVec, 0);
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'bar',
                'label' => '簡訊數相關',
                'data' => [
                    'lowscore' => $LowScoreVec,
                    'usefulnum' => $UsefulNumVec,
                    'uselessnum' => $UselessNumVec,
                ]
            ]
        ];            
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 取得Q13計算該題目分數各項資料占筆的平均0-6,7-8,9-10(NPS Pie)
     * endpoint: /api/get-nps-pie-chart?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getNPSPieChart(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($EndMonth+1).'-01 00:00:00'));

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

        $RawSurveyNum = count($Qs);
        $p0_6BarRate = 0;
        $p7_8BarRate = 0;
        $p9_10BarRate = 0;

        try {
            $p0_6BarRate = round(count($p0_6Bar)/$RawSurveyNum, 2)*100;
            $p7_8BarRate = round(count($p7_8Bar)/$RawSurveyNum, 2)*100;
            $p9_10BarRate = round(count($p9_10Bar)/$RawSurveyNum, 2)*100;
        } catch (\Throwable $th) {
            //throw $th;
        }

        $NPS = $p9_10BarRate - $p0_6BarRate;

        $Data = [
            'datasets' => [
                'type' => 'Pie Chart',
                'label' => 'NPS',
                'NPS' => $NPS,
                'data' => [
                    [
                        'value' => $p0_6BarRate,
                        'name' => '0-6'
                    ],
                    [
                        'value' => $p7_8BarRate,
                        'name' => '7-8'
                    ],
                    [
                        'value' => $p9_10BarRate,
                        'name' => '9-10'
                    ]
                ]
            ]
        ];            
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 取得滿意度(Q1)為5分的百分比(感動率Pie Chart)
     * endpoint: /api/get-q1-five-rate-pie-chart?StartTime=2022-02-11&EndTime=2022-02-22
     */
    public function getQ1FiveRatePieChart(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($EndMonth+1).'-01 00:00:00'));
        
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
            $Q1Rate = round($Q1Num/$RawSurveyNum, 2)*100;
        } catch (\Throwable $th) {}

        $Data = [
            'datasets' => [
                'type' => 'Pie',
                'label' => '感動率',
                'data' => $Q1Rate
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }
}
