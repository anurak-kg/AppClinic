<?php

namespace App\Http\Controllers;

use App\Quotations;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BillController extends Controller
{

    public function index()
    {
        $bill = Quotations::find(580000)->with('course','Customer','User','Branch')->get();

       // return response()->json($bill);

        return view("bill/bill",['bill' => $bill[0]]);
    }

}
