<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowScoreMail;

class LowSocreMailController extends Controller
{
    public function send()
    {
        $to = collect([
            ['name' => 'Ben', 'email' => 'benhuang0857@gmail.com']
        ]);
 
        // 提供給模板的參數
        $params = [
            'say' => '您好，這是一段測試訊息的內容'
        ];
 
        // 若要直接檢視模板
        // echo (new Warning($data))->render();die;
 
        Mail::to($to)->send(new LowScoreMail($params));

        // Mail::raw('測試使用 Laravel 5 的 Mailgun 寄信服務', function($message)
        // {
        //     $message->to('benhuang0857@gmail.com');
        // });
    }
}
