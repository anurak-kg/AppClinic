<?php

namespace App\Http\Controllers;

use App\Order;
use App\Quotations;

use App\Http\Requests;
use App\Quotations_detail;
use App\Sales;
use mPDF;

class BillController extends Controller
{

    public function index()
    {
        $bill = Quotations_detail::where('quo_de_id', \Input::get('quo_de_id'))
            ->with('course', 'Quotations.Customer', 'Quotations.User', 'Quotations.Branch')->get()->first();

        //return response()->json($bill);


        return view("bill/bill", ['bill' => $bill]);

    }

    public function product()
    {

        $sales = Sales::where('sales_id', \Input::get('sales_id'))
            ->with('product', 'Customer', 'User', 'Branch')->get()->first();


    }

    public function printBillSaleToHtml()
    {
        $sales = Sales::where('sales_id', \Input::get('sales_id'))
            ->with('product', 'Customer', 'User', 'Branch')->get()->first();
        // return response()->json($sales);
        return view('bill.billproduct', compact('sales'));
    }

    public function order()
    {
        $order = Order::where('order_id', \Input::get('order_id'))
            ->with('product', 'vendor', 'branch', 'user')->get()->first();

//        $mpdf = new mPDF('th', 'A4');
//        $mpdf->ignore_invalid_utf8 = true;
//        $mpdf->SetHTMLHeader();
//        $mpdf->WriteHTML(view("bill/order", ['order' => $order]));
//        $mpdf->Output('Order.pdf', 'I');

        return view("bill/order", ['order' => $order]);
    }

    public function request()
    {
        $order = Order::where('order_id', \Input::get('order_id'))
            ->with('product', 'vendor', 'branch', 'user')->get()->first();

//        $mpdf = new mPDF('th', 'A4');
//        $mpdf->ignore_invalid_utf8 = true;
//        $mpdf->SetHTMLHeader();
//        $mpdf->WriteHTML(view("bill/order", ['order' => $order]));
//        $mpdf->Output('Order.pdf', 'I');

        return view("bill.request", ['order' => $order]);
    }

}
