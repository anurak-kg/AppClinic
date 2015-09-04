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

        $mpdf = new mPDF('th');
       // $mpdf = new mPDF('th', 'A5-L');
        //$mpdf->SetDisplayMode('fullpage');
        $mpdf->ignore_invalid_utf8 = true;
        //$mpdf->useSubstitutions=false;
        //$mpdf->simpleTables = true;
        $mpdf->SetHTMLHeader();
       // $mpdf->WriteHTML(view("bill/bill", ['bill' => $bill]));

        $mpdf->WriteHTML(view("bill/newQuoBill", ['bill' => $bill]));
        $mpdf->Output('Bill.pdf', 'I');

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

        $mpdf = new mPDF('th', array(280, 140),0,0,0,0,0,0,0);
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->SetHTMLHeader();
        $mpdf->WriteHTML(view('bill.billproduct', compact('sales')));
        $mpdf->Output('Billproduct.pdf', 'I');

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
