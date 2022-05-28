<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => ['api', 'cors'],
], function ($router) {
    ###首頁API###
    Route::post('/get-post-num', 'APIController@getPostNum'); //取得發送數
    Route::post('/get-resp-num', 'APIController@getRespNum'); //取得回覆數
    Route::post('/get-low-score-num', 'APIController@getLScoreNum'); //取得低分數量
    Route::post('/get-q1-rate', 'APIController@getQ1Rate'); //取得滿意度(Q1)百分比Chart
    Route::post('/get-q1-rate-chart', 'APIController@getQ1RateChart'); //滿意度Chart
    Route::post('/get-q1-five-rate-chart', 'APIController@getQ1FiveRateChart'); //感動率Chart
    Route::post('/get-nps-bar-chart', 'APIController@getNPSBarChart'); //NPS
    Route::post('/get-comments-bar-chart', 'APIController@getCommentsChart'); //取得正負評價數
    Route::post('/get-lowscore-bar-chart', 'APIController@getLowScoreChart'); //低分示警件數
    Route::post('/get-sms-bar-chart', 'APIController@getSMSChart'); //簡訊數相關
    Route::post('/get-nps-pie-chart', 'APIController@getNPSPieChart'); //NPS圓餅
    Route::post('/get-q1-five-rate-pie-chart', 'APIController@getQ1FiveRatePieChart'); //感動率Pie Chart

    ###統計頁API###
    Route::post('/statistics/getChart1', 'StatisticsController@getChart1');      //滿意度 Line Chart
    Route::post('/statistics/getChart2', 'StatisticsController@getChart2');      //感動率 Line Chart
    Route::post('/statistics/getChart3', 'StatisticsController@getChart3');      //NPS Line Chart
    Route::post('/statistics/getChart4', 'StatisticsController@getChart4');      //Q1 分數平均
    Route::post('/statistics/getChart5', 'StatisticsController@getChart5');      //Q2 分數平均
    Route::post('/statistics/getChart6', 'StatisticsController@getChart6');      //Q3 分數平均
    Route::post('/statistics/getChart7', 'StatisticsController@getChart7');      //Q5 分數平均
    Route::post('/statistics/getChart8', 'StatisticsController@getChart8');      //Q9 分數平均
    Route::post('/statistics/getChart9', 'StatisticsController@getChart9');      //Q10 分數平均
    Route::post('/statistics/getChart10', 'StatisticsController@getChart10');    //Q11 分數平均
    Route::post('/statistics/getChart11', 'StatisticsController@getChart11');    //Q12 分數平均
    Route::post('/statistics/getChart12', 'StatisticsController@getChart12');    //Q4 回答1的比例
    Route::post('/statistics/getChart13', 'StatisticsController@getChart13');    //Q6 回答9的比例
    Route::post('/statistics/getChart14', 'StatisticsController@getChart14');    //Q7 回答1的比例
    Route::post('/statistics/getTable1', 'StatisticsController@getTable1');

    ###缺失情形分析### //unsuccessful chart20隻，table1隻 //person 6隻 //timeout 1隻
    Route::post('/deficiency/unsuccessful/getChart1', 'DeficiencyController@getChart1');      
    Route::post('/deficiency/unsuccessful/getChart2', 'DeficiencyController@getChart2');      
    Route::post('/deficiency/unsuccessful/getChart3', 'DeficiencyController@getChart3');      
    Route::post('/deficiency/unsuccessful/getChart4', 'DeficiencyController@getChart4');      
    Route::post('/deficiency/unsuccessful/getChart5', 'DeficiencyController@getChart5');      
    Route::post('/deficiency/unsuccessful/getChart6', 'DeficiencyController@getChart6');      
    Route::post('/deficiency/unsuccessful/getChart7', 'DeficiencyController@getChart7');      
    Route::post('/deficiency/unsuccessful/getChart8', 'DeficiencyController@getChart8');      
    Route::post('/deficiency/unsuccessful/getChart9', 'DeficiencyController@getChart9');      
    Route::post('/deficiency/unsuccessful/getChart10', 'DeficiencyController@getChart10');    
    Route::post('/deficiency/unsuccessful/getChart11', 'DeficiencyController@getChart11');    
    Route::post('/deficiency/unsuccessful/getChart12', 'DeficiencyController@getChart12');    
    Route::post('/deficiency/unsuccessful/getChart13', 'DeficiencyController@getChart13');    
    Route::post('/deficiency/unsuccessful/getChart14', 'DeficiencyController@getChart14');    
    Route::post('/deficiency/unsuccessful/getChart15', 'DeficiencyController@getChart15');      
    Route::post('/deficiency/unsuccessful/getChart16', 'DeficiencyController@getChart16');      
    Route::post('/deficiency/unsuccessful/getChart17', 'DeficiencyController@getChart17');      
    Route::post('/deficiency/unsuccessful/getChart18', 'DeficiencyController@getChart18');      
    Route::post('/deficiency/unsuccessful/getChart19', 'DeficiencyController@getChart19');      
    Route::post('/deficiency/unsuccessful/getChart20', 'DeficiencyController@getChart20');      
    Route::post('/deficiency/person/getChart1', 'DeficiencyController@getChart21');      
    Route::post('/deficiency/person/getChart2', 'DeficiencyController@getChart22');      
    Route::post('/deficiency/person/getChart3', 'DeficiencyController@getChart23');      
    Route::post('/deficiency/person/getChart4', 'DeficiencyController@getChart24');    
    Route::post('/deficiency/person/getChart5', 'DeficiencyController@getChart25');    
    Route::post('/deficiency/person/getChart6', 'DeficiencyController@getChart26');  
    Route::post('/deficiency/timeout/getChart1', 'DeficiencyController@getChart27');   
    Route::post('/deficiency/unsuccessful/getTable1', 'DeficiencyController@getTable1');   

    Route::post('/selectLV1', 'AdvanceMenuController@selectLV1');
    Route::post('/selectLV2', 'AdvanceMenuController@selectLV2');
    Route::post('/selectLV3', 'AdvanceMenuController@selectLV3');

    Route::post('/summary/receive-category/getChart1', 'SummaryController@getChart1');
    Route::post('/summary/receive-category/getChart2', 'SummaryController@getChart2');
    Route::post('/summary/receive-category/getChart3', 'SummaryController@getChart3');
    Route::post('/summary/receive-category/getChart4', 'SummaryController@getChart4');
    Route::post('/summary/receive-category/getChart5', 'SummaryController@getChart5');
    Route::post('/summary/receive-category/getChart6', 'SummaryController@getChart6');

    Route::post('/summary/receive-category/getTable1', 'SummaryController@getTable1');
    Route::post('/summary/receive-category/getTable2', 'SummaryController@getTable2');
    Route::post('/summary/receive-category/getTable3', 'SummaryController@getTable3');
    Route::post('/summary/receive-category/getTable4', 'SummaryController@getTable4');
    Route::post('/summary/receive-category/getTable5', 'SummaryController@getTable5');
    Route::post('/summary/receive-category/getTable6', 'SummaryController@getTable6');
    Route::post('/summary/receive-category/getTable7', 'SummaryController@getTable7');

    Route::get('/lowscore/alarm/getTable1', 'LowScoreController@getTable1');
    Route::get('/lowscore/alarm/getTable2', 'LowScoreController@getTable2');
});