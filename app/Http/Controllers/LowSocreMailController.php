<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LowSocreMailController extends Controller
{
    public function ship()
    {
        Mail::to("benhuang0857@gmail.com")
          ->send("123321");

    }
}
