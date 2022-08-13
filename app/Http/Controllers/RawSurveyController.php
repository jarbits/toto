<?php

namespace App\Http\Controllers;

use App\RawSurvey;
use App\ImportLog;
use Illuminate\Http\Request;
use App\Imports\TenantsImport;
use Maatwebsite\Excel\Facades\Excel;

class RawSurveyController extends Controller
{
    public function update(Request $req)
    {
        try {
            $_acceptanceCode = $req->acceptance_code;
            $_sircommend = $req->sircommend;
            $survey = RawSurvey::where('acceptance_code', $_acceptanceCode)->first();
            
            $survey->sircommend = $_sircommend;
            $survey->save();

            $survey = RawSurvey::where('acceptance_code', $_acceptanceCode)->first();

            return json_encode($survey, JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return json_encode($th, JSON_UNESCAPED_UNICODE);
        }
        
    }

    public function get(Request $req)
    {
        try {
            $_acceptanceCode = $req->acceptance_code;
            $survey = RawSurvey::where('acceptance_code', $_acceptanceCode)->first();

            return json_encode($survey, JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return json_encode($th, JSON_UNESCAPED_UNICODE);
        }
        
    }

    public function import(Request $request) 
    {
        $request->file('file');
        $import = new TenantsImport();
        Excel::import($import, $request->file('file'));
        // $excelArray = Excel::toArray(new TenantsImport, $request->file('file'));

        $importLog = new ImportLog();
        $importLog->user = '系統人員'; // 尚未定義Request playload
        $importLog->rawdata_num = $import->getRowCount();
        $importLog->save();

        return json_encode('匯入完成！', JSON_UNESCAPED_UNICODE);
    }
}
