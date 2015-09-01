<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SystemLogsController extends Controller
{

    public function index()
    {
        $data = DB::table('system_logs')
                ->select('system_logs.branch_id','system_logs.emp_id','system_logs.logs_type','system_logs.description',
                    DB::raw('system_logs.created_at as date'))
                ->get();


       // return  response()->json($data);
     return view('log/index',['data'=> $data]);
    }


}
