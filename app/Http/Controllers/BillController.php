<?php

namespace App\Http\Controllers;

use App\Quotations;

use App\Http\Requests;

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

        $product = Sale::where('sales_id',\Input::get('sales_id'))
            ->with('product','Customer','User','Branch')->get();

        return response()->json($product);

    }

}
