<?php

namespace App\Http\Controllers;

use App\Order;
use App\Quotations;

use App\Http\Requests;
use App\Sales;
use mPDF;

class BillController extends Controller
{

    public function index()
    {
        $bill = Quotations::where('quo_id',\Input::get('quo_id'))
            ->with('course','Customer','User','Branch')->get();

     //return response()->json($bill);

        $mpdf=new mPDF('th','A4-L');
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->SetHTMLHeader();
        $mpdf->WriteHTML(view("bill/bill",['bill' => $bill[0]]));
        $mpdf->Output('Bill.pdf','I');

    }

    public function product(){

        $sales = Sales::where('sales_id',\Input::get('sales_id'))
            ->with('product','Customer','User','Branch')->get()->first();

        $mpdf=new mPDF('th','A4-L');
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->SetHTMLHeader();
        $mpdf->WriteHTML(view("bill/billproduct",['sales' => $sales]));
        $mpdf->Output('Billproduct.pdf','I');


    }

    public function order(){
        $order = Order::where('order_id',1)
            ->with('product','vendor','branch','user')->get()->first();

        $mpdf=new mPDF('th','A4-L');
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->SetHTMLHeader();
        $mpdf->WriteHTML(view("bill/order",['order' => $order]));
        $mpdf->Output('Order.pdf','I');



    }

}
