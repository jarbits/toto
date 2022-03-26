<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RawSurvey;
use DateTime;
use Carbon\Carbon;
use DB;

class APIController extends Controller
{
    protected $DayDiff;
    public function __construct(Request $req)
    {
        $StartDate = strtotime($req->StartTime);
        $EndDate = strtotime($req->EndTime);
        $this->DayDiff = ($EndDate - $StartDate) / (60 * 60 * 24);
    }

    /**
     * 取得發送數
     * endpoint: /api/get-post-num?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
     */
    public function getPostNum(Request $req)
    {
        $RawSurvey = RawSurvey::where("start_time", ">=", $req->StartTime)
                              ->where("end_time", "<", $req->EndTime)
                              ->get();
        $Data = [
            'value' => count($RawSurvey)
        ];
        return json_encode($Data);
    }

    /**
     * 取得回覆數
     * endpoint: /api/get-resp-num?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
     */
    public function getRespNum(Request $req)
    {
        $RawData = RawSurvey::where("start_time", ">=", $req->StartTime)
                              ->where("end_time", "<", $req->EndTime)
                              ->get();
        $Data = [
            'value' => count($RawData)
        ];
        return json_encode($Data);
    }

    /**
     * 取得低分數量
     * endpoint: /api/get-low-score-num?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
     */
    public function getLScoreNum(Request $req)
    {
        $LowScore = DB::select("SELECT * FROM rawsurvey AS T
                                WHERE 1=1
                                AND (T.cklow_score LIKE '%Q1%'
                                OR T.cklow_score LIKE '%Q2%'
                                OR T.cklow_score LIKE '%Q3%'
                                OR T.cklow_score LIKE '%Q5%'
                                OR T.cklow_score LIKE '%Q9%'
                                OR T.cklow_score LIKE '%Q10%'
                                OR T.cklow_score LIKE '%Q11%'
                                OR T.cklow_score LIKE '%Q12%'
                                OR T.cklow_score LIKE '%Q13%')
                                AND T.start_time >= '".$req->StartTime."' AND T.end_time < '".$req->EndTime."'");
                   
        $Data = [
            'value' => count($LowScore)
        ];
        return json_encode($Data);
    }

    /**
     * 取得滿意度(Q1)百分比Pie Chart
     * endpoint: /api/get-q1-rate?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
     */
    public function getQ1Rate(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));
        
        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
        
