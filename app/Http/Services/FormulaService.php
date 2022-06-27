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

        if ($Region != null && $Category != null && $Person == null) {
            // $qStr = "
            //     AND T.s_region = '".$Region."'
            //     ";
            $qStr = "
                AND T.s_region = '".$Category."'
                ";
        }
        if ($Category != null && $Region == null) {
            $qStr = "
                AND T.s_person LIKE '%".$Category."%'
                ";
        }
        if ($Category != null && $Person != null) {
            $qStr = "
                AND T.s_person LIKE '%".$Category."%'
                AND T.s_person LIKE '%".$Person."%'
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
     * 取得Q1 = 1的SET
     */
    public function getQ1is1Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q1 = 1
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得Q1 = 2的SET
     */
    public function getQ1is2Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q1 = 2
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得Q1 = 3的SET
     */
    public function getQ1is3Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q1 = 3
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    /**
     * 取得Q1 = 4的SET
     */
    public function getQ1is4Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q1 = 4
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
            AND T.q1 >= 4
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
            AND T.q1 = 5
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
            AND T.q4 = 1
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
            AND (T.q4 = 2 OR T.q4 = 3)
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
            AND T.q6 = 9
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
            AND T.q6 != 9
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
            AND T.q7 = 1
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
            AND (T.q8 IS NOT NULL
            OR T.q8 != '')
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
            AND T.q8 like '1'
            OR T.q8 like '1,%'
            OR T.q8 like '%,1'
            OR T.q8 like '%,1,%'
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
            AND T.q8 like '2'
            OR T.q8 like '2,%'
            OR T.q8 like '%,2'
            OR T.q8 like '%,2,%'
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
            AND T.q8 like '3'
            OR T.q8 like '3,%'
            OR T.q8 like '%,3'
            OR T.q8 like '%,3,%'
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
            AND T.q8 like '4'
            OR T.q8 like '4,%'
            OR T.q8 like '%,4'
            OR T.q8 like '%,4,%'
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
            AND T.q8 like '5'
            OR T.q8 like '5,%'
            OR T.q8 like '%,5'
            OR T.q8 like '%,5,%'
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
            AND T.q8 like '6'
            OR T.q8 like '6,%'
            OR T.q8 like '%,6'
            OR T.q8 like '%,6,%'
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
            AND T.q8 like '7'
            OR T.q8 like '7,%'
            OR T.q8 like '%,7'
            OR T.q8 like '%,7,%'
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
            AND T.q8 like '8'
            OR T.q8 like '8,%'
            OR T.q8 like '%,8'
            OR T.q8 like '%,8,%'
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
            AND T.q8 like '10'
            OR T.q8 like '10,%'
            OR T.q8 like '%,10'
            OR T.q8 like '%,10,%'
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
            AND T.q8 like '11'
            OR T.q8 like '11,%'
            OR T.q8 like '%,11'
            OR T.q8 like '%,11,%'
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
            AND T.q8 like '12'
            OR T.q8 like '12,%'
            OR T.q8 like '%,12'
            OR T.q8 like '%,12,%'
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
            AND T.q8 like '13'
            OR T.q8 like '13,%'
            OR T.q8 like '%,13'
            OR T.q8 like '%,13,%'
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
            AND T.q8 like '14'
            OR T.q8 like '14,%'
            OR T.q8 like '%,14'
            OR T.q8 like '%,14,%'
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
            AND T.q8 like '15'
            OR T.q8 like '15,%'
            OR T.q8 like '%,15'
            OR T.q8 like '%,15,%'
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
            AND T.q8 like '16'
            OR T.q8 like '16,%'
            OR T.q8 like '%,16'
            OR T.q8 like '%,16,%'
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
            AND T.q8 like '17'
            OR T.q8 like '17,%'
            OR T.q8 like '%,17'
            OR T.q8 like '%,17,%'
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
            AND T.q8 like '18'
            OR T.q8 like '18,%'
            OR T.q8 like '%,18'
            OR T.q8 like '%,18,%'
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
            AND T.q8 like '9'
            AND T.q8 like '97'
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
            AND T.q8 like '98'
            OR T.q8 like '98,%'
            OR T.q8 like '%,98'
            OR T.q8 like '%,98,%'
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."'
            AND T.end_time < '".$EndTime."'
        ");
        return $Set;
    }

    /**
     * 顯示[Q8_9]不為空白的資料(表格)
     */
    public function getQ8_9NotNullSet($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND T.q8_9 IS NOT NULL
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
            AND T.q13 <= 6
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
            AND T.q13 >= 0
            AND T.q13 <= 6
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
            AND T.q13 >= 7
            AND T.q13 <= 8
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
            AND T.q13 >= 9
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
    public function getNotLowSet($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND NOT (T.cklow_score LIKE '%Q1%'
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

    public function getRQ14_1000_9999Set($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
            SELECT * FROM rawsurvey AS T
            WHERE 1=1
            AND NOT (T.cklow_score NOT LIKE '%Q1%'
            OR T.cklow_score NOT LIKE '%Q2%'
            OR T.cklow_score NOT LIKE '%Q3%'
            OR T.cklow_score NOT LIKE '%Q5%'
            OR T.cklow_score NOT LIKE '%Q9%'
            OR T.cklow_score NOT LIKE '%Q10%'
            OR T.cklow_score NOT LIKE '%Q11%'
            OR T.cklow_score NOT LIKE '%Q12%'
            OR T.cklow_score NOT LIKE '%Q13%')
            AND (T.rq14 >= 1000
            OR T.rq14 < 9999)
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
            AND NOT (T.cklow_score NOT LIKE '%Q1%'
            OR T.cklow_score NOT LIKE '%Q2%'
            OR T.cklow_score NOT LIKE '%Q3%'
            OR T.cklow_score NOT LIKE '%Q5%'
            OR T.cklow_score NOT LIKE '%Q9%'
            OR T.cklow_score NOT LIKE '%Q10%'
            OR T.cklow_score NOT LIKE '%Q11%'
            OR T.cklow_score NOT LIKE '%Q12%'
            OR T.cklow_score NOT LIKE '%Q13%')
            AND T.rq14 >= 9999
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
            AND NOT (T.cklow_score NOT LIKE '%Q1%'
            OR T.cklow_score NOT LIKE '%Q2%'
            OR T.cklow_score NOT LIKE '%Q3%'
            OR T.cklow_score NOT LIKE '%Q5%'
            OR T.cklow_score NOT LIKE '%Q9%'
            OR T.cklow_score NOT LIKE '%Q10%'
            OR T.cklow_score NOT LIKE '%Q11%'
            OR T.cklow_score NOT LIKE '%Q12%'
            OR T.cklow_score NOT LIKE '%Q13%')
            AND T.rq14 <= 999
            ".$this->advanceSearch($Region, $Category, $Person)."
            AND T.start_time >= '".$StartTime."' 
            AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }

    ### End 取得正負評價數 ###

    ### Start 彙總分析 ###
    
    /*
    //總覽-彙總分析
    public function getSummaryTable01($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
        SELECT
            RAW.Distribution,
            RAW.Sell,
            RAW.SUM_CASE,
            ROUND(RAW.STATISFY_NUM/RAW.SUM_CASE, 2) AS STATISFY_RATE,
            ROUND(RAW.MOVING_NUM/RAW.SUM_CASE, 2) AS MOVING_RATE,
            (
                ROUND(RAW.Q13_0_6_NUM/RAW.SUM_CASE, 2) - ROUND(RAW.Q13Big9_NUM/RAW.SUM_CASE, 2)
            ) AS NPS_RATE
        FROM
        (
        SELECT  
        SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
        SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
        SUM(
            CASE 
                WHEN T.s_person IS NOT NULL THEN
                    1
                ELSE
                    0
            END
        ) AS SUM_CASE,
        SUM(
            CASE 
                WHEN T.q1 > '4' THEN
                    1
                ELSE
                    0
            END
        ) AS STATISFY_NUM,
        SUM(
            CASE 
                WHEN T.q1 = '5' THEN
                    1
                ELSE
                    0
            END
        ) AS MOVING_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= '0' AND T.q13 <= '6' THEN
                    1
                ELSE
                    0
            END
        ) AS Q13_0_6_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= '7' AND T.q13 <= '8' THEN
                    1
                ELSE
                    0
            END
        ) AS Q13_7_8_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= '9' THEN
                    1
                ELSE
                    0
            END
        ) AS Q13Big9_NUM

        FROM toto.rawsurvey AS T
        WHERE 1=1
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$StartTime."' 
        AND T.end_time < '".$EndTime."'

        GROUP BY T.s_person
        ORDER BY SUM_CASE DESC
        
        ) AS RAW

        ");

        return $Set;
    }
    //總覽-排名分析
    public function getSummaryTable02($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Year = explode('-', $StartTime)[0];

        $Set = DB::select("
        SELECT
            RAW.Distribution,
            RAW.Sell,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-01' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M1,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-02' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M2,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-03' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M3,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-04' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M4,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-05' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M5,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-06' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M6,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-07' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M7,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-08' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M8,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-09' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M9,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-10' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M10,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-11' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M11,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-12' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M12

        FROM
        (
        SELECT 
        SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
        SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
        T.s_person,
        DATE_FORMAT(T.start_time, '%Y-%m') AS GMonth,
        SUM(
            CASE 
                WHEN T.s_person IS NOT NULL THEN THEN
                    1
                ELSE
                    0
            END
        ) AS SUM_CASE

        FROM toto.rawsurvey AS T
        WHERE 1=1
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$Year."-01-01 00:00:00'
        AND T.end_time <= '".$Year."-12-31 23:59:59'

        GROUP BY T.s_person, DATE_FORMAT(T.start_time, '%Y-%m')
        ) AS RAW
        GROUP BY RAW.s_person
        ");

        return $Set;
    }
    */

    //客訴分析-彙總分析
    public function getSummaryTable01($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
        SELECT
            @i := @i + 1 AS Row_NO,
            RAW.Distribution,
            RAW.Sell,
            RAW.SUM_CASE,
            RAW.ACC_CASE,
            ROUND(RAW.STATISFY_NUM/RAW.SUM_CASE, 2) AS STATISFY_RATE,
            ROUND(RAW.MOVING_NUM/RAW.SUM_CASE, 2) AS MOVING_RATE,
            (
                ROUND(RAW.Q13Big9_NUM/RAW.SUM_CASE, 2) - ROUND(RAW.Q13_0_6_NUM/RAW.SUM_CASE, 2)
            ) AS NPS_RATE
        FROM
        (
        SELECT  
        SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
        SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
        SUM(
            CASE 
                WHEN (T.cklow_score LIKE '%Q1%'
                OR T.cklow_score LIKE '%Q2%'
                OR T.cklow_score LIKE '%Q3%'
                OR T.cklow_score LIKE '%Q5%'
                OR T.cklow_score LIKE '%Q9%'
                OR T.cklow_score LIKE '%Q10%'
                OR T.cklow_score LIKE '%Q11%'
                OR T.cklow_score LIKE '%Q12%'
                OR T.cklow_score LIKE '%Q13%') THEN
                    1
                ELSE
                    0
            END
        ) AS SUM_CASE,
        Q.ACC_CASE,
        SUM(
            CASE 
                WHEN T.q1 > 4 THEN
                    1
                ELSE
                    0
            END
        ) AS STATISFY_NUM,
        SUM(
            CASE 
                WHEN T.q1 = 5 THEN
                    1
                ELSE
                    0
            END
        ) AS MOVING_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= 0 AND T.q13 <= 6 THEN
                    1
                ELSE
                    0
            END
        ) AS Q13_0_6_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= 7 AND T.q13 <= 8 THEN
                    1
                ELSE
                    0
            END
        ) AS Q13_7_8_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= 9 THEN
                    1
                ELSE
                    0
            END
        ) AS Q13Big9_NUM

        FROM toto.rawsurvey AS T

        LEFT JOIN (
            SELECT 
            Q.s_person,
            SUM(
                CASE 
                    WHEN (Q.cklow_score LIKE '%Q1%'
                    OR Q.cklow_score LIKE '%Q2%'
                    OR Q.cklow_score LIKE '%Q3%'
                    OR Q.cklow_score LIKE '%Q5%'
                    OR Q.cklow_score LIKE '%Q9%'
                    OR Q.cklow_score LIKE '%Q10%'
                    OR Q.cklow_score LIKE '%Q11%'
                    OR Q.cklow_score LIKE '%Q12%'
                    OR Q.cklow_score LIKE '%Q13%') THEN
                        1
                    ELSE
                        0
                END
            ) AS ACC_CASE
            FROM toto.rawsurvey AS Q
            GROUP BY Q.s_person
        ) AS Q
        ON T.s_person = Q.s_person

        WHERE 1=1
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$StartTime."' 
        AND T.end_time < '".$EndTime."'

        GROUP BY T.s_person, Q.ACC_CASE
        ORDER BY SUM_CASE DESC
        
        ) AS RAW, (select @i := 0) temp

        ");

        return $Set;
    }
    //客訴分析-排名分析
    public function getSummaryTable02($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Year = explode('-', $StartTime)[0];

        $Set = DB::select("
        SELECT
            @i := @i + 1 AS Row_NO,
            RAW.Distribution,
            RAW.Sell,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-01' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M1,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-02' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M2,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-03' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M3,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-04' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M4,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-05' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M5,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-06' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M6,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-07' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M7,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-08' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M8,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-09' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M9,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-10' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M10,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-11' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M11,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-12' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M12

        FROM
        (
        SELECT 
        SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
        SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
        T.s_person,
        DATE_FORMAT(T.start_time, '%Y-%m') AS GMonth,
        SUM(
            CASE 
                WHEN (T.cklow_score LIKE '%Q1%'
                OR T.cklow_score LIKE '%Q2%'
                OR T.cklow_score LIKE '%Q3%'
                OR T.cklow_score LIKE '%Q5%'
                OR T.cklow_score LIKE '%Q9%'
                OR T.cklow_score LIKE '%Q10%'
                OR T.cklow_score LIKE '%Q11%'
                OR T.cklow_score LIKE '%Q12%'
                OR T.cklow_score LIKE '%Q13%') THEN
                    1
                ELSE
                    0
            END
        ) AS SUM_CASE

        FROM toto.rawsurvey AS T
        WHERE 1=1
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$Year."-01-01 00:00:00'
        AND T.end_time <= '".$Year."-12-31 23:59:59'

        GROUP BY T.s_person, DATE_FORMAT(T.start_time, '%Y-%m')
        ) AS RAW, (select @i := 0) temp
        GROUP BY RAW.s_person
        ");

        return $Set;
    }
    //讚美分析-彙總分析
    public function getSummaryTable03($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
        SELECT
            @i := @i + 1 AS Row_NO,
            RAW.Distribution,
            RAW.Sell,
            RAW.SUM_CASE,
            RAW.ACC_CASE,
            ROUND(RAW.STATISFY_NUM/RAW.SUM_CASE, 2) AS STATISFY_RATE,
            ROUND(RAW.MOVING_NUM/RAW.SUM_CASE, 2) AS MOVING_RATE,
            (
                ROUND(RAW.Q13Big9_NUM/RAW.SUM_CASE, 2) - ROUND(RAW.Q13_0_6_NUM/RAW.SUM_CASE, 2)
            ) AS NPS_RATE
        FROM
        (
        SELECT  
        SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
        SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
        SUM(
            CASE 
                WHEN T.rq14 < 999 THEN
                    1
                ELSE
                    0
            END
        ) AS SUM_CASE,
        Q.ACC_CASE,
        SUM(
            CASE 
                WHEN T.q1 > 4 THEN
                    1
                ELSE
                    0
            END
        ) AS STATISFY_NUM,
        SUM(
            CASE 
                WHEN T.q1 = 5 THEN
                    1
                ELSE
                    0
            END
        ) AS MOVING_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= 0 AND T.q13 <= 6 THEN
                    1
                ELSE
                    0
            END
        ) AS Q13_0_6_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= 7 AND T.q13 <= 8 THEN
                    1
                ELSE
                    0
            END
        ) AS Q13_7_8_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= 9 THEN
                    1
                ELSE
                    0
            END
        ) AS Q13Big9_NUM

        FROM toto.rawsurvey AS T

        LEFT JOIN (
            SELECT 
            Q.s_person,
            SUM(
                CASE 
                    WHEN Q.rq14 < 999 THEN
                        1
                    ELSE
                        0
                END
            ) AS ACC_CASE
            FROM toto.rawsurvey AS Q
            GROUP BY Q.s_person
        ) AS Q
        ON T.s_person = Q.s_person

        WHERE 1=1
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$StartTime."' 
        AND T.end_time < '".$EndTime."'

        GROUP BY T.s_person, Q.ACC_CASE
        ORDER BY SUM_CASE DESC
        
        ) AS RAW, (select @i := 0) temp

        ");

        return $Set;
    }
    //讚美分析-排名分析
    public function getSummaryTable04($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Year = explode('-', $StartTime)[0];

        $Set = DB::select("
        SELECT
            @i := @i + 1 AS Row_NO,
            RAW.Distribution,
            RAW.Sell,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-01' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M1,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-02' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M2,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-03' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M3,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-04' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M4,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-05' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M5,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-06' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M6,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-07' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M7,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-08' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M8,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-09' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M9,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-10' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M10,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-11' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M11,
        SUM(
            CASE
                WHEN RAW.GMonth = '".$Year."-12' AND RAW.SUM_CASE IS NOT NULL THEN
                    RAW.SUM_CASE
                ELSE
                    0
            END
        ) AS M12

        FROM
        (
        SELECT 
        SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
        SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
        T.s_person,
        DATE_FORMAT(T.start_time, '%Y-%m') AS GMonth,
        SUM(
            CASE 
                WHEN T.rq14 < 999 THEN
                    1
                ELSE
                    0
            END
        ) AS SUM_CASE

        FROM toto.rawsurvey AS T
        WHERE 1=1
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$Year."-01-01 00:00:00'
        AND T.end_time <= '".$Year."-12-31 23:59:59'

        GROUP BY T.s_person, DATE_FORMAT(T.start_time, '%Y-%m')
        ) AS RAW, (select @i := 0) temp
        GROUP BY RAW.s_person
        ");

        return $Set;
    }

    //建議事項-彙總分析
    public function getSummaryTable05($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
        SELECT
            @i := @i + 1 AS Row_NO,
            RAW.Distribution,
            RAW.Sell,
            RAW.SUM_CASE,
            RAW.ACC_CASE,
            ROUND(RAW.STATISFY_NUM/RAW.SUM_CASE, 2) AS STATISFY_RATE,
            ROUND(RAW.MOVING_NUM/RAW.SUM_CASE, 2) AS MOVING_RATE,
            (
                ROUND(RAW.Q13Big9_NUM/RAW.SUM_CASE, 2) - ROUND(RAW.Q13_0_6_NUM/RAW.SUM_CASE, 2)
            ) AS NPS_RATE
        FROM
        (
        SELECT  
        SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
        SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
        SUM(
            CASE 
                WHEN (T.rq14 >= 1000 OR T.rq14 <= 9998) THEN
                    1
                ELSE
                    0
            END
        ) AS SUM_CASE,
        Q.ACC_CASE,
        SUM(
            CASE 
                WHEN T.q1 > 4 THEN
                    1
                ELSE
                    0
            END
        ) AS STATISFY_NUM,
        SUM(
            CASE 
                WHEN T.q1 = 5 THEN
                    1
                ELSE
                    0
            END
        ) AS MOVING_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= 0 AND T.q13 <= 6 THEN
                    1
                ELSE
                    0
            END
        ) AS Q13_0_6_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= 7 AND T.q13 <= 8 THEN
                    1
                ELSE
                    0
            END
        ) AS Q13_7_8_NUM,
        SUM(
            CASE 
                WHEN T.q13 >= 9 THEN
                    1
                ELSE
                    0
            END
        ) AS Q13Big9_NUM

        FROM toto.rawsurvey AS T

        LEFT JOIN (
            SELECT 
            Q.s_person,
            SUM(
                CASE 
                    WHEN (Q.rq14 >= 1000 OR Q.rq14 <= 9998) THEN
                        1
                    ELSE
                        0
                END
            ) AS ACC_CASE
            FROM toto.rawsurvey AS Q
            GROUP BY Q.s_person
        ) AS Q
        ON T.s_person = Q.s_person

        WHERE 1=1
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$StartTime."' 
        AND T.end_time < '".$EndTime."'

        GROUP BY T.s_person, Q.ACC_CASE
        ORDER BY SUM_CASE DESC
        
        ) AS RAW, (select @i := 0) temp

        ");

        return $Set;
    }

    //建議事項-建議事項
    public function getSummaryTable06($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
        SELECT  
            @i := @i + 1 AS Row_NO,
            T.start_time AS Start_Time,
            SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
            SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
            T.s_person,
            T.q14

        FROM toto.rawsurvey AS T, (select @i := 0) temp

        WHERE 1=1
        AND (T.rq14 >= 1000 OR T.rq14 <= 9998)
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$StartTime."' 
        AND T.end_time < '".$EndTime."'

        GROUP BY T.start_time, T.s_person, T.q14
        ORDER BY T.start_time ASC
        ");

        return $Set;
    }
    ### End 彙總分析 ###

    ### 低分示警頁面表格 ###

    public function getLowScoreTable01($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
        SELECT
        @i := @i + 1 as Row_NO,
        Result.acceptance_code,
        Result.start_time,
        Result.created_at,
        Result.Distribution,
        Result.Sell,
        CONCAT(Result.Q1,Result.Q2,
        Result.Q3,Result.Q5,Result.Q9,Result.Q11,Result.Q12,Result.Q13) AS Complain,
        Result.Bad_Score,
        Result.Q1_Score AS Q1_Score,
        Result.Q13_Score AS Q13_Score,
        Result.Customer_Comment AS Customer_Comment,
        Result.Sir_Commend AS Sir_Commend
        FROM
        (
        SELECT 
        T.acceptance_code,
        T.start_time,
        T.created_at,
        SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
        SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
        (
            CASE
                WHEN T.q1 < 2 THEN
                    CONCAT(CONCAT('Q1.請問您對本次TOTO「售後維修服務」的整體滿意程度為何？(', T.q1),')<br>')
                ELSE
                    ' '
                END
        ) AS Q1,
        (
            CASE
                WHEN T.q2 < 2 THEN
                    CONCAT(CONCAT('Q2.請問您對本次0800接聽及應對服務品質的滿意程度為何？(', T.q2),')<br>')
                ELSE
                    ' '
                END
        ) AS Q2,
        (
            CASE
                WHEN T.q3 < 2 THEN
                    CONCAT(CONCAT('Q3.請問您對於本次維修安排速度的滿意程度為何？(', T.q3),')<br>')
                ELSE
                    ' '
                END
        ) AS Q3,
        (
            CASE
                WHEN T.q5 < 2 THEN
                    CONCAT(CONCAT('Q5.請問您對維修人員服務態度的滿意程度為何？(', T.q5),')<br>')
                ELSE
                    ' '
                END
        ) AS Q5,
        (
            CASE
                WHEN T.q9 < 2 THEN
                    CONCAT(CONCAT('Q9.請問您對維修人員說明講解故障的原因滿意程度為何？(', T.q9),')<br>')
                ELSE
                    ' '
                END
        ) AS Q9,
        (
            CASE
                WHEN T.q11 < 2 THEN
                    CONCAT(CONCAT('Q11.請問您對維修人員在維修完成後拆換下的零件處理的滿意程度為何？(', T.q11),')<br>')
                ELSE
                    ' '
                END
        ) AS Q11,
        (
            CASE
                WHEN T.q12 < 2 THEN
                    CONCAT(CONCAT('Q12.請問您對維修人員在維修完成後現場清潔的滿意程度為何？(', T.q12),')<br>')
                ELSE
                    ' '
                END
        ) AS Q12,
        (
            CASE
                WHEN T.q13 < 4 THEN
                    CONCAT(CONCAT('Q13.請問您未來會向您的親朋好友推薦TOTO的意願程度為何呢？(', T.q13),')<br>')
                ELSE
                    ' '
                END
        ) AS Q13,
        LEAST(T.q1,T.q2,T.q3) AS Bad_Score,
        T.q1 AS Q1_Score,
        T.q13 AS Q13_Score,
        T.q14 AS Customer_Comment,
        T.sircommend AS Sir_Commend

        FROM toto.rawsurvey as T
        WHERE 1=1
        AND ( T.q1 < 2
            OR T.q2 < 2
            OR T.q3 < 2
            OR T.q5 < 2
            OR T.q9 < 2
            OR T.q11 < 2
            OR T.q12 < 2
            OR T.q13 < 4
        )
        AND T.start_time >= '".$StartTime."' 
        AND T.end_time < '".$EndTime."'
        ) AS Result, (select @i := 0) temp
        ");

        return $Set;
    }

    public function getLowScoreTable02($StartTime, $EndTime, $Region=null, $Category=null, $Person=null)
    {
        $Set = DB::select("
        SELECT 
        T.acceptance_code,
        T.s_person2,
        SUBSTRING(T.s_person, 1, LOCATE('-', T.s_person)-1) AS Distribution,
        SUBSTRING(T.s_person, LOCATE('-', T.s_person)+1, LENGTH(T.s_person) ) AS Sell,
        T.start_time,
        T.created_at,
        T.s1,
        T.q1,
        T.q2,
        T.q3,
        T.q4,
        T.q5,
        T.q6,
        T.q7,
        T.q9,
        T.q10,
        T.q11,
        T.q12,
        T.q13,
        T.q14

        FROM toto.rawsurvey as T
        WHERE 1=1
        AND ( T.q1 < 2
            OR T.q2 < 2
            OR T.q3 < 2
            OR T.q5 < 2
            OR T.q9 < 2
            OR T.q11 < 2
            OR T.q12 < 2
            OR T.q13 < 4
        )
        ".$this->advanceSearch($Region, $Category, $Person)."
        AND T.start_time >= '".$StartTime."' 
        AND T.end_time < '".$EndTime."'
        ");

        return $Set;
    }
    

}