<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LowSocreMailController extends Controller
{
    public function send()
    {
        Mail::to("benhuang0857@gmail.com")
          ->send("123321");

    }
}