        $Q1s = RawSurvey::where("q1", ">=", "4")
                              ->where("start_time", ">=", $D1)
                              ->where("end_time", "<", $D2)
                              ->get();
        $Qs = RawSurvey::where("start_time", ">=", $D1)
                            ->where("end_time", "<", $D2)
                            ->get();
                            
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
        return json_encode($Data);
    }

    /**
     * 取得滿意度(Q1)百分比Chart(滿意度)
     * endpoint: /api/get-q1-rate-chart?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
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
            $Q1s = RawSurvey::where("q1", ">=", "4")
                    ->where("start_time", ">=", $D1)
                    ->where("end_time", "<", $D2)
                    ->get();

            $Qs = RawSurvey::where("start_time", ">=", $D1)
                    ->where("end_time", "<", $D2)
                    ->get();

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
        return json_encode($Data);
    }

    /**
     * 取得滿意度(Q1)為5分的百分比(感動率)
     * endpoint: /api/get-q1-five-rate-chart?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
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
            $Q1s = RawSurvey::where("q1", "=", "5")
                              ->where("start_time", ">=", $D1)
                              ->where("end_time", "<", $D2)
                              ->get();

            $Qs = RawSurvey::where("start_time", ">=", $D1)
                              ->where("end_time", "<", $D2)
                              ->get();
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
        return json_encode($Data);
    }

    /**
     * 取得Q13計算該題目分數各項資料占筆的平均0-6,7-8,9-10(NPS Bar)
     * endpoint: /api/get-nps-bar-chart?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
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

            $Qs = RawSurvey::where("q13", "<=", "6")
                              ->where("start_time", ">=", $D1)
                              ->where("end_time", "<", $D2)
                              ->get();

            $p0_6Bar = RawSurvey::where("q13", ">=", "0")
                              ->where("q13", "<=", "6")
                              ->where("start_time", ">=", $D1)
                              ->where("end_time", "<", $D2)
                              ->get();

            $p7_8Bar = RawSurvey::where("q13", ">=", "7")
                                ->where("q13", "<=", "8")
                                ->where("start_time", ">=", $D1)
                                ->where("end_time", "<", $D2)
                                ->get();

            $p9_10Bar = RawSurvey::where("q13", ">=", "9")
                                ->where("start_time", ">=", $D1)
                                ->where("end_time", "<", $D2)
                                ->get();

            $p0_6Line = RawSurvey::where("q13", ">=", "0")
                                ->where("q13", "<=", "6")
                                ->where("start_time", ">=", $D1)
                                ->where("end_time", "<", $D2)
                                ->get();
  
            $p9_10Line = RawSurvey::where("q13", ">=", "9")
                                ->where("start_time", ">=", $D1)
                                ->where("end_time", "<", $D2)
                                ->get();

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
        return json_encode($Data);
    }

    /**
     * 取得正負評價數
     * endpoint: /api/get-comments-bar-chart?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
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

            $LowScore = DB::select("SELECT * FROM rawsurvey AS T
                                    WHERE 1=1
                                    AND (T.cklow_score LIKE '%Q1%'
                                    OR T.cklow_score LIKE '%Q2%'
                                    OR T.cklow_score LIKE '%Q3%'
                                    OR T.cklow_score LIKE '%Q5%'
                                    OR T.cklow_score LIKE '%Q9%'
                                    OR T.cklow_score LIKE '%Q10%'
                                    OR T.cklow_score LIKE '%Q11%'
                                    OR T.cklow_score LIKE '%Q12%'
                                    OR T.cklow_score LIKE '%Q13%')
                                    AND T.start_time >= '".$D1."' AND T.end_time < '".$D2."'");
            
            $Comments = RawSurvey::whereNotNull("rq14")
                                ->where("rq14", ">=", 1000)
                                ->where("rq14", "<", 9999)
                                ->where("start_time", ">=", $D1)
                                ->where("end_time", "<", $D2)
                                ->get();

            $NoComments = RawSurvey::whereNotNull("rq14")
                                ->where("rq14", "=", 9999)
                                ->where("start_time", ">=", $D1)
                                ->where("end_time", "<", $D2)
                                ->get();

            $HighScore = RawSurvey::whereNotNull("rq14")
                                ->where("rq14", "<=", 999)
                                ->where("start_time", ">=", $D1)
                                ->where("end_time", "<", $D2)
                                ->get();

            array_push($LowScoreVec, count($LowScore) );
            array_push($CommentsVec, count($Comments) );
            array_push($NoCommentsVec, count($NoComments) );
            array_push($HighScoreVec, count($HighScore) );
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
        return json_encode($Data);
    }

    /**
     * 低分示警件數
     * endpoint: /api/get-lowscore-bar-chart?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
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

            $LowScore = DB::select("SELECT * FROM rawsurvey AS T
                                    WHERE 1=1
                                    AND (T.cklow_score LIKE '%Q1%'
                                    OR T.cklow_score LIKE '%Q2%'
                                    OR T.cklow_score LIKE '%Q3%'
                                    OR T.cklow_score LIKE '%Q5%'
                                    OR T.cklow_score LIKE '%Q9%'
                                    OR T.cklow_score LIKE '%Q10%'
                                    OR T.cklow_score LIKE '%Q11%'
                                    OR T.cklow_score LIKE '%Q12%'
                                    OR T.cklow_score LIKE '%Q13%')
                                    AND T.start_time >= '".$D1."' AND T.end_time < '".$D2."'");
            
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
        return json_encode($Data);
    }

    /**
     * 簡訊數相關
     * endpoint: /api/get-sms-bar-chart?StartTime=2022-02-11&EndTime=2022-02-22&SendNum=1000
     * parameter
     * 1. StartTime
     * 2. EndTime
     * 3. 填入總數(SendNum)
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

            $RawData = RawSurvey::where("start_time", ">=", $D1)
                              ->where("end_time", "<", $D2)
                              ->get();
            
            $UselessNum = intval($req->SendNum) - count($RawData);

            $LowScore = DB::select("SELECT * FROM rawsurvey AS T
                                    WHERE 1=1
                                    AND (T.cklow_score LIKE '%Q1%'
                                    OR T.cklow_score LIKE '%Q2%'
                                    OR T.cklow_score LIKE '%Q3%'
                                    OR T.cklow_score LIKE '%Q5%'
                                    OR T.cklow_score LIKE '%Q9%'
                                    OR T.cklow_score LIKE '%Q10%'
                                    OR T.cklow_score LIKE '%Q11%'
                                    OR T.cklow_score LIKE '%Q12%'
                                    OR T.cklow_score LIKE '%Q13%')
                                    AND T.start_time >= '".$D1."' AND T.end_time < '".$D2."'");
            
                              
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
        return json_encode($Data);
    }

    /**
     * 取得Q13計算該題目分數各項資料占筆的平均0-6,7-8,9-10(NPS Pie)
     * endpoint: /api/get-nps-pie-chart?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
     */
    public function getNPSPieChart(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

        $Qs = RawSurvey::where("start_time", ">=", $D1)
                        ->where("end_time", "<", $D2)
                        ->get();

        $p0_6Bar = RawSurvey::where("q13", "<=", 6)
                            ->where("start_time", ">=", $D1)
                            ->where("end_time", "<", $D2)
                            ->get();

        $p7_8Bar = RawSurvey::where("q13", ">=", 7)
                            ->where("q13", "<=", 8)
                            ->where("start_time", ">=", $D1)
                            ->where("end_time", "<", $D2)
                            ->get();

        $p9_10Bar = RawSurvey::where("q13", ">=", 9)
                            ->where("start_time", ">=", $D1)
                            ->where("end_time", "<", $D2)
                            ->get();

        $RawSurveyNum = count($Qs);
        $p0_6BarRate = 0;
        $p7_8BarRate = 0;
        $p9_10BarRate = 0;

        try {
            $p0_6BarRate = round(count($p0_6Bar)/$RawSurveyNum, 1)*100;
            $p7_8BarRate = round(count($p7_8Bar)/$RawSurveyNum, 1)*100;
            $p9_10BarRate = round(count($p9_10Bar)/$RawSurveyNum, 1)*100;
        } catch (\Throwable $th) {
            //throw $th;
        }

        $NPS = $p0_6BarRate - $p9_10BarRate;

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
        return json_encode($Data);
    }

    /**
     * 取得滿意度(Q1)為5分的百分比(感動率Pie Chart)
     * endpoint: /api/get-q1-five-rate-pie-chart?StartTime=2022-02-11&EndTime=2022-02-22
     * parameter
     * 1. StartTime
     * 2. EndTime
     */
    public function getQ1FiveRatePieChart(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        
        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));
        
        $Q1s = RawSurvey::where("q1", "=", "5")
                        ->where("start_time", ">=", $D1)
                        ->where("end_time", "<", $D2)
                        ->get();

        $Qs = RawSurvey::where("start_time", ">=", $D1)
                              ->where("end_time", "<", $D2)
                              ->get();
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
        return json_encode($Data);
    }
}
