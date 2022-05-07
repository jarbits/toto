<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FormulaService;
use App\RawSurvey;
use Carbon\Carbon;
use DateTime;
use DB;

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
        return json_encode(200);
    }

    /**
     * 總覽(堆疊柱狀圖)
     * endpoint: /api/summary/receive-category/getChart2
     */
    public function getChart2(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 客訴分析(折線圖)
     * endpoint: /api/summary/receive-category/getChart3
     */
    public function getChart3(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 客訴分析(彙總分析)
     * endpoint: /api/summary/receive-category/getTable1
     */
    public function getTable1(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 客訴分析(排名分析)
     * endpoint: /api/summary/receive-category/getTable2
     */
    public function getTable2(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 讚美分析(折線圖)
     * endpoint: /api/summary/receive-category/getChart4
     */
    public function getChart4(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 讚美分析(彙總查詢)
     * endpoint: /api/summary/receive-category/getTable3
     */
    public function getTable3(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 讚美分析(排名分析)
     * endpoint: /api/summary/receive-category/getTable4
     */
    public function getTable4(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 建議事項分析(折線圖)
     * endpoint: /api/summary/receive-category/getChart5
     */
    public function getChart5(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 建議事項分析(彙總分析)
     * endpoint: /api/summary/receive-category/getTable5
     */
    public function getTable5(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 建議事項分析(建議事項)
     * endpoint: /api/summary/receive-category/getTable6
     */
    public function getTable6(Request $req)
    {
        return json_encode(200);
    }

    /**
     * 無意見(折線圖)
     * endpoint: /api/summary/receive-category/getChart6
     */
    public function getChart6(Request $req)
    {
        return json_encode(200);
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
