<?php
namespace App\Http\Controllers;

use App\Bill;
use App\Branch;
use App\Customer;
use App\Payment_bank;
use App\Payment_detail;
use App\Quotations;
use App\Http\Requests;
use App\Quotations_detail;
use App\Sales;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Payment;
use Session;

class PaymentController extends Controller
{
    private $input;
    private $amount;
    private $payment;
    private $item = [];
    private $totalPay;
    private $receivedAmount;
    private $paymentType;
    private $customer;

    public function getIndex()
    {
        $idcus = Input::get('cus_id');

        $id = null;
        if (Session::get('quo_id') != null) {
            $id = Session::get('quo_id');
        } else {
            $id = Input::get('quo_id');
        }
//        $quo = Quotations::where('quo_id', $id)->with('Quotations_detail.course','Quotations_detail.product', 'Customer', 'Quotations_detail.payment','Quotations_detail.product')->get();
        //dd($quo);

        $quo = DB::table('quotations_detail')
            ->select('quotations_detail.quo_id', 'course.course_name', 'product.product_name', 'course.course_price', 'product.product_price', 'course.course_qty'
                , 'quotations_detail.product_qty', 'quotations_detail.payment_remain', 'quotations.vat')
            ->join('quotations', 'quotations_detail.quo_id', '=', 'quotations.quo_id')
            ->leftjoin('course', 'quotations_detail.course_id', '=', 'course.course_id')
            ->leftjoin('product', 'quotations_detail.product_id', '=', 'product.product_id')
            ->where('quotations.cus_id', '=', $idcus)
            ->orwhere('quotations_detail.payment_remain', '!=', 0)
            ->orderBy('quotations_detail.quo_de_id', 'desc')
            ->get();

        //return response()->json($data);
        return view('payment.payment', compact('quo'));
    }

    public function getHistory()
    {

        $id = Input::get('cus_id');
        $quo = $this->getHistoryData($id);
        $bank = Payment_bank::all();
        $customer = Customer::findOrFail($id);
        // return response()->json($quo);
        return view('payment.paymenthistory', compact('quo', 'bank', 'customer'));
    }

    public function getDetail()
    {
        $id = Input::get('id');
        $sale = Sales::where('sales_id', $id)->with('sales_detail.product')
            ->get();
        //return response()->json($sale);
        return view('payment.salesdetail', compact('sale'));
    }

    public function getPrint()
    {
        $id = Input::get('cus_id');
        $pay = Payment::where('cus_id', $id)
            ->with('payment_detail.bill_detail', 'quotations_detail.course', 'quotations_detail.product', 'sales_detail.product')
            ->get();
        //dd($pay);
        //return response()->json($pay);
        return view('payment.printbill', compact('pay'));
    }


    public function postPay()
    {
        //Receive Data from Input
        $this->receivedAmount = Input::get('receivedAmount');
        $this->paymentType = Input::get('paymentType');
        $this->customer = Customer::findOrFail(Input::get('customer_id'));
        $this->setInput(Input::all());
        //Process
        $this->generateItemArray(Input::all());
        $this->calculateTotalPay();
        $this->checkBalance();
        //PAY
        $this->pay();

        //View
    }

    private function pay()
    {
        DB::transaction(function () {
            $this->createPayment();

            foreach ($this->item as $item) {
                $this->paymentDetailSave($item);
                $this->updateQuoPaymentStatus($item['quo_de_id'], $item['amount']);
            }

        });
    }

    private function calculateTotalPay()
    {
        $total = 0;
        foreach ($this->item as $item) {
            $total += $item['amount'];
        }
        $this->totalPay = $total;
    }

    private function generateItemArray($input)
    {
        $pay = $input['pay'];
        $product_amount = $input['value'];
        $type = $input['type'];
        $this->item = [];
        foreach ($pay as $id => $value) {
            $array = [];
            $array['quo_de_id'] = $id;
            $array['amount'] = $product_amount[$id];

            if ($type[$id] != null) {
                $array['payment_type'] = $type[$id];
            } else {
                $array['payment_type'] = "PAID_IN_FULL";
            }
            array_push($this->item, $array);
        }

    }

    private function paymentDetailSave($item)
    {
        $quo_detail = Quotations_detail::findOrFail($item['quo_de_id']);
        $paymentDetail = new Payment_detail();
        $paymentDetail->payment_id = $this->payment->payment_id;
        $paymentDetail->quo_de_id = $quo_detail->quo_de_id;
        $paymentDetail->payment_type = $item['payment_type'];
        $paymentDetail->amount = $item['amount'];
        //$paymentDetail->vat_amount = $this->getVat();
        $paymentDetail->save();
    }

    private function checkBalance()
    {
        if ($this->totalPay > $this->receivedAmount) {
            abort('400');
        }
    }

    private function createPayment()
    {
        $this->payment = new Payment();
        $this->payment->payment_id = getNewPaymentPK();
        $this->payment->amount = $this->receivedAmount;
        $this->payment->branch_id = Branch::getCurrentId();
        $this->payment->cus_id = $this->customer->cus_id;

        if ($this->paymentType == "CASH") {
            $this->payment->payment_type = "CASH";
        } else if ($this->paymentType == "CREDIT") {
            $this->payment->payment_type = "CREDIT";
            $this->payment->bank_id = $this->input['bank_id'];
            $this->payment->card_id = $this->input['card_id'];
            $this->payment->edc_id = $this->input['edc'];
        }

        $this->payment->emp_id = Auth::user()->getAuthIdentifier();
        $this->payment->save();
    }


    private function updateQuoPaymentStatus($quo_de_id, $amount)
    {
        $quo_detail = Quotations_detail::find($quo_de_id);
        $quo_detail->payment_remain = $quo_detail->payment_remain - $amount;
        if ($quo_detail->payment_remain <= 0) {
            $quo_detail->payment_remain = 0;
        }
        $quo_detail->save();
    }


    private function getHistoryData($id)
    {
        return DB::table('quotations_detail')
            ->select('quotations_detail.quo_id', 'quotations_detail.quo_de_id',
                'course.course_name', 'course.course_price', 'course.course_qty',
                'product.product_name', 'product.product_price', 'product.product_unit',
                'quotations_detail.product_qty', 'quotations_detail.payment_remain', 'quotations_detail.net_price',
                'quotations.vat')
            ->join('quotations', 'quotations_detail.quo_id', '=', 'quotations.quo_id')
            ->leftjoin('course', 'quotations_detail.course_id', '=', 'course.course_id')
            ->leftjoin('product', 'quotations_detail.product_id', '=', 'product.product_id')
            ->where('quotations.cus_id', '=', $id)
            ->where('quotations_detail.payment_remain', '!=', 0)
            ->orderBy('quotations_detail.quo_de_id', 'desc')
            ->get();
    }

    private function setInput($all)
    {
        $this->input = $all;
    }


}