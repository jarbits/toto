<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FixNum;

class FixNumController extends Controller
{
    public function update(Request $req)
    {
        try {
            $_yearMonth = $req->yearmonth;
            $_num = $req->num;
            $fixNum = FixNum::where('yearmonth', $_yearMonth)->first();

            if($fixNum != null)
            {
                $fixNum->num = $req->num;
                $fixNum->save();
            }
            else 
            {
                $fixNum = new FixNum();
                $fixNum->yearMonth = $_yearMonth;
                $fixNum->num = $_num;

                $fixNum->save();
            }

            return json_encode('success', JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return json_encode($th, JSON_UNESCAPED_UNICODE);
        }
        
    }

    public function get(Request $req)
    {
        try {
            $_yearMonth = $req->yearmonth;
            $fixNum = FixNum::where('yearmonth', $_yearMonth)->first();

            if($fixNum != null)
            {
                return json_encode(['value' => $fixNum->num], JSON_UNESCAPED_UNICODE);
            }
            else 
            {
                return json_encode(['value' => 0], JSON_UNESCAPED_UNICODE);
            }
        } catch (\Throwable $th) {
            return json_encode(['value' => 0, 'error' => $th], JSON_UNESCAPED_UNICODE);
        }
        
    }
}
