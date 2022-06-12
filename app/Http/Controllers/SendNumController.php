<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SendNum;

class SendNumController extends Controller
{
    public function update(Request $req)
    {
        // $_yearMonth = $req->yearmonth;
        // $_num = $req->num;
        // $snedNum = SendNum::where('yearmonth', $_yearMonth)->firstOrFail();

        // if($snedNum != null)
        // {
        //     $snedNum->num = $req->num;
        //     $snedNum->save();
        // }
        // else 
        // {
        //     $snedNum = new SendNum();
        //     $snedNum->yearMonth = $_yearMonth;
        //     $snedNum->num = $_num;

        //     $snedNum->save();
        // }

        dd(123);
    }
}
