<?php

namespace App\Admin\Actions\Tenant;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;
use App\Imports\TenantsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportTenant extends Action
{
    protected $selector = '.import-tenant';

    public function handle(Request $request)
    {
        // $request ...
        $request->file('file');
        Excel::import(new TenantsImport, $request->file('file'));
        return $this->response()->success('匯入完成！')->refresh();
    }

    public function form()
    {
        $this->file('file', '請選擇檔案');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default import-tenant">匯入資料</a>
HTML;
    }
}