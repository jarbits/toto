<?php

namespace App\Imports;

use App\RawSurvey;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;

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
        dd($row);
        die();
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
