<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MoneyController extends Controller
{

    public function index()
    {
        return view('money/manage');
    }

    public function moneyDr(){
        $rang = \Input::get('rang');
        $date = explode('to', $rang);

        $datadr =DB::table('users')
            ->select('users.id','users.name'
                ,DB::raw('(SELECT SUM(bt1_price) FROM treat_history WHERE treat_history.bt_user_id1 = id) as bt1')
                ,DB::raw('(SELECT SUM(bt2_price) FROM treat_history WHERE treat_history.bt_user_id2 = id) as bt2'))
            ->where('users.position_id','=',4);
                 if ($rang != null) {
                     $datadr->whereRaw("DATE(quotations_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
                     $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
                     $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
                 }

        $data=  $datadr->get();

        $data1 =DB::table('users')
            ->select('users.id','users.name'
                ,DB::raw('(SELECT SUM(bt1_price) FROM treat_history WHERE treat_history.bt_user_id1 = id) as bt1')
            ,DB::raw('(SELECT SUM(bt2_price) FROM treat_history WHERE treat_history.bt_user_id2 = id) as bt2'))
            ->where('users.position_id','=',8)
            ->get();


        //return response()->json($data);

        return view('money/manage',['data'=>$data,'data1'=>$data1]);
    }



}
