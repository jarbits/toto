<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImportLog;

class ImportLogController extends Controller
{
    public function getall()
    {
        return json_encode(ImportLog::all(), JSON_UNESCAPED_UNICODE);
    }
}
