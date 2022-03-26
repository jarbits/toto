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
    Route::get('/get-post-num', 'APIController@getPostNum'); //取得發送數
    Route::get('/get-resp-num', 'APIController@getRespNum'); //取得回覆數
    Route::get('/get-low-score-num', 'APIController@getLScoreNum'); //取得低分數量
    Route::get('/get-q1-rate', 'APIController@getQ1Rate'); //取得滿意度(Q1)百分比Chart
    Route::get('/get-q1-rate-chart', 'APIController@getQ1RateChart'); //滿意度Chart
    Route::get('/get-q1-five-rate-chart', 'APIController@getQ1FiveRateChart'); //感動率Chart
    Route::get('/get-nps-bar-chart', 'APIController@getNPSBarChart'); //NPS
    Route::get('/get-comments-bar-chart', 'APIController@getCommentsChart'); //取得正負評價數
    Route::get('/get-lowscore-bar-chart', 'APIController@getLowScoreChart'); //低分示警件數
    Route::get('/get-sms-bar-chart', 'APIController@getSMSChart'); //簡訊數相關
    Route::get('/get-nps-pie-chart', 'APIController@getNPSPieChart'); //NPS圓餅
    Route::get('/get-q1-five-rate-pie-chart', 'APIController@getQ1FiveRatePieChart'); //感動率Pie Chart

    ###統計頁API###
    Route::get('/statistics/getChart1', 'StatisticsController@getChart1');      //滿意度 Line Chart
    Route::get('/statistics/getChart2', 'StatisticsController@getChart2');      //感動率 Line Chart
    Route::get('/statistics/getChart3', 'StatisticsController@getChart3');      //NPS Line Chart
    Route::get('/statistics/getChart4', 'StatisticsController@getChart4');      //Q1 分數平均
    Route::get('/statistics/getChart5', 'StatisticsController@getChart5');      //Q2 分數平均
    Route::get('/statistics/getChart6', 'StatisticsController@getChart6');      //Q3 分數平均
    Route::get('/statistics/getChart7', 'StatisticsController@getChart7');      //Q5 分數平均
    Route::get('/statistics/getChart8', 'StatisticsController@getChart8');      //Q9 分數平均
    Route::get('/statistics/getChart9', 'StatisticsController@getChart9');      //Q10 分數平均
    Route::get('/statistics/getChart10', 'StatisticsController@getChart10');    //Q11 分數平均
    Route::get('/statistics/getChart11', 'StatisticsController@getChart11');    //Q12 分數平均
    Route::get('/statistics/getChart12', 'StatisticsController@getChart12');    //Q4 回答1的比例
    Route::get('/statistics/getChart13', 'StatisticsController@getChart13');    //Q6 回答9的比例
    Route::get('/statistics/getChart14', 'StatisticsController@getChart14');    //Q7 回答1的比例
    Route::get('/statistics/getTable1', 'StatisticsController@getTable1');
});