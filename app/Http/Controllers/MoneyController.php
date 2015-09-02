<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Jenssegers\Date\Date;

class MoneyController extends Controller
{

    public function index()
    {
        return view('money/manage');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function moneyDr(){
        $rang = \Input::get('rang');
        $date = explode('to', $rang);
        $dateTxt = [];
        $branch_id = Input::get('branch');


        $datadr =DB::table('bt')
            ->select('bt.emp_id as id','users.name as n'
                ,DB::raw('SUM(total) as total'))
            ->join('users','users.id','=','bt.emp_id')
            ->join('treat_history','treat_history.treat_id','=','bt.treat_id')
            ->where('users.position_id','=',4)
            ->groupBy('id');
                 if ($rang != null) {
                     $datadr->whereRaw("DATE(treat_history.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
                     $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
                     $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
                 }
        if ($branch_id > 0) {
            $datadr->where('treat_history.branch_id', $branch_id);
        }

        $data=  $datadr->get();


        $data1 =DB::table('bt')
            ->select('bt.emp_id as id','users.name as n'
                ,DB::raw('SUM(total) as total'))
            ->join('users','users.id','=','bt.emp_id')
            ->join('treat_history','treat_history.treat_id','=','bt.treat_id')
            ->where('users.position_id','=',8)
            ->groupBy('id');
        if ($rang != null) {
            $data1->whereRaw("DATE(treat_history.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
        }
        if ($branch_id > 0) {
            $data1->where('treat_history.branch_id', $branch_id);
        }


        $databt=  $data1->get();

        $branch = Branch::all();

        //return response()->json($data);

        return view('money/manage',[
            'data'=>$data,
            'data1'=>$databt,
            'date' => $dateTxt,
        ], compact('moneyDr', 'branch'));
    }



}
