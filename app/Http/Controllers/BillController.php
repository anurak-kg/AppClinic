<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Branch;
use App\Order;
use App\Payment_detail;
use App\Quotations;

use App\Http\Requests;
use App\Quotations_detail;
use App\Sales;
use Carbon\Carbon;
use DB;
use Input;
use mPDF;
use Session;

class BillController extends Controller
{
    public function rebill()
    {
        $id = null;
        if (Session::get('branch_id') != null) {
            $id = Session::get('branch_id');
        } else {
            $id = Input::get('branch_id');
        }
        /*$re = DB::table('bill', 'payment_detail')->select('bill.bill_id', 'customer.cus_name', 'bill.bill_date', 'customer.cus_id',
            'bill.total', 'bill.bill_type', 'users.branch_id', 'bill.emp_id')
            ->join('bill_detail', 'bill_detail.bill_id', '=', 'bill.bill_id')
            ->join('user', 'user.id', '=', 'bill.emp_id')
            ->join('customer', 'customer.cus_id', '=', 'bill.cus_id')
            ->where('user.branch_id', '=', 10)
            ->get();*/
        $re = Bill::where('branch_id', $id)->with('payment_detail')
            ->get()
            ->first();
        dd($re);
        //return response()->json($re);
        return view('bill/rebill', compact('re'));
    }

    public function index()
    {
        $bill = Bill::where('bill_id', \Input::get('bill_id'))
            ->with('bill_detail.payment_detail.payment.quotations_detail.Course', 'custumer')->get();

        //return response()->json($bill);

        $mpdf = new mPDF('th');
        // $mpdf = new mPDF('th', 'A5-L');
        //$mpdf->SetDisplayMode('fullpage');
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;
        $mpdf->SetHTMLHeader();
        // $mpdf->WriteHTML(view("bill/bill", ['bill' => $bill]));

        $mpdf->WriteHTML(view("bill/newQuoBill", ['bill' => $bill[0]]));
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
        $mpdf->WriteHTML(view("bill/billproduct", ['bill' => $bill]));
        $mpdf->Output('Billproduct.pdf', 'I');

    }

    public function printBillByPayment()
    {
        $payment = Input::get('pay_detail');
        //dd($payment);
        $total = 0;
        $bill = new Bill();
        $bill->branch_id = Branch::getCurrentId();
        $bill->emp_id = auth()->user()->getAuthIdentifier();
        $bill->bill_date = Carbon::now()->format('Y-m-d');
        if ($payment == null) {
            abort(403);
        } else {
            $bill->save();
            foreach ($payment as $key => $value) {
                $payment_detail = Payment_detail::findOrFail($key);
                DB::table('bill_detail')->insert([
                        'bill_id'       => $bill->bill_id,
                        'payment_de_id' => $key,
                        'created_at' => "now()"
                    ]);
                $total += $payment_detail->amount + $payment_detail->amount_vat_amount;
            }
            $bill->total = $total;
            $bill->save();
            return redirect('bill/bill?bill_id='.$bill->bill_id);
        }


        //return view('bill.billByCourse');


    }

    public function billByCourse()
    {
        $quo_detail = Input::get('quo');

        $quo_de = Quotations_detail::query();
        foreach ($quo_detail as $key => $item) {
            $quo_de->orWhere('quo_de_id', '=', $key);
        }
        $data = $quo_de->with('Course')->get();
        $quotations = Quotations::where('quo_id', '=', $data[0]->quo_id)
            ->with('Customer', 'User', 'Branch')->get()->first();
        //return response()->json(compact('quotations','data'));

        $mpdf = new mPDF('th');
        // $mpdf = new mPDF('th', 'A5-L');
        //$mpdf->SetDisplayMode('fullpage');
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;
        $mpdf->SetHTMLHeader();
        // $mpdf->WriteHTML(view("bill/bill", ['bill' => $bill]));

        $mpdf->WriteHTML(view("bill/billByCourse", compact('quotations', 'data')));
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
