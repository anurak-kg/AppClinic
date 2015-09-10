<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Order;
use App\Quotations;

use App\Http\Requests;
use App\Quotations_detail;
use App\Sales;
use Input;
use mPDF;
use Session;

class BillController extends Controller
{
    public function rebill(){
        $id = null;
        if (Session::get('branch_id') != null) {
            $id = Session::get('branch_id');
        } else {
            $id = Input::get('branch_id');
        }
        $re = Bill::where('branch_id', $id)->with('payment')
            ->get()
            ->first();
        dd($re);
        //return response()->json($re);
        return view('bill/rebill', compact('re'));
    }
    public function index()
    {
        $bill = Quotations_detail::where('quo_de_id', \Input::get('quo_de_id'))
            ->with('course', 'Quotations.Customer', 'Quotations.User', 'Quotations.Branch')->get()->first();

        //return response()->json($bill);

        $mpdf = new mPDF('th');
       // $mpdf = new mPDF('th', 'A5-L');
        //$mpdf->SetDisplayMode('fullpage');
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->useSubstitutions=false;
        $mpdf->simpleTables = true;
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
        $bill = Sales::where('sales_id', \Input::get('sales_id'))
            ->with('product', 'Customer', 'User', 'Branch')->get()->first();
         //return response()->json($bill);


        $mpdf = new mPDF('th');
        //$mpdf = new mPDF('th', array(280, 140),0,0,0,0,0,0,0);
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->SetHTMLHeader();
        $mpdf->WriteHTML(view("bill/billproduct", ['bill'=>$bill]));
        $mpdf->Output('Billproduct.pdf', 'I');

    }
    public function billByCourse(){
        $quo_detail = Input::get('quo');

        $quo_de = Quotations_detail::query();
        foreach($quo_detail as $key => $item){
            $quo_de->orWhere('quo_de_id','=',$key);
        }
        $data = $quo_de->with('Course')->get();
        $quotations = Quotations::where('quo_id','=',$data[0]->quo_id)
            ->with('Customer','User','Branch')->get()->first();
        //return response()->json(compact('quotations','data'));

        $mpdf = new mPDF('th');
        // $mpdf = new mPDF('th', 'A5-L');
        //$mpdf->SetDisplayMode('fullpage');
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->useSubstitutions=false;
        $mpdf->simpleTables = true;
        $mpdf->SetHTMLHeader();
        // $mpdf->WriteHTML(view("bill/bill", ['bill' => $bill]));

        $mpdf->WriteHTML(view("bill/billByCourse", compact('quotations','data')));
        $mpdf->Output('Bill.pdf', 'I');

        //dd($data);
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
