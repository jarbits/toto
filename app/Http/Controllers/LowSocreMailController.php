<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LowSocreMailController extends Controller
{
    public function send()
    {
        $to = collect([
            ['name' => 'Jason', 'email' => 'benhuang0857@gmail.com']
        ]);
 
        // 提供給模板的參數
        $params = [
            'say' => '您好，這是一段測試訊息的內容'
        ];
 
        // 若要直接檢視模板
        // echo (new Warning($data))->render();die;
 
        Mail::to($to)->send("HI");
    }
}
