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
            AND T.q8 = 1
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
            AND T.q8 = 2
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