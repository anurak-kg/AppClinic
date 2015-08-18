<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Payment_detail;
use App\Quotations;
use App\Http\Requests;
use App\Quotations_detail;
use App\Sales;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Payment;
use Illuminate\Support\Facades\Log;
use Session;

class PaymentController extends Controller
{
    private $input = null;
    private $amount = null;
    private $quo_id = null;
    private $payment = null;
    private $quo_detail = null;
    private $minAmountPay = null;

    public function getIndex()
    {
        $id = null;
        if (Session::get('quo_id') != null) {
            $id = Session::get('quo_id');
        } else {
            $id = Input::get('quo_id');
        }
        $quo = Quotations::where('quo_id', $id)->with('course', 'Customer', 'Quotations_detail.payment')->get()->first();
        //dd($quo);
        // return response()->json($quo);
        return view('payment.payment', compact('quo'));
    }
    public function getSalePay(){
        $sale = Sales::findOrFail(Input::get('sale_id'));
        $saleController = new SalesController();
        $saleId = $saleController->getId();
        $type = Input::get('type');
        $this->payment = new Payment();
        $this->payment->sales_id = $saleId;
        $this->payment->cus_id = $sale->cus_id;
        $total = DB::table('sales_detail')->where('sales_id',$saleId)->sum('sales_de_total') ;
        //$totalVat = $total * getConfig('vat_rate') /100;
        //$totalWithVat = $total + $totalVat;
        if($type=='cash'){
            $this->payment->payment_status ="FULLY_PAID";
            $this->payment->payment_type ='PAID_IN_FULL';
            $this->payment->save();
            $this->amount = $total;
            $this->saveCash();
            return redirect('sales/save');
        }
    }
    public function getPay()
    {
        $quo = Quotations_detail::where('quo_de_id', Input::get('quo_de_id'))->with('Course', 'payment')->get()->first();
        //return response()->json($quo);
        return view('payment.pay', compact('quo'));
    }

    public function postPay()
    {
        $this->input = Input::all();
        if ($this->input['method'] == 'PAID_IN_FULL') {
            $this->savePaidInFull();
        } elseif ($this->input['method'] == 'PAY_BY_COURSE') {
            $this->savePayPerCourse();
        }
        return redirect("payment" . "?quo_id=" . $this->quo_id)
            ->with(['headTxt' => 'เรียบร้อยแล้ว',
                    'message' => 'ลงบันทึกการชำระเงินเรียบร้อยแล้ว',
                    'quo_id' => $this->quo_id]
            );


    }

    private function savePaidInFull()
    {
        $count = Payment::where('quo_de_id', $this->input['quo_de_id'])->count();
        if ($count == 0) {
            $quo_detail = Quotations_detail::where('quo_de_id', $this->input['quo_de_id'])
                ->where('course_id', $this->input['course_id'])->get()->first();

            $quo = Quotations::find($quo_detail->quo_id);
            $this->quo_id = $quo_detail->quo_id;
            if ($quo_detail->payment_remain > $this->input['receivedAmount']) {
                abort(403, '400001 : ข้อมูลเงินสดไม่ถูกต้อง.');
            }
            if ($this->input['receivedAmount'] >= $quo_detail->payment_remain) {
                $this->amount = $quo_detail->payment_remain;
            } else {
                abort(403, '400002 : ข้อมูลเงินสดไม่ถูกต้อง.');
            }

            $this->payment = new Payment();
            $this->payment->quo_de_id = $this->input['quo_de_id'];
            $this->payment->cus_id = $quo->cus_id;
            $this->payment->payment_type = "PAID_IN_FULL";
            $this->payment->save();
            if ($this->input['type'] == "cash") {
                $this->saveCash();

            } elseif ($this->input['type'] == "credit_card") {
                $this->saveCredit();
            }
            $this->updateQuoPaymentStatus();
            $this->payment->save();


        } else {
            abort(403, '400003 : ข้อมูลเงินสดไม่ถูกต้อง.');
        }
    }

    private function savePayPerCourse()
    {
        $count = Payment::where('quo_de_id', $this->input['quo_de_id'])->count();

        $quo_detail = Quotations_detail::where('quo_de_id', $this->input['quo_de_id'])
            ->with('Course')
            ->where('course_id', $this->input['course_id'])->get()->first();
        $this->quo_id = $quo_detail->quo_id;

        $this->minAmountPay = ((int)$quo_detail->quo_de_price) / $quo_detail->Course->course_qty;
        if ($this->input['receivedAmount'] >= $this->minAmountPay) {
            $this->amount = $this->minAmountPay;
        } else {
            abort(403, '400002 : ข้อมูลเงินสดไม่ถูกต้อง.');
        }

        if ($count == 0) {

            // dd($quo_detail);
            $quo = Quotations::find($quo_detail->quo_id);
            $this->quo_id = $quo_detail->quo_id;
            $this->payment = new Payment();
            $this->payment->quo_de_id = $this->input['quo_de_id'];
            $this->payment->cus_id = $quo->cus_id;
            $this->payment->payment_type = "PAY_BY_COURSE";
            $this->payment->save();
        } else {
            $this->payment = Payment::where('quo_de_id', $this->input['quo_de_id'])->get()->first();
        }

        if ($this->input['type'] == "cash") {
            $this->saveCash();
        } elseif ($this->input['type'] == "credit_card") {
            $this->saveCredit();
        }

        $this->updateQuoPaymentStatus();
        $this->payment->save();

    }
    private function saveCash(){
        $paymentDetail = new Payment_detail();
        $paymentDetail->payment_type = 'CASH';
        $paymentDetail->payment_id = $this->payment->payment_id;
        $paymentDetail->branch_id = Branch::getCurrentId();
        $paymentDetail->emp_id = Auth::user()->getAuthIdentifier();
        $paymentDetail->amount = $this->amount;
        $paymentDetail->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->save();
    }

    private function saveCredit()
    {
        $paymentDetail = new Payment_detail();
        $paymentDetail->payment_id = $this->payment->payment_id;
        $paymentDetail->payment_type = 'CREDIT';
        $paymentDetail->branch_id = Branch::getCurrentId();
        $paymentDetail->emp_id = Auth::user()->getAuthIdentifier();
        $paymentDetail->amount = $this->amount;
        $paymentDetail->bank_id = $this->input['bank_id'];
        $paymentDetail->card_id = $this->input['card_id'];
        $paymentDetail->edc_id = $this->input['edc'];
        $paymentDetail->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->save();
    }

    private function updateQuoPaymentStatus()
    {
        $quo_detail = Quotations_detail::find($this->input['quo_de_id']);
        $quo_detail->payment_remain = $quo_detail->payment_remain - $this->amount;
        if ($quo_detail->payment_remain <= 0) {
            $quo_detail->payment_remain = 0;
            $this->payment->payment_status = 'FULLY_PAID';
        } else {
            $this->payment->payment_status = 'REMAIN';
        }
        $this->payment->save();
        $quo_detail->save();


    }


}
