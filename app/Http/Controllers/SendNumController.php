<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SendNum;

class SendNumController extends Controller
{
    public function update(Request $req)
    {
        try {
            $_yearMonth = $req->yearmonth;
            $_num = $req->num;
            $snedNum = SendNum::where('yearmonth', $_yearMonth)->first();

            if($snedNum != null)
            {
                $snedNum->num = $req->num;
                $snedNum->save();
            }
            else 
            {
                $snedNum = new SendNum();
                $snedNum->yearMonth = $_yearMonth;
                $snedNum->num = $_num;

                $snedNum->save();
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
            $snedNum = SendNum::where('yearmonth', $_yearMonth)->first();

            if($snedNum != null)
            {
                return json_encode(['value' => $snedNum->num], JSON_UNESCAPED_UNICODE);
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
