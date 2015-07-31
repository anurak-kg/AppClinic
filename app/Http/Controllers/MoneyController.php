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
        $data =DB::table('treat_history')
            ->select('treat_history.dr_id','users.name',DB::raw('SUM(treat_history.dr_price) as Total'))
            ->join('users','users.id','=','treat_history.dr_id')
            ->where('users.position_id','=',4)
            ->groupby('treat_history.dr_id')
        ->get();

        $data1 =DB::table('users')
            ->select('users.id','users.name'
                ,DB::raw('(SELECT SUM(bt1_price) FROM treat_history WHERE treat_history.bt_user_id1 = id) as bt1')
            ,DB::raw('(SELECT SUM(bt2_price) FROM treat_history WHERE treat_history.bt_user_id2 = id) as bt2'))
            ->where('users.position_id','<>',4)
            ->get();


        //return response()->json($data1);

        return view('money/manage',['data'=>$data,'data1'=>$data1]);
    }



}
