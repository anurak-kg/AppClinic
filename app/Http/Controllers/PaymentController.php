<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Payment_detail;
use App\Quotations;
use App\Http\Requests;
use App\Quotations_detail;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Payment;
use Illuminate\Support\Facades\Log;
use Session;

class PaymentController extends Controller
{
    private $input = null;
    private $amount = null;
    private $quo_id = null;

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

    public function getPay()
    {
        $quo = Quotations_detail::where('quo_de_id',Input::get('quo_de_id'))->with('Course')->get()->first();
        //return response()->json($quo);
        return view('payment.pay', compact('quo'));

    }

    public function postPay()
    {
        $this->input = Input::all();
        if ($this->input['method'] == 'PAID_IN_FULL') {
            $this->savePaidInFull();
        }
        return redirect('payment')
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

            $payment = new Payment();
            $payment->quo_de_id = $this->input['quo_de_id'];
            $payment->cus_id = $quo->cus_id;
            $payment->payment_type = "PAID_IN_FULL";
            $payment->save();
            if ($this->input['type'] == "cash") {
                $paymentDetail = new Payment_detail();
                $paymentDetail->payment_id = $payment->payment_id;
                $paymentDetail->branch_id = Branch::getCurrentId();
                $paymentDetail->emp_id = Auth::user()->getAuthIdentifier();
                $paymentDetail->amount = $this->input['receivedAmount'];
                $paymentDetail->created_at = \Carbon\Carbon::now()->toDateTimeString();
                $paymentDetail->updated_at = \Carbon\Carbon::now()->toDateTimeString();
                $paymentDetail->save();
                $this->updateQuoPaymentStatus();

            } elseif ($this->input['type'] == "credit_card") {
                $paymentDetail = new Payment_detail();
                $paymentDetail->payment_id = $payment->payment_id;
                $paymentDetail->payment_type = 'CREDIT';
                $paymentDetail->branch_id = Branch::getCurrentId();
                $paymentDetail->emp_id = Auth::user()->getAuthIdentifier();
                $paymentDetail->amount = $this->input['receivedAmount'];
                $paymentDetail->bank_id = $this->input['bank_id'];
                $paymentDetail->card_id = $this->input['card_id'];
                $paymentDetail->edc_id = $this->input['edc'];
                $paymentDetail->created_at = \Carbon\Carbon::now()->toDateTimeString();
                $paymentDetail->updated_at = \Carbon\Carbon::now()->toDateTimeString();
                $paymentDetail->save();
                $this->updateQuoPaymentStatus();
            }
            $payment->payment_status = "FULLY_PAID";
            $payment->save();


        }
    }

    private function updateQuoPaymentStatus()
    {
        $quo_detail = Quotations_detail::find($this->input['quo_de_id']);
        $quo_detail->payment_remain = $quo_detail->payment_remain - $this->amount;
        if ($quo_detail->payment_remain <= 0) {
            $quo_detail->payment_remain = 0;
            $quo_detail->save();
        }

    }


}
