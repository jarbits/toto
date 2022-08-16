<p>
主旨：{{ $params['s_region'] }} 低分示警通知<BR>
※本通知系統自動發送請勿回覆！<BR>
親愛的主管您好：<BR>
僅通知本次上傳 竹苗區({{ $params['s_region'] }}) 低分示警資料如下表，請至資料分析平台進行「主管回覆」填寫<BR>
如已經填寫完成請忽略本通知，謝謝！<BR>
</p>

<table border=1>
    <tr>
        <th>受理編號</th>
        <th>發送日期</th>
        <th>示警日期</th>
        <th>客服中心</th>
        <th>售服員</th>
        <!-- <th>客訴項目</th> -->
        <th>最低評分</th>
        <th>整體評分</th>
        <th>推薦意願</th>
        <th>客戶意見</th>
    </tr>
    <tr>
        <td>{{ $params['t1'] }}</td>
        <td>{{ $params['t2'] }}</td>
        <td>{{ $params['t3'] }}</td>
        <td>{{ $params['t4'] }}</td>
        <td>{{ $params['t5'] }}</td>
        <!-- <td>{{ $params['t6'] }}</td> -->
        <td>{{ $params['t7'] }}</td>
        <td>{{ $params['t8'] }}</td>
        <td>{{ $params['t9'] }}</td>
        <td>{{ $params['t10'] }}</td>
    </tr>
</table>