<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FormulaService;
use App\RawSurvey;
use Carbon\Carbon;
use DateTime;
use DB;

class Series {
    public $name = '';
    public $type = 'line';
    public $data = [];
};

class SummaryController extends Controller
{
    public $FormulaService;
    public function __construct(Request $req)
    {
        $this->FormulaService = new FormulaService();
    }

    ### Start 回復總類分析 ###

    /**
     * 總覽(折線圖)
     * endpoint: /api/summary/receive-category/getChart1
     */
    public function getChart1(Request $req)
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

            array_push($LowScoreVec, count($LowScore) );
            array_push($CommentsVec, count($Comments) );
            array_push($NoCommentsVec, count($NoComments) );
            array_push($HighScoreVec, count($HighScore) );
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }
        
        $LowSeries = new Series();
        $LowSeries->name = '客訴分析';
        $LowSeries->data = $LowScoreVec;

        $HighSeries = new Series();
        $HighSeries->name = '讚美分析';
        $HighSeries->data = $HighScoreVec;

        $CommentSeries = new Series();
        $CommentSeries->name = '建議事項';
        $CommentSeries->data = $CommentsVec;

        $NoCommentSeries = new Series();
        $NoCommentSeries->name = '無意見';
        $NoCommentSeries->data = $NoCommentsVec;

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '總覽分析',
                'data' => [$LowSeries,$HighSeries,$CommentSeries,$NoCommentSeries]
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 總覽(堆疊柱狀圖)
     * endpoint: /api/summary/receive-category/getChart2
     */
    public function getChart2(Request $req)
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
                'label' => '總攬',
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
     * 客訴分析(折線圖)
     * endpoint: /api/summary/receive-category/getChart3
     */
    public function getChart3(Request $req)
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
                'type' => 'line',
                'label' => '客訴分析',
                'data' => $LowScoreVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 客訴分析(彙總分析)
     * endpoint: /api/summary/receive-category/getTable1
     */
    public function getTable1(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

        $Table = $this->FormulaService->getSummaryTable01(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
                        
        return json_encode($Table, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 客訴分析(排名分析)
     * endpoint: /api/summary/receive-category/getTable2
     */
    public function getTable2(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

        $Table = $this->FormulaService->getSummaryTable02(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
                        
        return json_encode($Table, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 讚美分析(折線圖)
     * endpoint: /api/summary/receive-category/getChart4
     */
    public function getChart4(Request $req)
    {
        $Calender = array();
        $HighScoreVec = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

            $HighScore = $this->FormulaService->getRQ14less999Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );
            array_push($HighScoreVec, count($HighScore) );
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '讚美分析',
                'data' => $HighScoreVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 讚美分析(彙總查詢)
     * endpoint: /api/summary/receive-category/getTable3
     */
    public function getTable3(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

        $Table = $this->FormulaService->getSummaryTable03(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
                        
        return json_encode($Table, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 讚美分析(排名分析)
     * endpoint: /api/summary/receive-category/getTable4
     */
    public function getTable4(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

        $Table = $this->FormulaService->getSummaryTable04(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
                        
        return json_encode($Table, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 建議事項分析(折線圖)
     * endpoint: /api/summary/receive-category/getChart5
     */
    public function getChart5(Request $req)
    {
        $Calender = array();
        $CommentsVec = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

            $Comments = $this->FormulaService->getRQ14_1000_9999Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            array_push($CommentsVec, count($Comments) );
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '建議事項分析',
                'data' => $CommentsVec
            ]
        ];            
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 建議事項分析(彙總分析)
     * endpoint: /api/summary/receive-category/getTable5
     */
    public function getTable5(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

        $Table = $this->FormulaService->getSummaryTable05(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
                        
        return json_encode($Table, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 建議事項分析(建議事項)
     * endpoint: /api/summary/receive-category/getTable6
     */
    public function getTable6(Request $req)
    {
        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
        $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

        $Table = $this->FormulaService->getSummaryTable06(
            $D1, 
            $D2, 
            $req->Region,
            $req->Category,
            $req->Person
        );
                        
        return json_encode($Table, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 無意見(折線圖)
     * endpoint: /api/summary/receive-category/getChart6
     */
    public function getChart6(Request $req)
    {
        $Calender = array();
        $NoCommentsVec = array();

        $NowYear = date('Y', strtotime($req->StartTime));
        $NowMonth = date('m', strtotime($req->StartTime));
        $EndMonth = date('m', strtotime($req->EndTime));

        $i_start = $NowMonth;
        for($i=$i_start; $i<=$EndMonth; $i++)
        {
            $D1 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00'));
            $D2 = date('Y-m-d', strtotime($NowYear.'-'.($NowMonth+1).'-01 00:00:00'));

            $NoComments = $this->FormulaService->getRQ14is9999Set(
                $D1, 
                $D2, 
                $req->Region,
                $req->Category,
                $req->Person
            );

            array_push($NoCommentsVec, count($NoComments) );
            array_push($Calender, date('Y/m', strtotime($NowYear.'-'.($NowMonth).'-01 00:00:00')));
            $NowMonth++;
        }

        $Data = [
            'label' => $Calender,
            'datasets' => [
                'type' => 'line',
                'label' => '無意見',
                'data' => $CommentsVec
            ]
        ];            
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    ### End 回復總類分析 ###

    ### Start 簡訊SMS市調統計 ###

    /**
     * 簡訊滿意度分析表
     * endpoint: /api/summary/receive-category/getChart6
     */
    public function getTable7(Request $req)
    {
        return json_encode(200);
    }

    ### End 簡訊SMS市調統計 ###
}
