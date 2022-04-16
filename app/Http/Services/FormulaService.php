<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use DateTime;
use Carbon\Carbon;
use DB;

class FormulaService
{
    public function advanceSearch($Region, $Category, $Person)
    {
        $qStr = "";

        if ($Region != null) {
            $qStr = "
                AND T.s_region = '".$Region."'
                ";
        }
        if ($Category != null) {
            $qStr = "
                AND T.s_category = '".$Category."'
                ";
        }
        if ($Category != null && $Person != null) {
            $qStr = "
                AND T.s_category = '".$Category."'
                AND T.s_person = '".$Person."'
                ";
        }
        return $qStr;
    }
    /**
     * 取得低分數量SET
     */
    public function getLScoreSet($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
        SELECT * FROM rawsurvey AS T
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
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$StartTime."' 
        AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得取得區間內所有的題目SET
     */
    public function getAllQSet($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
        SELECT * FROM rawsurvey AS T
        WHERE 1=1
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$StartTime."' 
        AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得滿意度(Q1 >= 4)SET
     */
    public function getQ1big4Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q1 >= '4'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得感動率(Q1 = 5)SET
     */
    public function getQ1is5Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q1 = '5'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得(Q4 = 1)SET
     */
    public function getQ4is1Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q4 = '1'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得(Q4 = 1)SET
     */
    public function getQ4is2Or3Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND (T.q4 = '2' OR T.q4 = '3')
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得(Q6 = 9)SET
     */
    public function getQ6is9Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q6 = '9'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 整體：[Q6]不為9的總數
     */
    public function getQ6isNot9Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q6 != '9'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 沒有配戴識別證：[Q6]內容中含有5即符合
     */
    public function getQ6isLike5Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q6 LIKE '%5%'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 沒有穿制服：[Q6]內容中含有2即符合
     */
    public function getQ6isLike2Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q6 LIKE '%2%'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 穿拖鞋：[Q6]內容中含有3即符合
     */
    public function getQ6isLike3Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q6 LIKE '%3%'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 身上有煙味：[Q6]內容中含有1即符合
     */
    public function getQ6isLike1Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q6 LIKE '%1%'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 態度粗魯或口氣不佳：[Q6]內容中含有4者即符合
     */
    public function getQ6isLike4Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q6 LIKE '%4%'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得(Q7 = 1)SET
     */
    public function getQ7is1Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q7 = '1'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * [Q8]不為空白的總數
     */
    public function getQ8isNotNullSet($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 IS NOT NULL
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 零件品項或數量不足：[Q8]=1的總數
     */
    public function getQ8is1Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '1'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 零件有瑕疵：[Q8]=2的總數
     */
    public function getQ8is2Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '2'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 零件有瑕疵：[Q8]=3的總數
     */
    public function getQ8is3Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '3'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 未攜帶適合的工具：[Q8]=4的總數
     */
    public function getQ8is4Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '4'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 人員專業度不足：[Q8]=5的總數
     */
    public function getQ8is5Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '5'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 商品故障嚴重尚在評估：[Q8]=6的總數
     */
    public function getQ8is6Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '6'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 零件非日本製：[Q8]=7的總數
     */
    public function getQ8is7Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '7'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 先來確認故障狀況：[Q8]=8的總數
     */
    public function getQ8is8Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '8'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 商品無法安裝：[Q8]=10的總數
     */
    public function getQ8is10Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '10'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 維修後產生其他故障問題：[Q8]=11的總數
     */
    public function getQ8is11Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '11'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 商品無法維修：[Q8]=12的總數
     */
    public function getQ8is12Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '12'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 零件停產無法維修：[Q8]=13的總數
     */
    public function getQ8is13Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '13'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 維修人員蓄意破壞產品：[Q8]=14的總數
     */
    public function getQ8is14Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '14'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 維修人員沒有來：[Q8]=15的總數
     */
    public function getQ8is15Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '15'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 需水電配合：[Q8]=16的總數
     */
    public function getQ8is16Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '16'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 顧客尚在考慮：[Q8]=17的總數
     */
    public function getQ8is17Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '17'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 另外安排維修人員：[Q8]=18的總數
     */
    public function getQ8is18Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '18'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 其他：[Q8]=9 & 97的總數
     */
    public function getQ8is9And97Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '9'
            AND T.q8 = '97'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 不知道：[Q8]=98的總數
     */
    public function getQ8is98Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8 = '98'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    ### NPS Set ###
    /**
     * Q13 <= 6
     */
    public function getQ13less6Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q13 <= '6'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * Q13 >= 0 && <= 6
     */
    public function getQ13_0_6Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q13 >= '0'
            AND T.q13 <= '6'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * Q13 >= 7 && <= 8
     */
    public function getQ13_7_8Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q13 >= '7'
            AND T.q13 <= '8'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * Q13 >= 7 && <= 8
     */
    public function getQ13big9Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q13 >= '9'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }
    ### End NPS Set ###

    ### 取得正負評價數 ###
    /**
     * RQ14 >= 1000 && < 9999
     */
    public function getRQ14_1000_9999Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.rq14 >= '1000'
            AND T.rq14 <= '9999'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * RQ14 = 9999
     */
    public function getRQ14is9999Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.rq14 >= '9999'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * RQ14 = 9999
     */
    public function getRQ14less999Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.rq14 <= '999'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    ### End 取得正負評價數 ###
}