<?php

namespace App\Imports;

use App\RawSurvey;
use App\Mail\LowScoreMail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Mail;

class TenantsImport implements ToModel,WithStartRow
{
    use Importable;

    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $q1 = $row[13];
        // $q2 = $row[14];
        // $q3 = $row[15];
        // $q5 = $row[17];
        // $q9 = $row[22];
        // $q11 = $row[24]; //lower 2 is low score case
        // $q13 = $row[26]; //lower 4 is low score case

        // if (intval($q1) <= 2 || intval($q2) <= 2 || intval($q3) <= 2 || intval($q5) <= 2
        // || intval($q9) <= 2 || intval($q11) <= 2 || intval($q13) <= 4) 
        // {

        //     $to = collect([
        //         ['name' => 'Ben', 'email' => 'benhuang0857@gmail.com']
        //     ]);
        
        //     // 提供給模板的參數
        //     $params = [
        //         'say' => '您好，這是一段測試訊息的內容'.$row[0]
        //     ];

        //     Mail::to($to)->queue(new LowScoreMail($params));
        // }

        // $to = collect([
        //     ['name' => 'Ben', 'email' => 'benhuang0857@gmail.com']
        // ]);
    
        // // 提供給模板的參數
        // $params = [
        //     'say' => '您好，這是一段測試訊息的內容'.$row[0]
        // ];

        // Mail::to($to)->queue(new LowScoreMail($params));

        if ($row[3] != null) {
            $rawData = RawSurvey::where('respondent_id',$row[1])->first();

            if ($rawData != null) {
                $rawData->respondent_serial = $row[0];
                $rawData->respondent_id = $row[1];
                $rawData->datacollection_status = $row[2];
                $rawData->start_time = $row[3];
                $rawData->end_time = $row[4];
                $rawData->interview_length = $row[5];
                $rawData->db_wave = $row[6];
                $rawData->db_interviewdate = $row[7];
                $rawData->quota_year = $row[8];
                $rawData->quota_month = $row[9];
                $rawData->quota_wave = $row[10];
                $rawData->s_info = $row[11];
                $rawData->s1 = $row[12];
                $rawData->q1 = $row[13];
                $rawData->q2 = $row[14];
                $rawData->q3 = $row[15];
                $rawData->q4 = $row[16];
                $rawData->q5 = $row[17];
                $rawData->q6 = $row[18];
                $rawData->q7 = $row[19];
                $rawData->q8 = $row[20];
                $rawData->q8_9 = $row[21];
                $rawData->q9 = $row[22];
                $rawData->q10 = $row[23];
                $rawData->q11 = $row[24];
                $rawData->q12 = $row[25];
                $rawData->q13 = $row[26];
                $rawData->q14 = $row[27];
                $rawData->rq14 = $row[28];
                $rawData->cklow_score = $row[29];
                $rawData->opinion_category = $row[30];
                $rawData->complaint1 = $row[31];
                $rawData->complaint2 = $row[32];
                $rawData->recommend = $row[33];
                $rawData->s_region = $row[34];
                $rawData->s_category = $row[35];
                $rawData->s_person2 = $row[36];
                $rawData->s_person = $row[37];
                $rawData->send_date = $row[38];
                $rawData->acceptance_code = $row[39];
                $rawData->product_code = $row[40];

                $rawData->save();
                return $rawData;
            }
            else {

                return new RawSurvey([
                    'respondent_serial' => $row[0],
                    'respondent_id' => $row[1],
                    'datacollection_status' => $row[2],
                    'start_time' => $row[3],
                    'end_time' => $row[4],
                    'interview_length' => $row[5],
                    'db_wave' => $row[6],
                    'db_interviewdate' => $row[7],
                    'quota_year' => $row[8],
                    'quota_month' => $row[9],
                    'quota_wave' => $row[10],
                    's_info' => $row[11],
                    's1' => $row[12],
                    'q1' => $row[13],
                    'q2' => $row[14],
                    'q3' => $row[15],
                    'q4' => $row[16],
                    'q5' => $row[17],
                    'q6' => $row[18],
                    'q7' => $row[19],
                    'q8' => $row[20],
                    'q8_9' => $row[21],
                    'q9' => $row[22],
                    'q10' => $row[23],
                    'q11' => $row[24],
                    'q12' => $row[25],
                    'q13' => $row[26],
                    'q14' => $row[27],
                    'rq14' => $row[28],
                    'cklow_score' => $row[29],
                    'opinion_category' => $row[30],
                    'complaint1' => $row[31],
                    'complaint2' => $row[32],
                    'recommend' => $row[33],
                    's_region' => $row[34],
                    's_category' => $row[35],
                    's_person2' => $row[36],
                    's_person' => $row[37],
                    'send_date' => $row[38],
                    'acceptance_code' => $row[39],
                    'product_code' => $row[40]
                ]);
            }
        }
    }
}
