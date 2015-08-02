<?php

namespace App\Http\Controllers;

use App\Order;
use App\Quotations;

use App\Http\Requests;
use App\Sales;

class BillController extends Controller
{

    public function index()
    {
        $bill = Quotations::where('quo_id',\Input::get('quo_id'))
            ->with('course','Customer','User','Branch')->get();

     //return response()->json($bill);

         return view("bill/bill",['bill' => $bill[0]]);
    }

    public function product(){

        $sales = Sales::where('sales_id',\Input::get('sales_id'))
            ->with('product','Customer','User','Branch')->get()->first();

        // return response()->json($sales);

      return view("bill/billproduct",['sales' => $sales]);

    }

    public function order(){
        $order = Order::where('order_id',\Input::get('order_id'))
            ->with('product','vendor','branch')->get()->first();
        //return response()->json($order);
        return view("bill/order",['order' => $order]);

    }

}
