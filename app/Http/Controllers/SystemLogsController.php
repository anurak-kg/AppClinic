<?php

namespace App\Http\Controllers;

use App\Branch;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;

class SystemLogsController extends Controller
{

    public function index()
    {
        $branch_id = Input::get('branch');
        $data = DB::table('system_logs')
                ->select('system_logs.branch_id','system_logs.emp_id','system_logs.logs_type','system_logs.description',
                    DB::raw('system_logs.created_at as date'),'users.name as name')
                ->join('users','users.id','=','system_logs.emp_id');
            if ($branch_id > 0) {
                $data->where('system_logs.branch_id', $branch_id);
            }
          $datalog = $data->get();

        $branch = Branch::all();
       // return  response()->json($data);
     return view('log/index',['data'=> $datalog],compact('index', 'branch'));
    }


}
