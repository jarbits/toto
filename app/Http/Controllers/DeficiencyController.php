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

    /**
     * 零件品項或數量不足：[Q8]=1的總數
     */
    public function getChart2(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is1Set(
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
                'label' => '零件品項或數量不足',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 零件有瑕疵：[Q8]=2的總數
     */
    public function getChart3(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is2Set(
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
                'label' => '零件有瑕疵',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 零件需調貨：[Q8]=3的總數
     */
    public function getChart4(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is3Set(
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
                'label' => '零件需調貨',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 未攜帶適合的工具：[Q8]=4的總數
     */
    public function getChart5(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is4Set(
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
                'label' => '未攜帶適合的工具',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 人員專業度不足：[Q8]=5的總數
     */
    public function getChart6(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is5Set(
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
                'label' => '人員專業度不足',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 商品故障嚴重尚在評估：[Q8]=6的總數
     */
    public function getChart7(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is6Set(
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
                'label' => '商品故障嚴重尚在評估',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 零件非日本製：[Q8]=7的總數
     */
    public function getChart8(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is7Set(
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
                'label' => '零件非日本製',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 先來確認故障狀況：[Q8]=8的總數
     */
    public function getChart9(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is8Set(
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
                'label' => '先來確認故障狀況',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 商品無法安裝：[Q8]=10的總數
     */
    public function getChart10(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is10Set(
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
                'label' => '商品無法安裝',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * 維修後產生其他故障問題：[Q8]=11的總數
     */
    public function getChart11(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is11Set(
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
                'label' => '維修後產生其他故障問題',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 商品無法維修：[Q8]=12的總數
     */
    public function getChart12(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is12Set(
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
                'label' => '商品無法維修',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 零件停產無法維修：[Q8]=13的總數
     */
    public function getChart13(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is13Set(
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
                'label' => '零件停產無法維修',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 維修人員蓄意破壞產品：[Q8]=14的總數
     */
    public function getChart14(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is14Set(
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
                'label' => '維修人員蓄意破壞產品',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 維修人員沒有來：[Q8]=15的總數
     */
    public function getChart15(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is15Set(
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
                'label' => '維修人員沒有來',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 需水電配合：[Q8]=16的總數
     */
    public function getChart16(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is16Set(
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
                'label' => '需水電配合',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 顧客尚在考慮：[Q8]=17的總數
     */
    public function getChart17(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is17Set(
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
                'label' => '顧客尚在考慮',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 另外安排維修人員：[Q8]=18的總數
     */
    public function getChart18(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is18Set(
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
                'label' => '另外安排維修人員',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 其他：[Q8]=9 & 97的總數
     */
    public function getChart19(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is9And97Set(
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
                'label' => '其他',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 不知道：[Q8]=98的總數
     */
    public function getChart20(Request $req)
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

            $Q8s = $this->FormulaService->getQ8is98Set(
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
                'label' => '不知道',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    ###人員缺失###
    /**
     * 整體：[Q6]不為9的總數
     */
    public function getChart21(Request $req)
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

            $Q8s = $this->FormulaService->getQ6isNot9Set(
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

    /**
     * 沒有配戴識別證：[Q6]內容中含有5即符合
     */
    public function getChart22(Request $req)
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

            $Q8s = $this->FormulaService->getQ6isLike5Set(
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
                'label' => '沒有配戴識別證',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 沒有穿制服：[Q6]內容中含有2即符合
     */
    public function getChart23(Request $req)
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

            $Q8s = $this->FormulaService->getQ6isLike2Set(
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
                'label' => '沒有配戴識別證',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 穿拖鞋：[Q6]內容中含有3即符合
     */
    public function getChart24(Request $req)
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

            $Q8s = $this->FormulaService->getQ6isLike3Set(
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
                'label' => '穿拖鞋',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 身上有煙味：[Q6]內容中含有1即符合
     */
    public function getChart25(Request $req)
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

            $Q8s = $this->FormulaService->getQ6isLike1Set(
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
                'label' => '身上有煙味',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 態度粗魯或口氣不佳：[Q6]內容中含有4者即符合
     */
    public function getChart26(Request $req)
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

            $Q8s = $this->FormulaService->getQ6isLike4Set(
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
                'label' => '態度粗魯或口氣不佳',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }

    ###未按時間抵達###
    /**
     * 本項目需列出[Q4]包含有2或3的資料總數
     */
    public function getChart27(Request $req)
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

            $Q8s = $this->FormulaService->getQ4is2Or3Set(
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
                'label' => '全部總計',
                'data' => $Q8NumVec
            ]
        ];
        return json_encode($Data, JSON_UNESCAPED_UNICODE);
    }
}
